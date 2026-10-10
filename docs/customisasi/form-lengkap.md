# 🧱 Custom Form Lengkap

Halaman ini memperluas opsi custom form create/edit Filament v3. Semua contoh diambil dari pola project CMS ini.

## 📁 File yang Paling Sering Diedit

| Form | File |
| --- | --- |
| Artikel | `app/Filament/Resources/ArticleResource.php` |
| Kategori | `app/Filament/Resources/CategoryResource.php` |
| Penulis | `app/Filament/Resources/AuthorResource.php` |
| Komentar | `app/Filament/Resources/CommentResource.php` |
| Newsletter | `app/Filament/Resources/NewsletterSubscriberResource.php` |
| Tags | `app/Filament/Resources/TagResource.php` |

Cari method:

```php
public static function form(Form $form): Form
```

## 🏷️ Mengubah Label Field

Before:

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Artikel')
```

After:

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Postingan')
```

## 📦 Mengubah Judul Card/Section

Before:

```php
Forms\Components\Section::make('Konten Artikel')
```

After:

```php
Forms\Components\Section::make('Isi Artikel')
```

## 🧭 Mengubah Layout Kolom Form

Before:

```php
return $form
    ->schema([...])
    ->columns(3);
```

After menjadi 2 kolom:

```php
return $form
    ->schema([...])
    ->columns(2);
```

## ↔️ Mengubah Lebar Group

Before:

```php
Forms\Components\Group::make()
    ->schema([...])
    ->columnSpan(['lg' => 2])
```

After full width:

```php
Forms\Components\Group::make()
    ->schema([...])
    ->columnSpanFull()
```

## 📐 Mengubah Kolom di Dalam Section

Before:

```php
Forms\Components\Section::make('Informasi Penulis')
    ->schema([...])
    ->columns(2)
```

After 3 kolom:

```php
Forms\Components\Section::make('Informasi Penulis')
    ->schema([...])
    ->columns(3)
```

## 🧾 Membuat Field Full Width

Before:

```php
Forms\Components\Textarea::make('bio')
    ->label('Bio')
```

After:

```php
Forms\Components\Textarea::make('bio')
    ->label('Bio')
    ->columnSpanFull()
```

## ✅ Membuat Field Wajib atau Opsional

Wajib:

```php
->required()
```

Opsional:

```php
// hapus ->required()
```

Contoh before:

```php
Forms\Components\TextInput::make('email')
    ->label('Email')
    ->email()
    ->required()
```

After menjadi opsional:

```php
Forms\Components\TextInput::make('email')
    ->label('Email')
    ->email()
```

## 🔢 Mengubah Batas Panjang Input

Before:

```php
->maxLength(255)
```

After:

```php
->maxLength(150)
```

## 💬 Mengubah Helper Text

Before:

```php
->helperText('Ringkasan singkat artikel (maks. 500 karakter)')
```

After:

```php
->helperText('Teks ini akan muncul di halaman daftar artikel.')
```

## 👻 Mengubah Placeholder

Before:

```php
->placeholder('e.g. Senior Tech Writer')
```

After:

```php
->placeholder('Contoh: Editor Teknologi')
```

## 🧲 Menambah Prefix Icon

Before:

```php
Forms\Components\TextInput::make('website_url')
    ->label('Website URL')
    ->url()
```

After:

```php
Forms\Components\TextInput::make('website_url')
    ->label('Website URL')
    ->url()
    ->prefixIcon('heroicon-m-link')
```

## 🏷️ Menambah Suffix Text

Before:

```php
Forms\Components\TextInput::make('read_time')
    ->label('Waktu Baca')
    ->numeric()
```

After:

```php
Forms\Components\TextInput::make('read_time')
    ->label('Waktu Baca')
    ->numeric()
    ->suffix('menit')
```

## 🔘 Mengubah Default Toggle

Before:

```php
Forms\Components\Toggle::make('is_published')
    ->label('Publikasikan')
    ->default(false)
```

After default aktif:

```php
Forms\Components\Toggle::make('is_published')
    ->label('Publikasikan')
    ->default(true)
```

## 👁️ Menampilkan Field Berdasarkan Kondisi

Kode saat ini:

```php
Forms\Components\DateTimePicker::make('published_at')
    ->label('Tanggal Publikasi')
    ->visible(fn(Forms\Get $get) => $get('is_published'))
```

Artinya field tanggal hanya muncul jika `is_published` aktif.

## 🙈 Menyembunyikan Section Saat Create

Kode:

```php
->hidden(fn(?Article $record) => $record === null)
```

Dipakai untuk metadata yang hanya tampil saat edit.

## 🔒 Disable Field Saat Edit

Kode dari komentar:

```php
Forms\Components\Select::make('article_id')
    ->label('Artikel')
    ->relationship('article', 'title')
    ->disabled(fn(?Comment $record) => $record !== null)
```

Artinya artikel bisa dipilih saat create, tetapi tidak bisa diganti saat edit.

## 🖼️ Mengubah Folder Upload

Before:

```php
->directory('articles/featured')
```

After:

```php
->directory('uploads/articles/featured')
```

## 📏 Mengubah Maksimal Ukuran Upload

Before:

```php
->maxSize(5120)
```

After maksimal 2MB:

```php
->maxSize(2048)
```

## ✂️ Mengubah Rasio Crop Image

Before:

```php
->imageEditorAspectRatios([
    '16:9',
    '4:3',
    '1:1',
])
```

After:

```php
->imageEditorAspectRatios([
    '16:9',
    '1:1',
])
```

## 🧰 Mengubah Toolbar RichEditor

Before:

```php
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
])
```

After lebih sederhana:

```php
->toolbarButtons([
    'bold',
    'italic',
    'link',
    'bulletList',
    'orderedList',
    'undo',
    'redo',
])
```

## 🔗 Mengubah Select Relationship Menjadi Searchable

Before:

```php
Forms\Components\Select::make('category_id')
    ->relationship('category', 'name')
```

After:

```php
Forms\Components\Select::make('category_id')
    ->relationship('category', 'name')
    ->searchable()
    ->preload()
```

## ➕ Menambah Inline Create pada Select

Contoh:

```php
Forms\Components\Select::make('category_id')
    ->label('Kategori')
    ->relationship('category', 'name')
    ->createOptionForm([
        Forms\Components\TextInput::make('name')
            ->label('Nama Kategori')
            ->required(),
        Forms\Components\TextInput::make('slug')
            ->label('Slug')
            ->required(),
    ])
```

## 🧪 Menambah Field Baru ke Form

Langkah umum:

1. Tambahkan kolom di migration.
2. Tambahkan field ke `$fillable` model.
3. Tambahkan component di `form()`.
4. Tambahkan column di `table()` jika ingin tampil di list.

Contoh field SEO:

```php
Forms\Components\TextInput::make('seo_title')
    ->label('SEO Title')
    ->maxLength(255)
    ->helperText('Judul khusus untuk Google dan social media')
```
