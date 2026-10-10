# ✏️ Field Input Form

Field input adalah komponen form yang dipakai pada halaman create/edit.

## 🏷️ TextInput

Contoh:

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Artikel')
    ->required()
    ->maxLength(255)
```

Penjelasan:

| Kode | Fungsi |
| --- | --- |
| `make('title')` | Field terhubung ke kolom `title`. |
| `label('Judul Artikel')` | Label yang tampil di UI. |
| `required()` | Wajib diisi. |
| `maxLength(255)` | Maksimal 255 karakter. |

## 🏷️ Mengubah Label Field

Ubah:

```php
->label('Judul Artikel')
```

Menjadi:

```php
->label('Judul Postingan')
```

## 🔗 Auto Slug

Kode:

```php
Forms\Components\TextInput::make('title')
    ->live(onBlur: true)
    ->afterStateUpdated(
        fn(string $operation, $state, Forms\Set $set) =>
        $operation === 'create' ? $set('slug', Str::slug($state)) : null
    )
```

Fungsi:

- Saat create, slug otomatis dibuat dari title.
- `live(onBlur: true)` membuat perubahan dikirim setelah user keluar dari input.

## 📝 Textarea

Contoh:

```php
Forms\Components\Textarea::make('excerpt')
    ->label('Excerpt/Ringkasan')
    ->required()
    ->rows(3)
    ->maxLength(500)
    ->helperText('Ringkasan singkat artikel (maks. 500 karakter)')
```

Dipakai untuk:

- ringkasan artikel
- deskripsi kategori
- bio penulis
- isi komentar

## 🧾 RichEditor

Contoh:

```php
Forms\Components\RichEditor::make('content')
    ->label('Konten Artikel')
    ->required()
    ->columnSpanFull()
    ->fileAttachmentsDirectory('articles')
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

## 🛠️ Mengubah Tombol Toolbar Editor

Cari:

```php
->toolbarButtons([
    'attachFiles',
    'blockquote',
    'bold',
])
```

Hapus item jika tidak ingin tombol muncul. Tambah item jika ingin toolbar tambahan yang didukung Filament.

## 🖼️ FileUpload Image

Contoh:

```php
Forms\Components\FileUpload::make('featured_image')
    ->label('Gambar Utama')
    ->image()
    ->directory('articles/featured')
    ->maxSize(5120)
    ->imageEditor()
    ->imageEditorAspectRatios([
        '16:9',
        '4:3',
        '1:1',
    ])
```

Fungsi:

- `image()` hanya menerima gambar.
- `directory()` menentukan folder upload.
- `maxSize(5120)` maksimal 5MB.
- `imageEditor()` mengaktifkan editor gambar.
- `imageEditorAspectRatios()` mengatur pilihan crop.

## 🔘 Toggle

Contoh:

```php
Forms\Components\Toggle::make('is_published')
    ->label('Publikasikan')
    ->default(false)
    ->live()
```

Dipakai untuk boolean seperti:

- publish artikel
- featured artikel
- kategori aktif
- penulis aktif
- komentar approved
- subscriber aktif

## 🕒 DateTimePicker Conditional

Kode:

```php
Forms\Components\DateTimePicker::make('published_at')
    ->label('Tanggal Publikasi')
    ->default(now())
    ->required()
    ->visible(fn(Forms\Get $get) => $get('is_published'))
```

Field ini hanya muncul jika toggle `is_published` aktif.

## 📌 Placeholder Metadata

Contoh:

```php
Forms\Components\Placeholder::make('views_count')
    ->label('Total Views')
    ->content(fn(?Article $record): string => $record ? number_format($record->views_count) : '0')
```

Placeholder hanya untuk menampilkan informasi, bukan input.

## 👻 Menyembunyikan Field Saat Create

Kode:

```php
->hidden(fn(?Article $record) => $record === null)
```

Artinya field/section tidak tampil saat create, hanya tampil saat edit.
