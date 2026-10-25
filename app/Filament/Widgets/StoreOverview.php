<?php

namespace App\Filament\Widgets;

use App\Support\StoreAnalytics;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoreOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    private ?StoreAnalytics $analytics = null;

    public function boot(StoreAnalytics $analytics): void
    {
        $this->analytics = $analytics;
    }

    protected function getStats(): array
    {
        $today = now();
        $yesterday = now()->subDay();
        $analytics = $this->analytics();

        $visitorsToday = $analytics->visitorsOn($today);
        $visitorsYesterday = $analytics->visitorsOn($yesterday);
        $pageViewsToday = $analytics->pageViewsOn($today);

        $month = $analytics->salesBetween($today->copy()->startOfMonth(), $today);
        $previousMonth = $analytics->salesBetween(
            $today->copy()->subMonthNoOverflow()->startOfMonth(),
            $today->copy()->subMonthNoOverflow()->endOfMonth(),
        );

        $visitorsThisMonth = $analytics->visitorsBetween($today->copy()->startOfMonth(), $today);
        $visitorsLastMonth = $analytics->visitorsBetween(
            $today->copy()->subMonthNoOverflow()->startOfMonth(),
            $today->copy()->subMonthNoOverflow()->endOfMonth(),
        );

        $sparkline = $analytics->visitorSeries('7')['visitors'];

        return [
            $this->stat('Visitors today', number_format($visitorsToday), $visitorsToday, $visitorsYesterday, 'vs yesterday')
                ->description(number_format($pageViewsToday).' page views · '.$this->comparedWith($visitorsToday, $visitorsYesterday, 'vs yesterday'))
                ->chart($sparkline),
            $this->stat('Visitors this month', number_format($visitorsThisMonth), $visitorsThisMonth, $visitorsLastMonth, 'vs last month'),
            $this->stat('Orders this month', number_format($month['orders']), $month['orders'], $previousMonth['orders'], 'vs last month'),
            $this->stat('Revenue this month', 'PKR '.number_format($month['revenue']), $month['revenue'], $previousMonth['revenue'], 'vs last month'),
        ];
    }

    private function stat(string $label, string $value, int $current, int $previous, string $period): Stat
    {
        return Stat::make($label, $value)
            ->description($this->comparedWith($current, $previous, $period))
            ->descriptionIcon($current >= $previous ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->descriptionColor($this->trendColor($current, $previous))
            ->color($this->trendColor($current, $previous));
    }

    private function comparedWith(int $current, int $previous, string $period): string
    {
        if ($previous === 0) {
            return $current > 0 ? 'Up from zero '.$period : 'No change '.$period;
        }

        $percent = (int) round((($current - $previous) / $previous) * 100);
        $sign = $percent > 0 ? '+' : '';

        return $sign.$percent.'% '.$period;
    }

    private function trendColor(int $current, int $previous): string
    {
        if ($current === $previous) {
            return 'gray';
        }

        return $current > $previous ? 'success' : 'danger';
    }

    private function analytics(): StoreAnalytics
    {
        return $this->analytics ??= app(StoreAnalytics::class);
    }
}
