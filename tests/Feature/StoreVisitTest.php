<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\PageView;
use App\Support\StoreAnalytics;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreVisitTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_page_records_one_visit(): void
    {
        $this->get('/about')->assertOk();

        $this->assertDatabaseCount('page_views', 1);
        $this->assertDatabaseHas('page_views', [
            'path' => '/about',
            'visited_on' => now()->toDateString(),
        ]);
    }

    public function test_admin_bot_and_prefetch_requests_are_not_counted(): void
    {
        $this->get('/admin/login')->assertOk();
        $this->withHeader('User-Agent', 'Mozilla/5.0 (compatible; Googlebot/2.1)')
            ->get('/about')
            ->assertOk();
        $this->withHeader('Purpose', 'prefetch')->get('/shop')->assertOk();

        $this->assertDatabaseCount('page_views', 0);
    }

    public function test_repeat_visits_from_one_browser_count_as_one_visitor(): void
    {
        $hash = str_repeat('a', 64);

        PageView::query()->create([
            'visitor_hash' => $hash,
            'path' => '/',
            'visited_on' => now()->toDateString(),
        ]);
        PageView::query()->create([
            'visitor_hash' => $hash,
            'path' => '/shop',
            'visited_on' => now()->toDateString(),
        ]);

        $analytics = app(StoreAnalytics::class);

        $this->assertSame(1, $analytics->visitorsOn(now()));
        $this->assertSame(2, $analytics->pageViewsOn(now()));
    }

    public function test_daily_visitor_series_keeps_days_with_no_traffic(): void
    {
        PageView::query()->create([
            'visitor_hash' => str_repeat('b', 64),
            'path' => '/',
            'visited_on' => now()->toDateString(),
        ]);

        $series = app(StoreAnalytics::class)->dailyVisitors(now()->subDays(2), now());

        $this->assertSame([0, 0, 1], $series['visitors']);
        $this->assertCount(3, $series['labels']);
    }

    public function test_cancelled_orders_are_left_out_of_revenue(): void
    {
        $this->order(1200, 'pending');
        $this->order(5000, 'cancelled');

        $sales = app(StoreAnalytics::class)->salesBetween(now()->startOfMonth(), now());

        $this->assertSame(1, $sales['orders']);
        $this->assertSame(1200, $sales['revenue']);
    }

    private function order(int $total, string $status): void
    {
        Order::query()->create([
            'order_number' => 'MM-'.$status.'-'.$total,
            'customer_name' => 'Ayesha',
            'phone' => '03001234567',
            'address' => 'Street 1',
            'city' => 'Karachi',
            'subtotal' => $total,
            'shipping' => 0,
            'total' => $total,
            'status' => $status,
        ]);
    }
}
