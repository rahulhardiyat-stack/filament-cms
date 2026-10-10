# 🚪 Panel Admin Filament

Panel admin adalah pintu utama dashboard CMS.

## 📁 File yang Diedit

```txt
app/Providers/Filament/AdminPanelProvider.php
```

## 🧩 Kode Utama

```php
return $panel
    ->default()
    ->id('admin')
    ->path('admin')
    ->login()
    ->colors([
        'primary' => Color::Amber,
    ])
    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
    ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
    ->pages([
        Pages\Dashboard::class,
    ])
    ->widgets([
        Widgets\AccountWidget::class,
        NewsletterStatsWidget::class,
        Widgets\FilamentInfoWidget::class,
    ]);
```

## 🔗 Mengubah URL Admin

Kode saat ini:

```php
->path('admin')
```

Jika ingin dashboard menjadi `/dashboard`:

```php
->path('dashboard')
```

## 🎨 Mengubah Warna Utama Panel

Kode saat ini:

```php
->colors([
    'primary' => Color::Amber,
])
```

Contoh ubah ke biru:

```php
->colors([
    'primary' => Color::Blue,
])
```

## 🧩 Menambah atau Menghapus Widget

Widget dashboard didaftarkan di bagian:

```php
->widgets([
    Widgets\AccountWidget::class,
    NewsletterStatsWidget::class,
    Widgets\FilamentInfoWidget::class,
])
```

Jika ingin menghapus widget info Filament:

```php
->widgets([
    Widgets\AccountWidget::class,
    NewsletterStatsWidget::class,
])
```

## 🔐 Login dan Middleware

Kode:

```php
->login()
->authMiddleware([
    Authenticate::class,
])
```

Artinya dashboard wajib login sebelum bisa diakses.
