<?php

namespace App\Filament\Widgets;

use App\Models\Progress;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class ProgressChart extends ChartWidget
{
    protected static ?string $heading = 'Progress';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = Trend::query(Progress::where('user_id', Auth::id()))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perday()
            ->max('current_weight');

        return [
            'datasets' => [
                [
                    'label' => 'Weight',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
