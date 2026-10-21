<?php

namespace App\Support;

use App\Models\Order;
use App\Models\PageView;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class StoreAnalytics
{
    public function record(Request $request): void
    {
        $sessionId = $request->hasSession() ? $request->session()->getId() : '';

        if ($sessionId === '') {
            return;
        }

        $referrer = $request->headers->get('referer');
        $host = is_string($referrer) ? parse_url($referrer, PHP_URL_HOST) : null;

        PageView::query()->create([
            'visitor_hash' => hash_hmac('sha256', $sessionId, (string) config('app.key')),
            'path' => '/'.ltrim($request->path(), '/'),
            'referrer_host' => is_string($host) && $host !== '' ? mb_substr($host, 0, 191) : null,
            'visited_on' => now()->toDateString(),
        ]);
    }

    public function visitorsOn(CarbonInterface $day): int
    {
        return $this->visitorsBetween($day, $day);
    }

    public function visitorsBetween(CarbonInterface $start, CarbonInterface $end): int
    {
        return (int) PageView::query()
            ->whereBetween('visited_on', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('count(distinct visitor_hash) as aggregate')
            ->value('aggregate');
    }

    public function pageViewsOn(CarbonInterface $day): int
    {
        return PageView::query()
            ->whereDate('visited_on', $day->toDateString())
            ->count();
    }

    /**
     * @return array{orders: int, revenue: int}
     */
    public function salesBetween(CarbonInterface $start, CarbonInterface $end): array
    {
        $row = Order::query()
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->selectRaw('count(*) as orders, coalesce(sum(total), 0) as revenue')
            ->first();

        return [
            'orders' => (int) $row->orders,
            'revenue' => (int) $row->revenue,
        ];
    }

    /**
     * @return array{labels: list<string>, visitors: list<int>}
     */
    public function visitorSeries(string $filter): array
    {
        if ($filter === '12') {
            return $this->monthlyVisitors(now()->startOfMonth()->subMonths(11), now());
        }

        $days = $filter === '7' ? 6 : 29;

        return $this->dailyVisitors(now()->subDays($days)->startOfDay(), now());
    }

    /**
     * @return array{labels: list<string>, revenue: list<int>}
     */
    public function revenueSeries(string $filter): array
    {
        if ($filter === '12') {
            return $this->monthlyRevenue(now()->startOfMonth()->subMonths(11), now());
        }

        $days = $filter === '7' ? 6 : 29;

        return $this->dailyRevenue(now()->subDays($days)->startOfDay(), now());
    }

    /**
     * @return array{labels: list<string>, visitors: list<int>}
     */
    public function dailyVisitors(CarbonInterface $start, CarbonInterface $end): array
    {
        $rows = PageView::query()
            ->whereBetween('visited_on', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('visited_on, count(distinct visitor_hash) as visitors')
            ->groupBy('visited_on')
            ->get()
            ->mapWithKeys(function (PageView $view): array {
                $day = $view->visited_on instanceof CarbonInterface
                    ? $view->visited_on->toDateString()
                    : (string) $view->visited_on;

                return [$day => (int) $view->getAttribute('visitors')];
            });

        $labels = [];
        $visitors = [];

        for ($day = $start->copy()->startOfDay(); $day->lte($end); $day->addDay()) {
            $labels[] = $day->format('M j');
            $visitors[] = (int) ($rows[$day->toDateString()] ?? 0);
        }

        return [
            'labels' => $labels,
            'visitors' => $visitors,
        ];
    }

    /**
     * @return array{labels: list<string>, visitors: list<int>}
     */
    public function monthlyVisitors(CarbonInterface $start, CarbonInterface $end): array
    {
        $counts = [];

        PageView::query()
            ->whereBetween('visited_on', [$start->copy()->startOfMonth()->toDateString(), $end->toDateString()])
            ->get(['visited_on', 'visitor_hash'])
            ->each(function (PageView $view) use (&$counts): void {
                $month = $view->visited_on->format('Y-m');
                $counts[$month][$view->visitor_hash] = true;
            });

        return $this->fillMonths($start, $end, function (string $key) use ($counts): int {
            return isset($counts[$key]) ? count($counts[$key]) : 0;
        }, 'visitors');
    }

    /**
     * @return array{labels: list<string>, revenue: list<int>}
     */
    public function dailyRevenue(CarbonInterface $start, CarbonInterface $end): array
    {
        $totals = $this->revenueBuckets($start, $end, 'Y-m-d');
        $labels = [];
        $revenue = [];

        for ($day = $start->copy()->startOfDay(); $day->lte($end); $day->addDay()) {
            $labels[] = $day->format('M j');
            $revenue[] = (int) ($totals[$day->toDateString()] ?? 0);
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
        ];
    }

    /**
     * @return array{labels: list<string>, revenue: list<int>}
     */
    public function monthlyRevenue(CarbonInterface $start, CarbonInterface $end): array
    {
        $totals = $this->revenueBuckets($start, $end, 'Y-m');

        return $this->fillMonths($start, $end, function (string $key) use ($totals): int {
            return (int) ($totals[$key] ?? 0);
        }, 'revenue');
    }

    /**
     * @return array<string, int>
     */
    private function revenueBuckets(CarbonInterface $start, CarbonInterface $end, string $format): array
    {
        $totals = [];

        Order::query()
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()])
            ->get(['created_at', 'total'])
            ->each(function (Order $order) use (&$totals, $format): void {
                $key = $order->created_at->format($format);
                $totals[$key] = ($totals[$key] ?? 0) + (int) $order->total;
            });

        return $totals;
    }

    /**
     * @param  callable(string): int  $valueForMonth
     * @return array{labels: list<string>, visitors?: list<int>, revenue?: list<int>}
     */
    private function fillMonths(CarbonInterface $start, CarbonInterface $end, callable $valueForMonth, string $valueKey): array
    {
        $labels = [];
        $values = [];

        for ($month = $start->copy()->startOfMonth(); $month->lte($end); $month->addMonth()) {
            $labels[] = $month->format('M Y');
            $values[] = $valueForMonth($month->format('Y-m'));
        }

        return [
            'labels' => $labels,
            $valueKey => $values,
        ];
    }
}
