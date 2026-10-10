<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Tags';

    protected static ?string $modelLabel = 'Tag';

    protected static ?string $pluralModelLabel = 'Tags';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tag')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Tag')
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
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Statistik')
                    ->schema([
                        Forms\Components\Placeholder::make('articles_count')
                            ->label('Total Artikel')
                            ->content(fn(?Tag $record): string => $record ? $record->articles()->count() . ' artikel' : '0 artikel'),

                        Forms\Components\Placeholder::make('created_at')
                            ->label('Dibuat')
                            ->content(fn(?Tag $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                    ])
                    ->columns(2)
                    ->hidden(fn(?Tag $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tag')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-tag'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-link')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('articles_count')
                    ->label('Jumlah Artikel')
                    ->counts('articles')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('articles_count', 'desc')
            ->filters([
                Tables\Filters\Filter::make('has_articles')
                    ->label('Memiliki Artikel')
                    ->query(fn($query) => $query->has('articles'))
                    ->toggle(),

                Tables\Filters\Filter::make('no_articles')
                    ->label('Tanpa Artikel')
                    ->query(fn($query) => $query->doesntHave('articles'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalDescription('Tag akan dihapus dari semua artikel yang menggunakannya.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalDescription('Tags yang dipilih akan dihapus dari semua artikel.'),
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}