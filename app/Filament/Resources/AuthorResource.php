<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Penulis';

    protected static ?string $modelLabel = 'Penulis';

    protected static ?string $pluralModelLabel = 'Penulis';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Penulis')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
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
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('title')
                            ->label('Jabatan/Title')
                            ->maxLength(255)
                            ->placeholder('e.g. Senior Tech Writer'),

                        Forms\Components\FileUpload::make('avatar')
                            ->label('Avatar')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('authors')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('bio')
                            ->label('Bio')
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('Twitter URL')
                            ->url()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-link'),

                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-link'),

                        Forms\Components\TextInput::make('website_url')
                            ->label('Website URL')
                            ->url()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-link'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->visibility('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Jabatan')
                    ->searchable()
                    ->toggleable(),

                // PERBAIKAN: Gunakan counts() method dengan nama relationship yang benar
                Tables\Columns\TextColumn::make('articles_count')
                    ->label('Artikel')
                    ->counts('articles')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
