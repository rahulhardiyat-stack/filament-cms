# 🔎 Search, Sort, dan Filter

Filament table mendukung pencarian, pengurutan, dan filter data.

## 🔍 Searchable Column

Kode:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
    ->searchable()
```

Jika ada `searchable()`, kolom ikut dicari dari search box table.

## ↕️ Sortable Column

Kode:

```php
Tables\Columns\TextColumn::make('published_at')
    ->label('Dipublikasi')
    ->dateTime('d M Y')
    ->sortable()
```

Jika ada `sortable()`, header kolom bisa diklik untuk sorting.

## 🧭 Default Sort

Kode artikel:

```php
->defaultSort('published_at', 'desc')
```

Jika ingin default dari terbaru dibuat:

```php
->defaultSort('created_at', 'desc')
```

Jika ingin A-Z:

```php
->defaultSort('title', 'asc')
```

## 🗂️ SelectFilter Relationship

Kode:

```php
Tables\Filters\SelectFilter::make('category')
    ->label('Kategori')
    ->relationship('category', 'name')
    ->preload()
```

Filter ini membuat dropdown kategori berdasarkan relasi `category`.

## ✅ TernaryFilter Boolean

Kode:

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Publikasi')
    ->placeholder('Semua')
    ->trueLabel('Published')
    ->falseLabel('Draft')
```

Ternary filter punya 3 kondisi:

- Semua
- True
- False

## 📅 Filter Tanggal Custom

Kode:

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
            ->when(
                $data['published_from'],
                fn($query, $date) =>
                $query->whereDate('published_at', '>=', $date)
            )
            ->when(
                $data['published_until'],
                fn($query, $date) =>
                $query->whereDate('published_at', '<=', $date)
            );
    })
```

Filter ini membuat form tanggal dari-sampai.

## 🔘 Toggle Filter

Kode:

```php
Tables\Filters\Filter::make('has_replies')
    ->label('Memiliki Balasan')
    ->query(fn($query) => $query->has('replies'))
    ->toggle()
```

`toggle()` membuat filter menjadi switch aktif/nonaktif.

## 🏷️ Mengubah Label Filter

Ubah:

```php
->label('Status Publikasi')
```

Menjadi:

```php
->label('Status Artikel')
```

## ➕ Menambah Filter Baru

Contoh filter artikel populer:

```php
Tables\Filters\Filter::make('popular')
    ->label('Populer')
    ->query(fn($query) => $query->where('views_count', '>=', 100))
    ->toggle()
```

Letakkan di dalam:

```php
->filters([
    // filter di sini
])
```
