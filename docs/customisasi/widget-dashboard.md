# 🧩 Custom Widget & Dashboard

Halaman ini menjelaskan cara mengubah widget dashboard Filament.

## 📁 File Widget Newsletter

```txt
app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php
```

## 🚪 File Pendaftaran Widget

```txt
app/Providers/Filament/AdminPanelProvider.php
```

## 🏷️ Mengubah Judul Card Widget

Before:

```php
Stat::make('Total Subscribers', $total)
```

After:

```php
Stat::make('Total Pelanggan', $total)
```

## 💬 Mengubah Deskripsi Card

Before:

```php
->description('Total semua subscriber')
```

After:

```php
->description('Jumlah seluruh email yang terdaftar')
```

## 🖼️ Mengubah Icon Widget

Before:

```php
->descriptionIcon('heroicon-m-user-group')
```

After:

```php
->descriptionIcon('heroicon-m-envelope')
```

## 🎨 Mengubah Warna Card

Before:

```php
->color('primary')
```

After:

```php
->color('success')
```

Pilihan umum:

```php
'primary'
'success'
'warning'
'danger'
'info'
'gray'
```

## ➕ Menambah Card Statistik Baru

Contoh tambah card subscriber aktif hari ini:

```php
$today = NewsletterSubscriber::whereDate('subscribed_at', today())->count();

return [
    // stat lain...

    Stat::make('Baru Hari Ini', $today)
        ->description('Subscriber yang daftar hari ini')
        ->descriptionIcon('heroicon-m-calendar-days')
        ->color('success'),
];
```

## 🧮 Mengubah Query Statistik

Kode saat ini:

```php
$thisMonth = NewsletterSubscriber::whereMonth('subscribed_at', now()->month)->count();
```

Lebih akurat dengan tahun:

```php
$thisMonth = NewsletterSubscriber::query()
    ->whereYear('subscribed_at', now()->year)
    ->whereMonth('subscribed_at', now()->month)
    ->count();
```

## 🙈 Menghapus Widget dari Dashboard

File:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

Before:

```php
->widgets([
    Widgets\AccountWidget::class,
    NewsletterStatsWidget::class,
    Widgets\FilamentInfoWidget::class,
])
```

After hapus info Filament:

```php
->widgets([
    Widgets\AccountWidget::class,
    NewsletterStatsWidget::class,
])
```

## ➕ Menambahkan Widget Baru

Langkah umum:

1. Buat class widget baru di `app/Filament/Widgets` atau folder widget Resource.
2. Import class di `AdminPanelProvider.php`.
3. Tambahkan ke `->widgets([...])`.

Contoh pendaftaran:

```php
->widgets([
    Widgets\AccountWidget::class,
    NewsletterStatsWidget::class,
    ArticleStatsWidget::class,
])
```
