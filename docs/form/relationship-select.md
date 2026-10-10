# 🔗 Relationship Select

Relationship select dipakai untuk memilih data dari tabel/model lain.

## 📁 File Utama

```txt
app/Filament/Resources/ArticleResource.php
```

## 🗂️ Select Kategori

Kode:

```php
Forms\Components\Select::make('category_id')
    ->label('Kategori')
    ->relationship('category', 'name')
    ->required()
    ->searchable()
    ->preload()
```

Penjelasan:

| Kode | Fungsi |
| --- | --- |
| `make('category_id')` | Field mengisi kolom `category_id`. |
| `relationship('category', 'name')` | Ambil data dari relasi `category`, tampilkan kolom `name`. |
| `searchable()` | Dropdown bisa dicari. |
| `preload()` | Opsi dimuat lebih awal. |

## 👤 Select Penulis

Kode:

```php
Forms\Components\Select::make('author_id')
    ->label('Penulis')
    ->relationship('author', 'name')
    ->required()
    ->searchable()
    ->preload()
```

## 🏷️ Select Tags Banyak Data

Kode:

```php
Forms\Components\Select::make('tags')
    ->label('Tags')
    ->relationship('tags', 'name')
    ->multiple()
    ->preload()
```

`multiple()` berarti admin bisa memilih lebih dari satu tag.

## ➕ Create Option dari Dalam Form

Kategori bisa dibuat langsung dari form artikel:

```php
->createOptionForm([
    Forms\Components\TextInput::make('name')
        ->required()
        ->maxLength(255),
    Forms\Components\TextInput::make('slug')
        ->required()
        ->maxLength(255),
    Forms\Components\Select::make('color')
        ->options([
            'blue' => 'Biru',
            'red' => 'Merah',
            'green' => 'Hijau',
            'purple' => 'Ungu',
            'orange' => 'Oranye',
            'indigo' => 'Indigo',
        ])
        ->required(),
])
```

## 🏷️ Mengubah Label Dropdown

Ubah:

```php
->label('Kategori')
```

Menjadi:

```php
->label('Kategori Artikel')
```

## 🔍 Mematikan Search Dropdown

Hapus:

```php
->searchable()
```

## ⚡ Mematikan Preload

Hapus:

```php
->preload()
```

Ini bisa berguna jika data relasi sangat banyak.
