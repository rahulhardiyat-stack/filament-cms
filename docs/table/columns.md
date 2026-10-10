# 📋 Table Columns

Table list data didefinisikan di method `table()` pada setiap Resource.

## 📁 File Contoh

```txt
app/Filament/Resources/ArticleResource.php
```

Cari method:

```php
public static function table(Table $table): Table
```

## 📝 TextColumn

Kode:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
    ->searchable()
    ->sortable()
    ->limit(50)
    ->weight('bold')
    ->wrap()
```

Penjelasan:

| Method | Fungsi |
| --- | --- |
| `label()` | Label kolom. |
| `searchable()` | Masuk pencarian table. |
| `sortable()` | Bisa diurutkan. |
| `limit(50)` | Teks dipotong. |
| `weight('bold')` | Teks tebal. |
| `wrap()` | Teks boleh turun baris. |

## 🏷️ Badge Column dari Relationship

Kode:

```php
Tables\Columns\TextColumn::make('category.name')
    ->label('Kategori')
    ->badge()
    ->searchable()
    ->sortable()
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

`category.name` berarti kolom menampilkan nama kategori dari relasi `category`.

## 🖼️ ImageColumn

Kode artikel:

```php
Tables\Columns\ImageColumn::make('featured_image')
    ->label('Gambar')
    ->square()
```

Kode author:

```php
Tables\Columns\ImageColumn::make('avatar')
    ->label('Avatar')
    ->circular()
```

## ✅ IconColumn Boolean

Kode:

```php
Tables\Columns\IconColumn::make('is_published')
    ->label('Status')
    ->boolean()
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
    ->trueColor('success')
    ->falseColor('danger')
    ->sortable()
```

Fungsi:

- `true` tampil sebagai icon check.
- `false` tampil sebagai icon x.
- Warna bisa diubah lewat `trueColor()` dan `falseColor()`.

## 🔘 ToggleColumn

Kode:

```php
Tables\Columns\ToggleColumn::make('is_active')
    ->label('Aktif')
    ->sortable()
```

Admin bisa mengubah nilai boolean langsung dari table.

## 📋 Copyable Column

Kode:

```php
Tables\Columns\TextColumn::make('slug')
    ->label('Slug')
    ->searchable()
    ->copyable()
    ->icon('heroicon-m-link')
    ->color('gray')
```

`copyable()` membuat isi kolom bisa dicopy.

## 👁️ Toggleable Column

Kode:

```php
Tables\Columns\TextColumn::make('created_at')
    ->label('Dibuat')
    ->dateTime('d M Y H:i')
    ->sortable()
    ->toggleable(isToggledHiddenByDefault: true)
```

Kolom bisa ditampilkan/disembunyikan dari UI table.

## 🔢 Counts Relationship

Kode:

```php
Tables\Columns\TextColumn::make('articles_count')
    ->label('Artikel')
    ->counts('articles')
    ->sortable()
    ->badge()
    ->color('success')
```

`counts('articles')` menghitung jumlah relasi `articles`.

## 🧮 Format State

Kode:

```php
Tables\Columns\TextColumn::make('views_count')
    ->label('Views')
    ->sortable()
    ->formatStateUsing(fn($state) => number_format($state))
    ->icon('heroicon-m-eye')
    ->color('gray')
```

`formatStateUsing()` mengubah tampilan nilai sebelum ditampilkan.
