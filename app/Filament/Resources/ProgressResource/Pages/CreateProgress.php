<?php

namespace App\Filament\Resources\ProgressResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProgressResource;

class CreateProgress extends CreateRecord
{
    protected static string $resource = ProgressResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
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


        $data['user_id'] = $user->id;

        return static::getModel()::create($data);
    }
}
