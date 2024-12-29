<?php

namespace App\Filament\Resources\ProgressResource\Pages;

use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProgressResource;
use App\Filament\Widgets\UserWeightOverview;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Widgets\UserMeasurementsOverview;

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
            UserWeightOverview::class,
            UserMeasurementsOverview::class,
        ];
    }
}
