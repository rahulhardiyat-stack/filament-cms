<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Artikel';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?string $pluralModelLabel = 'Artikel';

    protected static ?string $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Konten Artikel')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Artikel')
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
                                    ->helperText('URL-friendly version of the title'),

                                Forms\Components\Textarea::make('excerpt')
                                    ->label('Excerpt/Ringkasan')
                                    ->required()
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Ringkasan singkat artikel (maks. 500 karakter)'),

                                Forms\Components\RichEditor::make('content')
                                    ->label('Konten Artikel')
                                    ->required()
                                    ->columnSpanFull()
                                    ->fileAttachmentsDirectory('articles')
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ]),
                            ]),

                        Forms\Components\Section::make('Featured Image')
                            ->schema([
                                Forms\Components\FileUpload::make('featured_image')
                                    ->label('Gambar Utama')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->image()
                                    ->directory('articles/featured')
                                    ->maxSize(5120)
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '16:9',
                                        '4:3',
                                        '1:1',
                                    ])
                                    ->helperText('Ukuran maksimal: 5MB. Rasio yang disarankan: 16:9'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Pengaturan')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Select::make('color')
                                            ->options([
                                                'blue' => 'Biru',
                                                'red' => 'Merah',
                                                'green' => 'Hijau',
                                                'purple' => 'Ungu',
                                                'orange' => 'Oranye',
                                                'indigo' => 'Indigo',
                                            ])
                                            ->required(),
                                    ]),

                                Forms\Components\Select::make('author_id')
                                    ->label('Penulis')
                                    ->relationship('author', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\Select::make('tags')
                                    ->label('Tags')
                                    ->relationship('tags', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                Forms\Components\TextInput::make('read_time')
                                    ->label('Waktu Baca (menit)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix('menit')
                                    ->helperText('Akan dihitung otomatis jika dikosongkan'),
                            ]),

                        Forms\Components\Section::make('Status & Publikasi')
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Publikasikan')
                                    ->default(false)
                                    ->live(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Publikasi')
                                    ->default(now())
                                    ->required()
                                    ->visible(fn(Forms\Get $get) => $get('is_published')),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Artikel Pilihan')
                                    ->helperText('Tampilkan di halaman utama'),
                            ]),

                        Forms\Components\Section::make('Metadata')
                            ->schema([
                                Forms\Components\Placeholder::make('views_count')
                                    ->label('Total Views')
                                    ->content(fn(?Article $record): string => $record ? number_format($record->views_count) : '0'),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Dibuat')
                                    ->content(fn(?Article $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Terakhir Diupdate')
                                    ->content(fn(?Article $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])
                            ->hidden(fn(?Article $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Gambar')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->color(fn(Article $record) => match ($record->category->color) {
                        'blue' => 'info',
                        'red' => 'danger',
                        'green' => 'success',
                        'purple' => 'warning',
                        'orange' => 'warning',
                        'indigo' => 'primary',
                        default => 'gray'
                    }),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Pilihan')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state))
                    ->icon('heroicon-m-eye')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('read_time')
                    ->label('Baca')
                    ->suffix(' min')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Dipublikasi')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->preload(),

                Tables\Filters\SelectFilter::make('author')
                    ->label('Penulis')
                    ->relationship('author', 'name')
                    ->preload(),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi')
                    ->placeholder('Semua')
                    ->trueLabel('Published')
                    ->falseLabel('Draft'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Artikel Pilihan')
                    ->placeholder('Semua')
                    ->trueLabel('Featured')
                    ->falseLabel('Regular'),

                Tables\Filters\Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn($query, $date) =>
                                $query->whereDate('published_at', '>=', $date)
                            )
                            ->when(
                                $data['published_until'],
                                fn($query, $date) =>
                                $query->whereDate('published_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('visit')
                        ->label('Lihat di Website')
                        ->url(fn(Article $record): string => route('article.detail', $record->slug))
                        ->icon('heroicon-m-arrow-top-right-on-square')
                        ->openUrlInNewTab(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publikasikan')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_published' => true, 'published_at' => now()]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_published' => false]))
                        ->deselectRecordsAfterCompletion()
                        ->color('danger'),

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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_published', true)->count() . '/' . static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}