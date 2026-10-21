<?php

namespace App\Filament\Widgets;

use App\Support\StoreAnalytics;
use Filament\Widgets\ChartWidget;

class SalesChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Sales';

    protected ?string $description = 'Revenue in PKR. Cancelled orders are excluded.';

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        $this->filter ??= '30';

        parent::mount();
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * @return array<string, string>|null
     */
    protected function getFilters(): ?array
    {
        return [
            '7' => 'Last 7 days',
            '30' => 'Last 30 days',
            '12' => 'Last 12 months',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $series = app(StoreAnalytics::class)->revenueSeries($this->filter ?? '30');

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (PKR)',
                    'data' => $series['revenue'],
                ],
            ],
            'labels' => $series['labels'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
