# 🧩 Widget Dashboard

Widget dashboard menampilkan ringkasan data di halaman utama admin.

## 📁 File Widget Newsletter

```txt
app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php
```

## 🧾 Kode Widget

```php
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
        ];
    }
}
```

## 🏷️ Mengubah Label Card Widget

Cari kode:

```php
Stat::make('Total Subscribers', $total)
```

Ubah menjadi:

```php
Stat::make('Total Pelanggan', $total)
```

## 📝 Mengubah Deskripsi Widget

Kode:

```php
->description('Total semua subscriber')
```

Ubah menjadi:

```php
->description('Jumlah semua email yang mendaftar newsletter')
```

## 🎨 Mengubah Warna Widget

Kode:

```php
->color('primary')
```

Contoh warna:

```php
->color('success')
->color('warning')
->color('danger')
->color('info')
```

## 🖼️ Mengubah Icon Deskripsi

Kode:

```php
->descriptionIcon('heroicon-m-user-group')
```

Ubah icon:

```php
->descriptionIcon('heroicon-m-envelope')
```

## 🚪 Mendaftarkan Widget ke Dashboard

File:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

Kode:

```php
->widgets([
    Widgets\AccountWidget::class,
    NewsletterStatsWidget::class,
    Widgets\FilamentInfoWidget::class,
])
```
