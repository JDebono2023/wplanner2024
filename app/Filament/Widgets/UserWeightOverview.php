<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserWeightOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getStats(): array
    {

        return [
            Stat::make('Goal Weight', function () {
                $progress = User::where('id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress && !is_null($progress->goal_weight)
                    ? "{$progress->goal_weight} " . ($progress->unit_goal === 'metric' ? 'kg' : 'lbs')
                    : 'N/A';
            })->description(
                (function () {
                    $progress = User::where('id', Auth::id())->orderBy('created_at', 'desc')->first();

                    // Determine the description text
                    if (is_null($progress->goal_weight)) {
                        return 'No previous data';
                    }
                })()
            )->descriptionIcon(
                $description = (function () {
                    $progress = User::where('id', Auth::id())->orderBy('created_at', 'desc')->first();

                    if (!$progress->goal_weight) {
                        return 'heroicon-o-minus-circle';
                    }
                })()
            ),


            Stat::make('Current Weight', function () {
                // Get the most recent progress entry
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                // Return the current weight with the appropriate unit
                return $progress
                    ? "{$progress->current_weight} " . ($progress->unit_current === 'metric' ? 'kg' : 'lbs')
                    : 'N/A';
            })
                ->description(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                        $previousProgress = null;
                        if ($progress) {
                            $previousProgress = Progress::where('user_id', Auth::id())
                                ->where('created_at', '<', $progress->created_at) // Only execute if $progress->created_at exists
                                ->orderBy('created_at', 'desc')
                                ->first();
                        }

                        $currentWeight = optional($progress)->current_weight;
                        $previousWeight = optional($previousProgress)->current_weight;

                        // Calculate the weight difference
                        $weightDifference = $currentWeight && $previousWeight
                            ? $currentWeight - $previousWeight
                            : null;

                        // Determine the description text
                        if (is_null($weightDifference)) {
                            return 'No previous data';
                        }

                        return $weightDifference > 0
                            ? 'Weight increased'
                            : ($weightDifference < 0
                                ? 'Weight decreased'
                                : 'No change in weight');
                    })()
                )->descriptionIcon(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                        $previousProgress = null;
                        if ($progress) {
                            $previousProgress = Progress::where('user_id', Auth::id())
                                ->where('created_at', '<', $progress->created_at) // Only execute if $progress->created_at exists
                                ->orderBy('created_at', 'desc')
                                ->first();
                        }

                        $currentWeight = optional($progress)->current_weight;
                        $previousWeight = optional($previousProgress)->current_weight;

                        // Calculate the weight difference
                        $weightDifference = $currentWeight && $previousWeight
                            ? $currentWeight - $previousWeight
                            : null;

                        // Determine the icon
                        if (is_null($weightDifference)) {
                            return 'heroicon-o-minus-circle'; // Icon for no data
                        }

                        return $weightDifference > 0
                            ? 'heroicon-m-arrow-trending-up' // Icon for weight increase
                            : ($weightDifference < 0
                                ? 'heroicon-m-arrow-trending-down' // Icon for weight decrease
                                : 'heroicon-o-minus-circle'); // Icon for no change
                    })()
                )
                ->color(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                        $previousProgress = null;
                        if ($progress) {
                            $previousProgress = Progress::where('user_id', Auth::id())
                                ->where('created_at', '<', $progress->created_at) // Only execute if $progress->created_at exists
                                ->orderBy('created_at', 'desc')
                                ->first();
                        }

                        $currentWeight = optional($progress)->current_weight;
                        $previousWeight = optional($previousProgress)->current_weight;

                        $weightDifference = $currentWeight && $previousWeight
                            ? $currentWeight - $previousWeight
                            : null;

                        if (is_null($weightDifference)) {
                            return 'gray'; // Neutral color for no data
                        }

                        return $weightDifference > 0
                            ? 'danger' // Red for weight increase
                            : ($weightDifference < 0
                                ? 'success' // Green for weight decrease
                                : 'secondary'); // Gray for no change
                    })()
                )
                ->chart(Progress::where('user_id', Auth::id())
                    ->orderBy('created_at', 'asc')
                    ->pluck('current_weight')
                    ->toArray()),


            Stat::make('BMI', function () {
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                return $progress ? $progress->bmi : 'N/A';
            })
                // ->description('Hover over the icon for chart details')
                ->descriptionIcon('heroicon-m-information-circle')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'title' => 'Source: Diabetes Canada, 2024',
                ])
                ->description(
                    $description = (function () {
                        $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

                        if (!$progress) {
                            return 'No previous data';
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
        ];
    }
}
