# 🏗️ Layout Grid & Section Form

Halaman create/edit di Filament dibentuk dari method `form()` pada setiap Resource.

## 📁 File yang Diedit

Contoh artikel:

```txt
app/Filament/Resources/ArticleResource.php
```

Cari method:

```php
public static function form(Form $form): Form
```

## 🧱 Layout Grid Artikel

Kode:

```php
return $form
    ->schema([
        Forms\Components\Group::make()
            ->schema([
                // konten utama
            ])
            ->columnSpan(['lg' => 2]),

        Forms\Components\Group::make()
            ->schema([
                // sidebar pengaturan
            ])
            ->columnSpan(['lg' => 1]),
    ])
    ->columns(3);
```

Artinya:

- Grid form memiliki 3 kolom.
- Group kiri mengambil 2 kolom.
- Group kanan mengambil 1 kolom.
- Ini membuat layout seperti CMS: konten utama di kiri, pengaturan di kanan.

## 🧩 Mengubah Jumlah Kolom

Dari 3 kolom:

```php
->columns(3)
```

Menjadi 2 kolom:

```php
->columns(2)
```

## 📦 Mengubah Lebar Group

Kode saat ini:

```php
->columnSpan(['lg' => 2])
```

Jika ingin group memenuhi semua kolom:

```php
->columnSpanFull()
```

## 🧾 Section sebagai Card Form

Kode:

```php
Forms\Components\Section::make('Konten Artikel')
    ->schema([
        // field
    ])
```

`Section::make('Konten Artikel')` adalah judul card.

## 🏷️ Mengubah Judul Card

Ubah:

```php
Forms\Components\Section::make('Konten Artikel')
```

Menjadi:

```php
Forms\Components\Section::make('Isi Postingan')
```

## 📐 Section 2 Kolom

Contoh dari `CategoryResource.php`:

```php
Forms\Components\Section::make('Informasi Kategori')
    ->schema([
        // fields
    ])
    ->columns(2)
```

## ↔️ Field Full Width

Kode:

```php
Forms\Components\Textarea::make('description')
    ->label('Deskripsi')
    ->columnSpanFull()
```

`columnSpanFull()` membuat field memenuhi lebar section.

## 🧭 Section di Project Ini

| Resource | Section |
| --- | --- |
| Article | `Konten Artikel`, `Featured Image`, `Pengaturan`, `Status & Publikasi`, `Metadata` |
| Category | `Informasi Kategori` |
| Author | `Informasi Penulis`, `Social Media`, `Status` |
| Comment | `Informasi Komentar`, `Status & Pengaturan`, `Metadata` |
| Newsletter | `Informasi Subscriber`, `Metadata` |
| Tag | `Informasi Tag`, `Statistik` |
