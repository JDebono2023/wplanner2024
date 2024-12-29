<?php

namespace App\Filament\Widgets;

use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserMeasurementsOverview extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected function getStats(): array
    {
        return [

            Stat::make('Hips', function () {
                // Get the most recent progress entry
                $progress = Progress::where('user_id', Auth::id())->whereNotNull('hips')->orderBy('created_at', 'desc')->first();

                // Return the hips measure with the appropriate unit
                return $progress ? "{$progress->hips}" : 'N/A';
            })
                ->description(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('hips')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('hips')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentHips = optional($progress)->hips;
                        $previousHips = optional($previousProgress)->hips;

                        // Calculate the weight difference
                        $hipsDifference = $currentHips && $previousHips
                            ? $currentHips - $previousHips
                            : null;

                        // Determine the description text
                        if (is_null($hipsDifference)) {
                            return 'No previous data';
                        }

                        return $hipsDifference > 0
                            ? 'Increase'
                            : ($hipsDifference < 0
                                ? 'Decrease'
                                : 'No change');
                    })()
                )->descriptionIcon(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('hips')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('hips')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentHips = optional($progress)->hips;
                        $previousHips = optional($previousProgress)->hips;

                        // Calculate the weight difference
                        $hipsDifference = $currentHips && $previousHips
                            ? $currentHips - $previousHips
                            : null;

                        // Determine the icon
                        if (is_null($hipsDifference)) {
                            return 'heroicon-o-information-circle'; // Icon for no data
                        }

                        return $hipsDifference > 0
                            ? 'heroicon-m-arrow-trending-up' // Icon for weight increase
                            : ($hipsDifference < 0
                                ? 'heroicon-m-arrow-trending-down' // Icon for weight decrease
                                : 'heroicon-o-minus-circle'); // Icon for no change
                    })()
                )
                ->color(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('hips')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('hips')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentHips = optional($progress)->hips;
                        $previousHips = optional($previousProgress)->hips;

                        $hipsDifference = $currentHips && $previousHips
                            ? $currentHips - $previousHips
                            : null;

                        if (is_null($hipsDifference)) {
                            return 'gray'; // Neutral color for no data
                        }

                        return $hipsDifference > 0
                            ? 'danger' // Red for weight increase
                            : ($hipsDifference < 0
                                ? 'success' // Green for weight decrease
                                : 'secondary'); // Gray for no change
                    })()
                )
                ->chart(Progress::where('user_id', Auth::id())
                    ->whereNotNull('hips')
                    ->orderBy('created_at', 'asc')
                    ->pluck('hips')
                    ->toArray()),


            Stat::make('Waist', function () {
                // Get the most recent progress entry
                $progress = Progress::where('user_id', Auth::id())->orderBy('created_at', 'desc')->whereNotNull('waist')->first();

                // Return the waist measure with the appropriate unit
                return $progress ? "{$progress->waist}" : 'N/A';
            })
                ->description(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('waist')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('waist')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentWaist = optional($progress)->waist;
                        $previousWaist = optional($previousProgress)->waist;

                        // Calculate the weight difference
                        $waistDifference = $currentWaist && $previousWaist
                            ? $currentWaist - $previousWaist
                            : null;

                        // Determine the description text
                        if (is_null($waistDifference)) {
                            return 'No previous data';
                        }

                        return $waistDifference > 0
                            ? 'Increase'
                            : ($waistDifference < 0
                                ? 'Decrease'
                                : 'No change');
                    })()
                )->descriptionIcon(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('waist')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('waist')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentWaist = optional($progress)->waist;
                        $previousWaist = optional($previousProgress)->waist;

                        // Calculate the weight difference
                        $waistDifference = $currentWaist && $previousWaist
                            ? $currentWaist - $previousWaist
                            : null;

                        // Determine the icon
                        if (is_null($waistDifference)) {
                            return 'heroicon-o-information-circle'; // Icon for no data
                        }

                        return $waistDifference > 0
                            ? 'heroicon-m-arrow-trending-up' // Icon for weight increase
                            : ($waistDifference < 0
                                ? 'heroicon-m-arrow-trending-down' // Icon for weight decrease
                                : 'heroicon-o-minus-circle'); // Icon for no change
                    })()
                )
                ->color(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('waist')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('waist')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentWaist = optional($progress)->waist;
                        $previousWaist = optional($previousProgress)->waist;

                        $waistDifference = $currentWaist && $previousWaist
                            ? $currentWaist - $previousWaist
                            : null;

                        if (is_null($waistDifference)) {
                            return 'gray'; // Neutral color for no data
                        }

                        return $waistDifference > 0
                            ? 'danger' // Red for weight increase
                            : ($waistDifference < 0
                                ? 'success' // Green for weight decrease
                                : 'secondary'); // Gray for no change
                    })()
                )
                ->chart(Progress::where('user_id', Auth::id())
                    ->whereNotNull('waist')
                    ->orderBy('created_at', 'asc')
                    ->pluck('waist')
                    ->toArray()),


            Stat::make('Chest', function () {
                // Get the most recent progress entry
                $progress = Progress::where('user_id', Auth::id())->whereNotNull('chest')->orderBy('created_at', 'desc')->first();

                // Return the chest measure with the appropriate unit
                return $progress ? "{$progress->chest}" : 'N/A';
            })
                ->description(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('chest')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('chest')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentChest = optional($progress)->chest;
                        $previousChest = optional($previousProgress)->chest;

                        // Calculate the weight difference
                        $chestDifference = $currentChest && $previousChest
                            ? $currentChest - $previousChest
                            : null;

                        // Determine the description text
                        if (is_null($chestDifference)) {
                            return 'No previous data';
                        }

                        return $chestDifference > 0
                            ? 'Increase'
                            : ($chestDifference < 0
                                ? 'Decrease'
                                : 'No change');
                    })()
                )->descriptionIcon(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('chest')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('chest')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentChest = optional($progress)->chest;
                        $previousChest = optional($previousProgress)->chest;

                        // Calculate the weight difference
                        $chestDifference = $currentChest && $previousChest
                            ? $currentChest - $previousChest
                            : null;

                        // Determine the icon
                        if (is_null($chestDifference)) {
                            return 'heroicon-o-information-circle'; // Icon for no data
                        }

                        return $chestDifference > 0
                            ? 'heroicon-m-arrow-trending-up' // Icon for weight increase
                            : ($chestDifference < 0
                                ? 'heroicon-m-arrow-trending-down' // Icon for weight decrease
                                : 'heroicon-o-minus-circle'); // Icon for no change
                    })()
                )
                ->color(
                    (function () {
                        $progress = Progress::where('user_id', Auth::id())->whereNotNull('chest')->orderBy('created_at', 'desc')->first();
                        $previousProgress = Progress::where('user_id', Auth::id())
                            ->whereNotNull('chest')
                            ->where('created_at', '<', optional($progress)->created_at)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $currentChest = optional($progress)->chest;
                        $previousChest = optional($previousProgress)->chest;

                        $chestDifference = $currentChest && $previousChest
                            ? $currentChest - $previousChest
                            : null;

                        if (is_null($chestDifference)) {
                            return 'gray'; // Neutral color for no data
                        }

                        return $chestDifference > 0
                            ? 'danger' // Red for weight increase
                            : ($chestDifference < 0
                                ? 'success' // Green for weight decrease
                                : 'secondary'); // Gray for no change
                    })()
                )
                ->chart(Progress::where('user_id', Auth::id())
                    ->whereNotNull('chest')
                    ->orderBy('created_at', 'asc')
                    ->pluck('chest')
                    ->toArray()),

        ];
    }
}
