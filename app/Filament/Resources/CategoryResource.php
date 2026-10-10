<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kategori';

    protected static ?string $modelLabel = 'Kategori';

    protected static ?string $pluralModelLabel = 'Kategori';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $operation, $state, Forms\Set $set) =>
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly version of the name'),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(500)
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('color')
                            ->label('Warna')
                            ->searchable()
                            ->options([
                                'blue' => 'Biru',
                                'red' => 'Merah',
                                'green' => 'Hijau',
                                'purple' => 'Ungu',
                                'orange' => 'Oranye',
                                'indigo' => 'Indigo',
                            ])
                            ->required()
                            ->default('blue'),

                        Forms\Components\Textarea::make('icon')
                            ->label('SVG Icon')
                            ->helperText('Paste SVG code here')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-link')
                    ->color('gray'),

                Tables\Columns\BadgeColumn::make('color')
                    ->label('Warna')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'blue' => 'Biru',
                        'red' => 'Merah',
                        'green' => 'Hijau',
                        'purple' => 'Ungu',
                        'orange' => 'Oranye',
                        'indigo' => 'Indigo',
                        default => $state
                    })
                    ->colors([
                        'primary' => 'blue',
                        'danger' => 'red',
                        'success' => 'green',
                        'warning' => 'orange',
                        'info' => 'indigo',
                    ]),

                Tables\Columns\TextColumn::make('article_count')
                    ->label('Artikel')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                Tables\Filters\SelectFilter::make('color')
                    ->label('Warna')
                    ->options([
                        'blue' => 'Biru',
                        'red' => 'Merah',
                        'green' => 'Hijau',
                        'purple' => 'Ungu',
                        'orange' => 'Oranye',
                        'indigo' => 'Indigo',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}