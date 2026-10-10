# 🎨 Custom Icon, Warna, dan Menu Sidebar

Halaman ini menjelaskan cara mengubah icon sidebar, warna panel, group menu, urutan menu, dan badge.

## 🖼️ Mengubah Icon Sidebar Menu

File contoh:

```txt
app/Filament/Resources/ArticleResource.php
```

Kode saat ini:

```php
protected static ?string $navigationIcon = 'heroicon-o-document-text';
```

Ubah menjadi:

```php
protected static ?string $navigationIcon = 'heroicon-o-newspaper';
```

## 🧩 Contoh Icon yang Bisa Dipakai

```php
'heroicon-o-document-text'
'heroicon-o-newspaper'
'heroicon-o-pencil-square'
'heroicon-o-photo'
'heroicon-o-user-group'
'heroicon-o-chat-bubble-left-right'
'heroicon-o-envelope'
'heroicon-o-tag'
'heroicon-o-rectangle-stack'
```

Project ini memakai icon Heroicons bawaan Filament.

## 🧭 Mengubah Group Menu

Kode:

```php
protected static ?string $navigationGroup = 'Konten';
```

Ubah menjadi:

```php
protected static ?string $navigationGroup = 'Manajemen Blog';
```

Contoh group saat ini:

```php
'Konten'
'Interaksi'
```

## ↕️ Mengubah Urutan Menu

Kode:

```php
protected static ?int $navigationSort = 3;
```

Semakin kecil angka, semakin atas posisi menu.

Contoh:

```php
protected static ?int $navigationSort = 1;
```

## 🏷️ Mengubah Badge Sidebar

Kode artikel:

```php
public static function getNavigationBadge(): ?string
{
    return static::getModel()::where('is_published', true)->count() . '/' . static::getModel()::count();
}
```

Jika hanya ingin total data:

```php
public static function getNavigationBadge(): ?string
{
    return (string) static::getModel()::count();
}
```

## 🎨 Mengubah Warna Badge Sidebar

Kode:

```php
public static function getNavigationBadgeColor(): ?string
{
    return 'success';
}
```

Contoh warna:

```php
return 'primary';
return 'success';
return 'warning';
return 'danger';
return 'info';
return 'gray';
```

## 🎨 Mengubah Warna Utama Panel

File:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

Kode:

```php
->colors([
    'primary' => Color::Amber,
])
```

Ubah menjadi:

```php
->colors([
    'primary' => Color::Blue,
])
```

## 🎨 Mengubah Warna Kolom Badge

Kode:

```php
->color(fn(Article $record) => match ($record->category->color) {
    'blue' => 'info',
    'red' => 'danger',
    'green' => 'success',
    'purple' => 'warning',
    'orange' => 'warning',
    'indigo' => 'primary',
    default => 'gray'
})
```

Ubah mapping warna sesuai kebutuhan.
