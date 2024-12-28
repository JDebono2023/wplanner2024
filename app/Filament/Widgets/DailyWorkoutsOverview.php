<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class DailyWorkoutsOverview extends Widget
{
    protected static string $view = 'filament.widgets.daily-workouts-overview';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    public array $workouts = [];

    public function mount(): void
    {
        $this->workouts = Schedule::with([
            'library.mainTypes',
            'library.secondTypes',
            'library.sources',
        ])
            ->where('user_id', Auth::id())
            ->whereDate('date', now()->toDateString())
            ->orderBy('time', 'asc')
            ->get()
            ->toArray();
    }
}
