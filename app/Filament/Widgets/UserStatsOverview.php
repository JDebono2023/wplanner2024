<?php

namespace App\Filament\Widgets;

use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserStatsOverview extends BaseWidget
{
    protected ?string $heading = 'Overview';
    protected static ?int $sort = 2;

    // protected ?string $description = 'An overview of some analytics.';

    protected function getStats(): array
    {
        return [
            // Stat::make('Unique views', '192.1k')
            //     ->description('32k increase')
            //     ->descriptionIcon('heroicon-m-arrow-trending-up')
            //     ->chart([7, 2, 10, 3, 15, 4, 17])
            //     ->color('success'),
            // Stat::make('Weight', Progress::query()->select('current_weight')),
            // Stat::make('Bounce rate', '21%')
            //     ->description('7% increase')
            //     ->descriptionIcon('heroicon-m-arrow-trending-down')
            //     ->color('danger'),
            // Stat::make('Average time on page', '3:12')
            //     ->description('3% increase')
            //     ->descriptionIcon('heroicon-m-arrow-trending-up')
            //     ->color('success'),

            Stat::make('Goal Weight', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress
                    ? "{$progress->goal_weight} " . ($progress->unit_goal === 'metric' ? 'm' : 'lbs')
                    : 'N/A';
            }),

            Stat::make('Current Weight', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress
                    ? "{$progress->current_weight} " . ($progress->unit_current === 'metric' ? 'm' : 'lbs')
                    : 'N/A';
            })->chart(Progress::orderBy('created_at', 'asc')->pluck('current_weight')->toArray()),


            Stat::make('BMI', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress ? $progress->bmi : 'N/A';
            })
                ->description('Hover over the icon for chart details')
                ->descriptionIcon('heroicon-m-information-circle')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'title' => 'Source: Diabetes Canada, 2024',
                ])
                ->description(
                    $description = (function () {
                        $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                        if (!$progress) {
                            return 'No Data';
                        }

                        $bmi = $progress->bmi;

                        if ($bmi < 18.5) {
                            return 'Underweight';
                        } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                            return 'Normal weight';
                        } elseif ($bmi >= 25 && $bmi < 29.9) {
                            return 'Overweight';
                        } else {
                            return 'Obesity';
                        }
                    })()
                )
                ->color(
                    (function () use ($description) {
                        switch ($description) {
                            case 'Underweight':
                                return 'warning';
                            case 'Normal weight':
                                return 'success';
                            case 'Overweight':
                                return 'warning';
                            case 'Obesity':
                                return 'danger';
                            default:
                                return 'gray';
                        }
                    })()
                )
                ->chart(Progress::where('user_id', Auth::id())->orderBy('created_at', 'asc')->pluck('bmi')->toArray()),





            Stat::make('Hips', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress ? "{$progress->hips}" : 'N/A';
            })->chart(Progress::orderBy('created_at', 'asc')->pluck('hips')->toArray()),

            Stat::make('Waist', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress ? "{$progress->waist}" : 'N/A';
            })->chart(Progress::orderBy('created_at', 'asc')->pluck('waist')->toArray()),



            Stat::make('Chest', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress ? "{$progress->chest}" : 'N/A';
            })->chart(Progress::orderBy('created_at', 'asc')->pluck('chest')->toArray()),
        ];
    }
}
