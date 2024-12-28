<?php

namespace App\Filament\Resources\ProgressResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProgressResource;
use App\Filament\Widgets\UserStatsOverview;
use Filament\Infolists\Components\TextEntry;

class ListProgress extends ListRecords
{
    protected static string $resource = ProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make()
            //     ->label('Add New')
            //     ->createAnother(false),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return [
            UserStatsOverview::class,
        ];
    }
}
