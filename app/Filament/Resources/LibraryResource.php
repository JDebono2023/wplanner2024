<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Source;
use App\Models\Library;
use App\Models\TypeMain;
use Filament\Forms\Form;
use App\Models\TypeSecond;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LibraryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LibraryResource\RelationManagers;

class LibraryResource extends Resource
{
    protected static ?string $model = Library::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralModelLabel = 'Workout Library';
    protected static ?string $modelLabel = 'Workout';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')

                            ->required(),
                        Select::make('source_id')
                            ->label('Source')
                            ->helperText(new HtmlString('Select or create a media source'))
                            ->relationship('sources', 'name')
                            ->searchable(['name'])
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->unique(table: Source::class)
                                    ->validationMessages([
                                        'unique' => 'This :attribute already exists.',
                                    ])
                                    ->required()
                            ]),
                        Select::make('type_m')
                            ->label('Category')
                            ->helperText(new HtmlString('Select or create a primary activity category'))
                            ->relationship('mainTypes', 'name')
                            ->searchable(['name'])
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->unique(table: TypeMain::class)
                                    ->validationMessages([
                                        'unique' => 'This :attribute already exists.',
                                    ])
                                    ->required()
                            ]),
                        Select::make('type_s')
                            ->label('Subcategory')
                            ->helperText(new HtmlString('Select or create a workout subcategory'))
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
                            ]),
                        FileUpload::make('image')
                            ->label('Image')
                            ->helperText(new HtmlString('Add an optional workout image'))
                    ])
                    ->columns(1),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->label('Create New Workout')
                    ->createAnother(false),
            ])
            ->groups([
                Group::make('sources.name')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('mainTypes.name')
                    ->label('Category')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
                Group::make('secondTypes.name')
                    ->label('Subcategory')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible(),
            ])
            ->defaultGroup(Group::make('mainTypes.name')
                ->titlePrefixedWithLabel(false)
                ->collapsible())
            ->columns([
                // split column display
                Split::make([
                    ImageColumn::make('image')
                        ->label('')
                        ->defaultImageUrl(url('storage/images/wplanner_noimg.png'))
                        ->height(50),
                    Stack::make([
                        TextColumn::make('name')
                            ->label('Workout')
                            ->searchable(),
                    ]),
                ]),
                // make extra details collapsible
                Panel::make([
                    Split::make([
                        TextColumn::make('sources.name')
                            ->icon('heroicon-s-globe-americas')
                            ->label('Source'),
                        TextColumn::make('mainTypes.name')
                            ->label('Category'),
                        TextColumn::make('secondTypes.name')
                            ->label('Subcategory')
                    ]),
                ])->collapsible(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListLibraries::route('/'),
            'create' => Pages\CreateLibrary::route('/create'),
            'edit' => Pages\EditLibrary::route('/{record}/edit'),
        ];
    }
}
