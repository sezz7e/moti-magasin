<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\PageView;
use App\Support\StoreAnalytics;
use Carbon\CarbonInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTrafficTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_pages_count_as_one_visitor(): void
    {
        $first = $this->browser()->get('/about')->assertOk();
        $session = $first->getCookie(config('session.cookie'), decrypt: false);

        $this->browser()
            ->withUnencryptedCookie($session->getName(), $session->getValue())
            ->get('/')
            ->assertOk();

        $this->assertDatabaseCount('page_views', 2);
        $this->assertSame(['/about', '/'], PageView::query()->orderBy('id')->pluck('path')->all());
        $this->assertCount(1, PageView::query()->pluck('visitor_hash')->unique());

        $analytics = app(StoreAnalytics::class);
        $this->assertSame(1, $analytics->visitorsOn(today()));
        $this->assertSame(2, $analytics->pageViewsOn(today()));
    }

    public function test_admin_bots_and_background_requests_are_ignored(): void
    {
        $this->browser()->get('/admin/login')->assertOk();
        $this->browser()->withHeader('User-Agent', 'Mozilla/5.0 (compatible; Googlebot/2.1)')
            ->get('/about')
            ->assertOk();
        $this->browser()->withHeader('Purpose', 'prefetch')->get('/about')->assertOk();
        $this->getJson('/search/suggest?q=a')->assertOk();
        $this->withSession(['_token' => 'test-token'])
            ->postJson('/cart/note', ['note' => 'Gift wrap'], ['X-CSRF-TOKEN' => 'test-token'])
            ->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public function test_daily_and_monthly_totals_include_only_their_range(): void
    {
        $this->pageView(str_repeat('a', 64), '/', today());
        $this->pageView(str_repeat('a', 64), '/shop', today());
        $this->pageView(str_repeat('b', 64), '/', today());
        $this->pageView(str_repeat('c', 64), '/about', now()->startOfMonth()->subMonth());

        $analytics = app(StoreAnalytics::class);

        $this->assertSame(2, $analytics->visitorsOn(today()));
        $this->assertSame(3, $analytics->pageViewsOn(today()));

        $daily = $analytics->dailyVisitors(now()->subDays(6), today());
        $this->assertCount(7, $daily['labels']);
        $this->assertSame(2, $daily['visitors'][6]);

        $monthly = $analytics->monthlyVisitors(now()->startOfMonth()->subMonths(11), today());
        $this->assertCount(12, $monthly['labels']);
        $this->assertSame(2, $monthly['visitors'][11]);
        $this->assertSame(1, $monthly['visitors'][10]);
    }

    public function test_sales_totals_skip_cancelled_orders(): void
    {
        $this->order(1200, now(), 'pending');
        $this->order(500, now()->startOfMonth()->subMonth()->addDay(), 'pending');
        $this->order(900, now(), 'cancelled');

        $analytics = app(StoreAnalytics::class);
        $month = $analytics->salesBetween(now()->startOfMonth(), now());

        $this->assertSame(1, $month['orders']);
        $this->assertSame(1200, $month['revenue']);

        $daily = $analytics->dailyRevenue(now()->subDays(6), today());
        $this->assertSame(1200, $daily['revenue'][6]);

        $monthly = $analytics->monthlyRevenue(now()->startOfMonth()->subMonths(11), today());
        $this->assertCount(12, $monthly['labels']);
        $this->assertSame(1200, $monthly['revenue'][11]);
        $this->assertSame(500, $monthly['revenue'][10]);
    }

    private function browser(): static
    {
        return $this->withHeader('User-Agent', 'Mozilla/5.0');
    }

    private function pageView(string $visitorHash, string $path, CarbonInterface $day): void
    {
        PageView::query()->create([
            'visitor_hash' => $visitorHash,
            'path' => $path,
            'visited_on' => $day->toDateString(),
        ]);
    }

    private function order(int $total, CarbonInterface $createdAt, string $status): void
    {
        Order::query()->create([
            'order_number' => 'MM-'.$status.'-'.$total.'-'.$createdAt->timestamp,
            'customer_name' => 'Ayesha',
            'phone' => '03001234567',
            'address' => 'Street 1',
            'city' => 'Karachi',
            'subtotal' => $total,
            'shipping' => 0,
            'total' => $total,
            'status' => $status,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
    }
}
