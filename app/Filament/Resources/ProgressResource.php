<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Progress;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ProgressResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgressResource\RelationManagers;

class ProgressResource extends Resource
{
    protected static ?string $model = Progress::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralModelLabel = 'My Progress';
    protected static ?string $modelLabel = 'My Progress';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    ->schema([
                        TextInput::make('current_weight'),
                        Select::make('unit_current')
                            ->label('Unit')
                            ->options([
                                'imperial' => 'lbs',
                                'metric' => 'kg',
                            ])
                            ->default('metric')
                            ->required(),
                        TextInput::make('goal_weight'),
                        Select::make('unit_goal')
                            ->label('Unit')
                            ->options([
                                'imperial' => 'lbs',
                                'metric' => 'kg',
                            ])
                            ->default('metric')
                            ->required(),
                        TextInput::make('height')
                            ->label('Height')
                            ->required()
                            ->numeric()
                            ->helperText('Enter height value.'),

                        Select::make('unit_height')
                            ->label('Height Unit')
                            ->options([
                                'imperial' => 'in',
                                'metric' => 'm',
                            ])
                            ->default('metric')
                            ->required(),
                        TextInput::make('bmi')
                            ->label('BMI')
                            ->disabled()
                            ->helperText('BMI is calculated automatically.'),
                    ])
                    ->columns(4),
                Section::make('Measurements')
                    ->schema([
                        TextInput::make('hips'),
                        TextInput::make('waist'),
                        TextInput::make('chest'),
                    ])
                    ->columns(3),
                Section::make('Photos')
                    ->schema([
                        FileUpload::make('photo'),
                    ])
                    ->columns(1),
                Hidden::make('user_id')->dehydrateStateUsing(fn($state) => auth()->id())
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Add New')
                    ->createAnother(false),

            ])
            ->columns([

                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->label('Date'),
                TextColumn::make('current_weight')
                    ->label('Weight')
                    ->formatStateUsing(function ($record) {
                        // Determine the unit based on the `unit_current` value
                        $unit = $record->unit_current === 'metric' ? 'm' : 'lb';

                        return "{$record->current_weight} {$unit}";
                    }),
                TextColumn::make('hips'),
                TextColumn::make('waist'),
                TextColumn::make('chest'),
                // TextColumn::make('goal_weight'),
                // TextColumn::make('unit_goal'),
                // TextColumn::make('height')
                //     ->label('Height'),
                // TextColumn::make('unit_height')
                //     ->label('Height Unit'),
                TextColumn::make('bmi')
                    ->label('BMI'),

                ImageColumn::make('photo')
                    ->label('Photo')
                    ->defaultImageUrl(url('storage/images/wplanner_noimg.png'))
                    ->height(50)
                // ->formatStateUsing(function ($record) {
                //     return '<img src="' . $record->photo . '" 
                //                 alt="Image" 
                //                 class="w-16 h-16 object-cover cursor-pointer" 
                //                 onclick="Livewire.emit(\'openImageModal\', \'' . $record->photo . '\')" />';
                // })
                // ->html(), // Enable HTML rendering,


            ])
            // ->contentGrid([
            //     'md' => 1,
            //     'xl' => 1,
            // ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgress::route('/'),
            'create' => Pages\CreateProgress::route('/create'),
            'edit' => Pages\EditProgress::route('/{record}/edit'),
        ];
    }
}
