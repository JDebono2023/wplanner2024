<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'filament.pages.auth.edit-profile';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Your Info')
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),

                    ])
                    ->aside(),
                Section::make('Details')
                    ->schema([
                        TextInput::make('age')
                            ->required(),
                        TextInput::make('height')
                            ->label('Height')
                            ->numeric(), // Tight styles
                        ToggleButtons::make('unit_height')
                            ->label('Unit') // No extra label for toggle
                            ->options([
                                'imperial' => 'in',
                                'metric' => 'cm',
                            ])
                            ->default('metric')
                            ->grouped(),
                        TextInput::make('goal_weight')
                            ->label('Goal Weight')
                            ->numeric(), // Compact
                        ToggleButtons::make('unit_goal')
                            ->label('Unit')
                            ->options([
                                'imperial' => 'lbs',
                                'metric' => 'kg',
                            ])
                            ->default('metric')
                            ->grouped(),
                    ])
                    ->aside(),



            ]);
    }
}
