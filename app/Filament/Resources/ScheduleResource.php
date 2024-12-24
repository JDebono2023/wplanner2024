<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Source;
use App\Models\Schedule;
use App\Models\TypeMain;
use Filament\Forms\Form;
use App\Models\TypeSecond;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ScheduleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ScheduleResource\RelationManagers;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Schedule';
    protected static ?int $navigationSort = 2;

    // collect the records from today onwards
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('date', '>=', Carbon::now()->toDateString());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('user_id')->dehydrateStateUsing(fn($state) => auth()->id()),
                Section::make()
                    ->schema([
                        Select::make('library_id')
                            ->label('Workout')
                            ->relationship('library', 'name')
                            ->searchable(['name'])
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Section::make('Name')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('')
                                            ->required()
                                            ->markAsRequired(false)
                                            ->helperText(new HtmlString('Add a workout name.'))
                                    ])
                                    ->columns(1),
                                Section::make('Media Source')
                                    ->schema([
                                        Select::make('source_id')
                                            ->label('')
                                            ->helperText(new HtmlString('Select or create a media source'))
                                            ->relationship('sources', 'name')
                                            ->searchable(['name'])
                                            ->preload()
                                            ->required()
                                            ->markAsRequired(false)
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->unique(table: Source::class)
                                                    ->validationMessages([
                                                        'unique' => 'This :attribute already exists.',
                                                    ])
                                                    ->required()
                                                    ->markAsRequired(false)
                                            ]),
                                    ])
                                    ->columns(1),
                                Section::make('Main Type')
                                    ->schema([
                                        Select::make('type_m')
                                            ->label('')
                                            ->helperText(new HtmlString('Select or create a main workout type'))
                                            ->relationship('mainTypes', 'name')
                                            ->searchable(['name'])
                                            ->preload()
                                            ->required()
                                            ->markAsRequired(false)
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->unique(table: TypeMain::class)
                                                    ->validationMessages([
                                                        'unique' => 'This :attribute already exists.',
                                                    ])
                                                    ->required()
                                                    ->markAsRequired(false)
                                            ])
                                    ])
                                    ->columns(1),
                                Section::make('Secondary Type')
                                    ->schema([
                                        Select::make('type_s')
                                            ->label('')
                                            ->helperText(new HtmlString('Select or create a secondary workout type'))
                                            ->relationship('secondTypes', 'name')
                                            ->searchable(['name'])
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->unique(table: TypeSecond::class)
                                                    ->validationMessages([
                                                        'unique' => 'This :attribute already exists.',
                                                    ])
                                                    ->required()
                                                    ->markAsRequired(false)
                                            ]),
                                    ])
                                    ->columns(1),
                            ]),
                    ])
                    ->columns(1),

                Section::make()
                    ->schema([
                        DatePicker::make('date')
                            ->required(),
                    ])
                    ->columns(1),
                Section::make()
                    ->schema([
                        TimePicker::make('time')
                            ->required()
                            ->seconds(false),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // grouping for primary sort to display schedule items by date
            ->groups([
                Group::make('library.name')
                    ->label('Workout')
                    ->collapsible(),
                Group::make('date')
                    ->date('M-d-o')
                    ->collapsible()
            ])
            ->defaultGroup(Group::make('date')
                ->date('M-d-o'))
            ->columns([
                // split column display
                Split::make([
                    ImageColumn::make('library.image')
                        ->height(50),
                    Stack::make([
                        TextColumn::make('library.name')
                            ->searchable(),
                    ]),
                    Stack::make([
                        TextColumn::make('date')
                            ->date(),
                        TextColumn::make('time')
                            ->time('g:i a'),
                    ]),
                ]),

            ])
            // responsive control
            ->contentGrid([
                'md' => 2,
                'lg' => 2
            ])
            ->filters([
                // filter by library item name and types
                SelectFilter::make('Name')
                    ->relationship('library', 'name')
                    ->preload(),
                SelectFilter::make('Main Type')
                    ->relationship('library.mainTypes', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('Second Type')
                    ->relationship('library.secondTypes', 'name')
                    ->searchable()
                    ->preload()

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
