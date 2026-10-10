# 🏷️ Custom Label & Teks

Halaman ini fokus pada cara mengubah teks yang muncul di dashboard Filament.

## 🧭 Label Menu Sidebar

File contoh:

```txt
app/Filament/Resources/ArticleResource.php
```

Kode:

```php
protected static ?string $navigationLabel = 'Artikel';
```

Ubah menjadi:

```php
protected static ?string $navigationLabel = 'Blog Posts';
```

## 📦 Label Model

Kode:

```php
protected static ?string $modelLabel = 'Artikel';
protected static ?string $pluralModelLabel = 'Artikel';
```

Ubah menjadi:

```php
protected static ?string $modelLabel = 'Post';
protected static ?string $pluralModelLabel = 'Posts';
```

## 🧾 Label Field Form

Cari di method `form()`:

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Artikel')
```

Ubah:

```php
->label('Judul Postingan')
```

## 📦 Judul Card/Section

Cari:

```php
Forms\Components\Section::make('Konten Artikel')
```

Ubah:

```php
Forms\Components\Section::make('Isi Postingan')
```

## 💬 Helper Text

Kode:

```php
->helperText('Ringkasan singkat artikel (maks. 500 karakter)')
```

Ubah:

```php
->helperText('Tulis ringkasan pendek untuk halaman daftar artikel.')
```

## 👻 Placeholder Input

Kode:

```php
->placeholder('e.g. Senior Tech Writer')
```

Ubah:

```php
->placeholder('Contoh: Editor, Penulis, Content Strategist')
```

## 📊 Label Kolom Table

Cari di method `table()`:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
```

Ubah:

```php
->label('Judul Artikel')
```

## 🔎 Label Filter

Kode:

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Publikasi')
    ->placeholder('Semua')
    ->trueLabel('Published')
    ->falseLabel('Draft')
```

Ubah:

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Artikel')
    ->placeholder('Semua Status')
    ->trueLabel('Terbit')
    ->falseLabel('Draf')
```

## 🔘 Label Button Action

Kode:

```php
Tables\Actions\Action::make('visit')
    ->label('Lihat di Website')
```

Ubah:

```php
->label('Buka Artikel')
```

## 📣 Label Modal

Kode:

```php
->modalHeading('Hapus artikel ini?')
->modalDescription('Data artikel akan dihapus dari CMS.')
->modalSubmitActionLabel('Ya, hapus')
->modalCancelActionLabel('Batal')
```

Method ini bisa dipakai pada action yang memiliki confirmation modal.
