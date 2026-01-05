<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Progress;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class WeightProgressChart extends ApexChartWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
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
    protected static ?string $heading = 'Weight Progress';

    public ?string $filter = 'week';

    // use polling to refresh chart, but constantly runs checks in network
    // protected static ?string $pollingInterval = '1s';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Get the filtered data
        $query = Progress::where('user_id', auth()->id());

        $activeFilter = $this->filter;
        Log::info('Filter applied: ' . $activeFilter);

        switch ($activeFilter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                Log::info('Applying Last Week Filter');
                $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                break;
            case 'year':
                $query->whereBetween('created_at', [Carbon::now()->subYear(), Carbon::now()]);
                break;
        }

        $data = $query->orderBy('created_at', 'asc')->get();

        // Extract categories and series data
        $categories = $data->map(fn($item) => $item->created_at->format('Y-m-d'))->toArray();
        $weights = $data->pluck('current_weight')->toArray();
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Weight Progress',
                    'data' => $weights,
                ],
            ],
            'xaxis' => [
                // 'categories' => Progress::orderBy('created_at', 'asc')
                //     ->pluck('created_at')
                //     ->map(function ($date) {
                //         return \Carbon\Carbon::parse($date)->format('Y-m-d'); // Format to 'YYYY-MM-DD'
                //     })
                //     ->toArray(),
                'categories' => $categories,
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
            'colors' => ['#145da0'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
