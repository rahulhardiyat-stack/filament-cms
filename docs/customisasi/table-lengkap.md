# 📊 Custom Table Lengkap

Halaman ini menjelaskan opsi custom table list data Filament secara lebih lengkap.

## 📁 File yang Diedit

Contoh artikel:

```txt
app/Filament/Resources/ArticleResource.php
```

Cari method:

```php
public static function table(Table $table): Table
```

## 🏷️ Mengubah Label Kolom

Before:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
```

After:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul Artikel')
```

## 🔍 Mengaktifkan Search Kolom

Before:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
```

After:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
    ->searchable()
```

## ↕️ Mengaktifkan Sort Kolom

Before:

```php
Tables\Columns\TextColumn::make('views_count')
    ->label('Views')
```

After:

```php
Tables\Columns\TextColumn::make('views_count')
    ->label('Views')
    ->sortable()
```

## 🧭 Mengubah Default Sort

Before:

```php
->defaultSort('published_at', 'desc')
```

After sort berdasarkan views:

```php
->defaultSort('views_count', 'desc')
```

## ✂️ Membatasi Panjang Teks

Before:

```php
Tables\Columns\TextColumn::make('content')
    ->label('Komentar')
```

After:

```php
Tables\Columns\TextColumn::make('content')
    ->label('Komentar')
    ->limit(50)
    ->wrap()
```

## 💪 Membuat Teks Tebal

```php
->weight('bold')
```

Contoh:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
    ->weight('bold')
```

## 🏷️ Mengubah Kolom Jadi Badge

Before:

```php
Tables\Columns\TextColumn::make('category.name')
    ->label('Kategori')
```

After:

```php
Tables\Columns\TextColumn::make('category.name')
    ->label('Kategori')
    ->badge()
```

## 🎨 Mengubah Warna Kolom

Warna statis:

```php
->color('success')
```

Warna dinamis:

```php
->color(fn(Article $record) => $record->is_published ? 'success' : 'warning')
```

## 🖼️ Mengubah Bentuk Gambar

Square:

```php
Tables\Columns\ImageColumn::make('featured_image')
    ->label('Gambar')
    ->square()
```

Circle:

```php
Tables\Columns\ImageColumn::make('avatar')
    ->label('Avatar')
    ->circular()
```

## ✅ Mengubah Icon Boolean

Before:

```php
Tables\Columns\IconColumn::make('is_published')
    ->boolean()
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
```

After:

```php
Tables\Columns\IconColumn::make('is_published')
    ->boolean()
    ->trueIcon('heroicon-o-eye')
    ->falseIcon('heroicon-o-eye-slash')
```

## 🎨 Mengubah Warna Boolean

```php
->trueColor('success')
->falseColor('danger')
```

Contoh:

```php
->trueColor('primary')
->falseColor('gray')
```

## 🔘 Membuat Kolom Bisa Toggle Langsung

```php
Tables\Columns\ToggleColumn::make('is_active')
    ->label('Aktif')
```

Admin bisa mengubah status langsung dari table.

## 📋 Membuat Kolom Bisa Dicopy

```php
Tables\Columns\TextColumn::make('email')
    ->label('Email')
    ->copyable()
```

## 👁️ Membuat Kolom Bisa Hide/Show

```php
->toggleable()
```

Default hidden:

```php
->toggleable(isToggledHiddenByDefault: true)
```

## 📅 Mengubah Format Tanggal

Before:

```php
->dateTime('d M Y H:i')
```

After:

```php
->dateTime('d/m/Y')
```

Relative time:

```php
->since()
```

## 📝 Menambah Description di Kolom

Kode dari newsletter:

```php
Tables\Columns\TextColumn::make('subscribed_at')
    ->label('Berlangganan')
    ->since()
    ->description(
        fn(NewsletterSubscriber $record): string =>
        $record->subscribed_at->format('d M Y H:i')
    )
```

Description tampil sebagai teks kecil tambahan.

## 🔢 Format Number

Before:

```php
Tables\Columns\TextColumn::make('views_count')
    ->label('Views')
```

After:

```php
Tables\Columns\TextColumn::make('views_count')
    ->label('Views')
    ->formatStateUsing(fn($state) => number_format($state))
```

## 🔗 Kolom Menjadi Link

Kode komentar:

```php
Tables\Columns\TextColumn::make('article.title')
    ->label('Artikel')
    ->url(fn(Comment $record): string => route('article.detail', $record->article->slug))
    ->openUrlInNewTab()
```

## 🔎 Custom Select Filter

```php
Tables\Filters\SelectFilter::make('category')
    ->label('Kategori')
    ->relationship('category', 'name')
    ->preload()
```

## ✅ Custom Boolean Filter

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Artikel')
    ->placeholder('Semua Status')
    ->trueLabel('Terbit')
    ->falseLabel('Draf')
```

## 📅 Custom Date Filter

```php
Tables\Filters\Filter::make('published_at')
    ->form([
        Forms\Components\DatePicker::make('published_from')
            ->label('Dari Tanggal'),
        Forms\Components\DatePicker::make('published_until')
            ->label('Sampai Tanggal'),
    ])
    ->query(function ($query, array $data) {
        return $query
            ->when($data['published_from'], fn($query, $date) => $query->whereDate('published_at', '>=', $date))
            ->when($data['published_until'], fn($query, $date) => $query->whereDate('published_at', '<=', $date));
    })
```

## ➕ Menambah Kolom Baru

Contoh menampilkan SEO title:

```php
Tables\Columns\TextColumn::make('seo_title')
    ->label('SEO Title')
    ->searchable()
    ->sortable()
    ->toggleable(isToggledHiddenByDefault: true)
```

Letakkan di dalam:

```php
->columns([
    // kolom di sini
])
```
