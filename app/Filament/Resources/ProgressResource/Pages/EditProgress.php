<?php

namespace App\Filament\Resources\ProgressResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProgressResource;

class EditProgress extends EditRecord
{
    protected static string $resource = ProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Calculate BMI
        $heightInMeters = $user->unit_height === 'imperial'
            ? $user->height * 0.0254 // Convert inches to meters
            : $user->height / 100;

        $weightInKg = $data['unit_current'] === 'imperial'
            ? $data['current_weight'] * 0.453592
            : $data['current_weight'];

        $data['bmi'] = $heightInMeters > 0 ? round($weightInKg / ($heightInMeters * $heightInMeters), 2) : 0;

        // Update the progress record
        $this->record->update($data);

        return $this->record;
    }
}
