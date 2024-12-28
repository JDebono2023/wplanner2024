<?php

namespace App\Filament\Widgets;

use App\Models\Progress;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WeightProgressChart extends ApexChartWidget
{
    protected static ?int $sort = 5;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'weightProgressChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'WeightProgressChart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'WeightProgressChart',
                    'data' => Progress::orderBy('created_at', 'asc')->pluck('current_weight')->toArray(),
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
