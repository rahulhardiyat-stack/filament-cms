<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Komentar';

    protected static ?string $modelLabel = 'Komentar';

    protected static ?string $pluralModelLabel = 'Komentar';

    protected static ?string $navigationGroup = 'Interaksi';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Komentar')
                    ->schema([
                        Forms\Components\Select::make('article_id')
                            ->label('Artikel')
                            ->relationship('article', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn(?Comment $record) => $record !== null),

                        Forms\Components\Select::make('parent_id')
                            ->label('Balasan Dari')
                            ->relationship('parent', 'author_name')
                            ->searchable()
                            ->preload()
                            ->helperText('Kosongkan jika ini bukan reply'),

                        Forms\Components\TextInput::make('author_name')
                            ->label('Nama Pemberi Komentar')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('author_email')
                            ->label('Email Pemberi Komentar')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('content')
                            ->label('Isi Komentar')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Status & Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_approved')
                            ->label('Disetujui')
                            ->helperText('Komentar yang disetujui akan tampil di website')
                            ->default(false),

                        Forms\Components\Toggle::make('is_author_reply')
                            ->label('Balasan Penulis')
                            ->helperText('Tandai jika ini balasan dari penulis artikel')
                            ->default(false),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Metadata')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Dibuat')
                            ->content(fn(?Comment $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->content(fn(?Comment $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    ])
                    ->columns(2)
                    ->hidden(fn(?Comment $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('article.title')
                    ->label('Artikel')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->weight('bold')
                    ->url(fn(Comment $record): string => route('article.detail', $record->article->slug))
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('author_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('content')
                    ->label('Komentar')
                    ->limit(50)
                    ->wrap()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_author_reply')
                    ->label('Reply Penulis')
                    ->boolean()
                    ->trueIcon('heroicon-o-user-circle')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('info')
                    ->falseColor('gray')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('parent.author_name')
                    ->label('Reply To')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('replies_count')
                    ->label('Balasan')
                    ->counts('replies')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->description(fn(Comment $record): string => $record->created_at->format('d M Y H:i')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Status Persetujuan')
                    ->placeholder('Semua')
                    ->trueLabel('Disetujui')
                    ->falseLabel('Menunggu'),

                Tables\Filters\TernaryFilter::make('is_author_reply')
                    ->label('Reply Penulis')
                    ->placeholder('Semua')
                    ->trueLabel('Reply Penulis')
                    ->falseLabel('Reply User'),

                Tables\Filters\SelectFilter::make('article')
                    ->label('Artikel')
                    ->relationship('article', 'title')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('has_replies')
                    ->label('Memiliki Balasan')
                    ->query(fn($query) => $query->has('replies'))
                    ->toggle(),

                Tables\Filters\Filter::make('is_reply')
                    ->label('Adalah Balasan')
                    ->query(fn($query) => $query->whereNotNull('parent_id'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->hidden(fn(Comment $record) => $record->is_approved)
                        ->requiresConfirmation()
                        ->action(function (Comment $record) {
                            $record->update(['is_approved' => true]);
                            Notification::make()
                                ->title('Komentar disetujui')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('unapprove')
                        ->label('Batalkan Persetujuan')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->hidden(fn(Comment $record) => !$record->is_approved)
                        ->requiresConfirmation()
                        ->action(function (Comment $record) {
                            $record->update(['is_approved' => false]);
                            Notification::make()
                                ->title('Persetujuan komentar dibatalkan')
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\Action::make('reply')
                        ->label('Balas')
                        ->icon('heroicon-o-chat-bubble-left')
                        ->color('info')
                        ->form([
                            Forms\Components\Textarea::make('content')
                                ->label('Balasan Anda')
                                ->required()
                                ->rows(4),
                            Forms\Components\Toggle::make('is_author_reply')
                                ->label('Tandai sebagai balasan penulis')
                                ->default(true),
                        ])
                        ->action(function (Comment $record, array $data) {
                            Comment::create([
                                'article_id' => $record->article_id,
                                'parent_id' => $record->id,
                                'author_name' => auth()->user()->name ?? 'Admin',
                                'author_email' => auth()->user()->email ?? 'admin@blog.com',
                                'content' => $data['content'],
                                'is_approved' => true,
                                'is_author_reply' => $data['is_author_reply'],
                            ]);

                            Notification::make()
                                ->title('Balasan berhasil dikirim')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Setujui yang Dipilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_approved' => true]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('unapprove')
                        ->label('Batalkan Persetujuan')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_approved' => false]))
                        ->deselectRecordsAfterCompletion(),

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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $pending = static::getModel()::where('is_approved', false)->count();
        return $pending > 0 ? (string) $pending : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('is_approved', false)->count() > 0
            ? 'warning'
            : 'success';
    }
}