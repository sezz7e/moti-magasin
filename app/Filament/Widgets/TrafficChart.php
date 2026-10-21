<?php

namespace App\Filament\Widgets;

use App\Support\StoreAnalytics;
use Filament\Widgets\ChartWidget;

class TrafficChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Visitors';

    protected ?string $description = 'Unique browsers on the shop, once per day.';

    protected ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        $this->filter ??= '30';

        parent::mount();
    }

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * @return array<string, string>|null
     */
    protected function getFilters(): ?array
    {
        return $this->periodFilters();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $series = app(StoreAnalytics::class)->visitorSeries($this->filter ?? '30');

        return [
            'datasets' => [
                [
                    'label' => 'Visitors',
                    'data' => $series['visitors'],
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
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function periodFilters(): array
    {
        return [
            '7' => 'Last 7 days',
            '30' => 'Last 30 days',
            '12' => 'Last 12 months',
        ];
    }
}
