<?php

namespace App\Filament\Resources\ProgressResource\Pages;

use App\Filament\Resources\ProgressResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProgress extends CreateRecord
{
    protected static string $resource = ProgressResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
