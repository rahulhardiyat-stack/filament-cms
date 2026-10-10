<?php

namespace App\Filament\Resources\NewsletterSubscriberResource\Widgets;

use App\Models\NewsletterSubscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NewsletterStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = NewsletterSubscriber::count();
        $active = NewsletterSubscriber::where('is_active', true)->count();
        $inactive = NewsletterSubscriber::where('is_active', false)->count();
        $thisMonth = NewsletterSubscriber::whereMonth('subscribed_at', now()->month)->count();

        return [
            Stat::make('Total Subscribers', $total)
                ->description('Total semua subscriber')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Active Subscribers', $active)
                ->description('Subscriber aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Inactive Subscribers', $inactive)
                ->description('Subscriber tidak aktif')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('New This Month', $thisMonth)
                ->description('Subscriber baru bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}