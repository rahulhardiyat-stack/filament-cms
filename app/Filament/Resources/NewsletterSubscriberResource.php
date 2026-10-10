<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsletterSubscriberResource\Pages;
use App\Models\NewsletterSubscriber;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class NewsletterSubscriberResource extends Resource
{
    protected static ?string $model = NewsletterSubscriber::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Newsletter';

    protected static ?string $modelLabel = 'Subscriber';

    protected static ?string $pluralModelLabel = 'Newsletter Subscribers';

    protected static ?string $navigationGroup = 'Interaksi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Subscriber')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Subscriber aktif akan menerima newsletter'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Metadata')
                    ->schema([
                        Forms\Components\Placeholder::make('subscribed_at')
                            ->label('Berlangganan Sejak')
                            ->content(
                                fn(?NewsletterSubscriber $record): string =>
                                $record ? $record->subscribed_at->format('d M Y H:i') : '-'
                            ),

                        Forms\Components\Placeholder::make('created_at')
                            ->label('Dibuat')
                            ->content(
                                fn(?NewsletterSubscriber $record): string =>
                                $record ? $record->created_at->diffForHumans() : '-'
                            ),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Terakhir Diupdate')
                            ->content(
                                fn(?NewsletterSubscriber $record): string =>
                                $record ? $record->updated_at->diffForHumans() : '-'
                            ),
                    ])
                    ->columns(3)
                    ->hidden(fn(?NewsletterSubscriber $record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope')
                    ->weight('bold'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subscribed_at')
                    ->label('Berlangganan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->since()
                    ->description(
                        fn(NewsletterSubscriber $record): string =>
                        $record->subscribed_at->format('d M Y H:i')
                    ),

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
            ->defaultSort('subscribed_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                Tables\Filters\Filter::make('subscribed_at')
                    ->form([
                        Forms\Components\DatePicker::make('subscribed_from')
                            ->label('Berlangganan Dari'),
                        Forms\Components\DatePicker::make('subscribed_until')
                            ->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['subscribed_from'],
                                fn($query, $date) =>
                                $query->whereDate('subscribed_at', '>=', $date)
                            )
                            ->when(
                                $data['subscribed_until'],
                                fn($query, $date) =>
                                $query->whereDate('subscribed_at', '<=', $date)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->hidden(fn(NewsletterSubscriber $record) => $record->is_active)
                        ->requiresConfirmation()
                        ->action(function (NewsletterSubscriber $record) {
                            $record->update(['is_active' => true]);
                            Notification::make()
                                ->title('Subscriber diaktifkan')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->hidden(fn(NewsletterSubscriber $record) => !$record->is_active)
                        ->requiresConfirmation()
                        ->action(function (NewsletterSubscriber $record) {
                            $record->update(['is_active' => false]);
                            Notification::make()
                                ->title('Subscriber dinonaktifkan')
                                ->warning()
                                ->send();
                        }),

                    Tables\Actions\Action::make('send_test')
                        ->label('Kirim Test Email')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalDescription('Fitur ini akan mengirim test email ke subscriber.')
                        ->action(function (NewsletterSubscriber $record) {
                            // TODO: Implement email sending logic
                            Notification::make()
                                ->title('Test email terkirim')
                                ->body('Email berhasil dikirim ke ' . $record->email)
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan yang Dipilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan yang Dipilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Email')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->action(function ($records) {
                            $emails = $records->pluck('email')->implode(', ');
                            Notification::make()
                                ->title('Email List')
                                ->body($emails)
                                ->success()
                                ->persistent()
                                ->send();
                        }),

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
            'index' => Pages\ListNewsletterSubscribers::route('/'),
            'create' => Pages\CreateNewsletterSubscriber::route('/create'),
            'edit' => Pages\EditNewsletterSubscriber::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getWidgets(): array
    {
        return [
            NewsletterSubscriberResource\Widgets\NewsletterStatsWidget::class,
        ];
    }
}