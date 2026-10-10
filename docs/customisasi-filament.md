# Customisasi Filament v3

Halaman ini berisi panduan praktis untuk mengubah tampilan, label, tombol, form, table, card, action dropdown, dan layout Filament v3 pada project CMS ini.

## 1. Mengubah URL admin

File:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

Kode saat ini:

```php
->path('admin')
```

Jika ingin URL admin menjadi `/dashboard`:

```php
->path('dashboard')
```

## 2. Mengubah warna utama panel

File:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

Kode saat ini:

```php
->colors([
    'primary' => Color::Amber,
])
```

Contoh ubah menjadi biru:

```php
->colors([
    'primary' => Color::Blue,
])
```

Contoh warna lain yang umum:

```php
Color::Red
Color::Green
Color::Blue
Color::Amber
Color::Indigo
Color::Purple
Color::Pink
Color::Slate
```

## 3. Mengubah nama menu sidebar

File contoh:

```txt
app/Filament/Resources/ArticleResource.php
```

Kode saat ini:

```php
protected static ?string $navigationLabel = 'Artikel';
```

Jika ingin menu menjadi `Blog Posts`:

```php
protected static ?string $navigationLabel = 'Blog Posts';
```

Resource lain juga memakai pola yang sama:

```php
protected static ?string $navigationLabel = 'Kategori';
protected static ?string $navigationLabel = 'Penulis';
protected static ?string $navigationLabel = 'Komentar';
protected static ?string $navigationLabel = 'Newsletter';
protected static ?string $navigationLabel = 'Tags';
```

## 4. Mengubah label model

Label model mempengaruhi teks bawaan Filament seperti create/edit/delete record.

Kode:

```php
protected static ?string $modelLabel = 'Artikel';
protected static ?string $pluralModelLabel = 'Artikel';
```

Contoh:

```php
protected static ?string $modelLabel = 'Post';
protected static ?string $pluralModelLabel = 'Posts';
```

## 5. Mengubah group menu

Kode saat ini:

```php
protected static ?string $navigationGroup = 'Konten';
```

Jika ingin artikel masuk group `Manajemen Blog`:

```php
protected static ?string $navigationGroup = 'Manajemen Blog';
```

Contoh di project:

```php
protected static ?string $navigationGroup = 'Konten';
protected static ?string $navigationGroup = 'Interaksi';
```

## 6. Mengubah urutan menu

Kode:

```php
protected static ?int $navigationSort = 3;
```

Semakin kecil angka, semakin atas posisinya.

Contoh urutan group `Konten` saat ini:

```php
CategoryResource    -> 1
AuthorResource      -> 2
ArticleResource     -> 3
TagResource         -> 4
```

Jika ingin Artikel paling atas:

```php
protected static ?int $navigationSort = 1;
```

## 7. Mengubah icon menu

Kode:

```php
protected static ?string $navigationIcon = 'heroicon-o-document-text';
```

Contoh icon lain:

```php
protected static ?string $navigationIcon = 'heroicon-o-newspaper';
protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
protected static ?string $navigationIcon = 'heroicon-o-photo';
protected static ?string $navigationIcon = 'heroicon-o-user-group';
```

Project ini memakai icon Heroicons bawaan Filament.

## 8. Mengubah label field form

Cari field pada method `form()` Resource.

Contoh:

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Artikel')
```

Ubah menjadi:

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Postingan')
```

Label field lain:

```php
->label('Slug')
->label('Excerpt/Ringkasan')
->label('Konten Artikel')
->label('Gambar Utama')
->label('Kategori')
->label('Penulis')
->label('Tags')
->label('Publikasikan')
->label('Tanggal Publikasi')
```

## 9. Mengubah judul card atau section form

Card form dibuat memakai `Section::make()`.

Kode saat ini:

```php
Forms\Components\Section::make('Konten Artikel')
```

Jika ingin diganti:

```php
Forms\Components\Section::make('Isi Postingan')
```

Contoh section di artikel:

```php
Forms\Components\Section::make('Konten Artikel')
Forms\Components\Section::make('Featured Image')
Forms\Components\Section::make('Pengaturan')
Forms\Components\Section::make('Status & Publikasi')
Forms\Components\Section::make('Metadata')
```

Contoh section di penulis:

```php
Forms\Components\Section::make('Informasi Penulis')
Forms\Components\Section::make('Social Media')
Forms\Components\Section::make('Status')
```

## 10. Mengubah layout form grid

Artikel memakai 3 kolom:

```php
return $form
    ->schema([
        Forms\Components\Group::make()
            ->schema([...])
            ->columnSpan(['lg' => 2]),

        Forms\Components\Group::make()
            ->schema([...])
            ->columnSpan(['lg' => 1]),
    ])
    ->columns(3);
```

Jika ingin layout 2 kolom:

```php
return $form
    ->schema([
        Forms\Components\Group::make()
            ->schema([...])
            ->columnSpan(['lg' => 1]),

        Forms\Components\Group::make()
            ->schema([...])
            ->columnSpan(['lg' => 1]),
    ])
    ->columns(2);
```

Jika ingin section field 2 kolom:

```php
Forms\Components\Section::make('Informasi Kategori')
    ->schema([
        // fields
    ])
    ->columns(2)
```

Jika field ingin memenuhi lebar penuh:

```php
->columnSpanFull()
```

Contoh:

```php
Forms\Components\Textarea::make('description')
    ->label('Deskripsi')
    ->columnSpanFull()
```

## 11. Mengubah helper text

Kode:

```php
->helperText('Ringkasan singkat artikel (maks. 500 karakter)')
```

Ubah menjadi:

```php
->helperText('Tulis ringkasan pendek yang akan tampil di halaman daftar artikel.')
```

Helper text berguna untuk memberi instruksi kepada admin.

## 12. Mengubah placeholder input

Contoh dari `AuthorResource`:

```php
Forms\Components\TextInput::make('title')
    ->label('Jabatan/Title')
    ->placeholder('e.g. Senior Tech Writer')
```

Ubah placeholder:

```php
->placeholder('Contoh: Editor, Penulis, Content Strategist')
```

## 13. Mengubah validasi field

Contoh required:

```php
->required()
```

Jika field tidak wajib, hapus `required()`.

Contoh panjang maksimal:

```php
->maxLength(255)
```

Contoh numeric:

```php
->numeric()
->minValue(1)
```

Contoh email:

```php
->email()
```

Contoh URL:

```php
->url()
```

Contoh unique:

```php
->unique(ignoreRecord: true)
```

## 14. Mengubah label kolom table

Cari method `table()`.

Kode:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
```

Ubah menjadi:

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul Artikel')
```

## 15. Mengaktifkan atau mematikan searching kolom

Kolom searchable:

```php
->searchable()
```

Jika tidak ingin kolom masuk pencarian, hapus method tersebut.

Contoh:

```php
Tables\Columns\TextColumn::make('author_email')
    ->label('Email')
    ->searchable()
```

## 16. Mengaktifkan atau mematikan sorting kolom

Kolom sortable:

```php
->sortable()
```

Jika tidak ingin kolom bisa diurutkan, hapus method tersebut.

## 17. Mengubah default sorting table

Kode artikel:

```php
->defaultSort('published_at', 'desc')
```

Jika ingin artikel terbaru berdasarkan tanggal dibuat:

```php
->defaultSort('created_at', 'desc')
```

Jika ingin berdasarkan judul A-Z:

```php
->defaultSort('title', 'asc')
```

## 18. Mengubah filter label

Kode:

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Publikasi')
    ->placeholder('Semua')
    ->trueLabel('Published')
    ->falseLabel('Draft')
```

Contoh ubah ke Bahasa Indonesia penuh:

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Artikel')
    ->placeholder('Semua Status')
    ->trueLabel('Terbit')
    ->falseLabel('Draf')
```

## 19. Menambah opsi filter select

Contoh filter warna kategori:

```php
Tables\Filters\SelectFilter::make('color')
    ->label('Warna')
    ->options([
        'blue' => 'Biru',
        'red' => 'Merah',
        'green' => 'Hijau',
        'purple' => 'Ungu',
        'orange' => 'Oranye',
        'indigo' => 'Indigo',
    ])
```

Jika ingin menambah warna hitam:

```php
'black' => 'Hitam',
```

Pastikan bagian form kategori juga ditambah opsi yang sama.

## 20. Mengubah label action dropdown

Action dropdown artikel:

```php
Tables\Actions\ActionGroup::make([
    Tables\Actions\ViewAction::make(),
    Tables\Actions\EditAction::make(),
    Tables\Actions\Action::make('visit')
        ->label('Lihat di Website')
        ->url(fn(Article $record): string => route('article.detail', $record->slug))
        ->icon('heroicon-m-arrow-top-right-on-square')
        ->openUrlInNewTab(),
    Tables\Actions\DeleteAction::make(),
])
```

Ubah label custom action:

```php
->label('Buka Artikel')
```

Untuk action bawaan seperti Edit/Delete, bisa diberi label juga:

```php
Tables\Actions\EditAction::make()
    ->label('Ubah')

Tables\Actions\DeleteAction::make()
    ->label('Hapus')
```

## 21. Mengubah warna action button

Kode:

```php
->color('success')
```

Pilihan warna umum:

```php
->color('primary')
->color('success')
->color('warning')
->color('danger')
->color('info')
->color('gray')
```

Contoh:

```php
Tables\Actions\Action::make('approve')
    ->label('Setujui')
    ->color('success')
```

## 22. Mengubah icon action button

Kode:

```php
->icon('heroicon-o-check-circle')
```

Contoh:

```php
->icon('heroicon-o-paper-airplane')
->icon('heroicon-o-x-circle')
->icon('heroicon-o-pencil-square')
->icon('heroicon-o-trash')
```

## 23. Menyembunyikan action berdasarkan kondisi

Kode approve komentar:

```php
->hidden(fn(Comment $record) => $record->is_approved)
```

Artinya tombol `Setujui` disembunyikan jika komentar sudah approved.

Kebalikannya:

```php
->hidden(fn(Comment $record) => !$record->is_approved)
```

Artinya tombol hanya tampil ketika komentar approved.

## 24. Mengubah teks modal konfirmasi

Kode newsletter:

```php
->requiresConfirmation()
->modalDescription('Fitur ini akan mengirim test email ke subscriber.')
```

Bisa ditambah title:

```php
->modalHeading('Kirim test email?')
->modalDescription('Email percobaan akan dikirim ke subscriber ini.')
->modalSubmitActionLabel('Ya, kirim')
->modalCancelActionLabel('Batal')
```

## 25. Mengubah notifikasi setelah action

Kode:

```php
Notification::make()
    ->title('Komentar disetujui')
    ->success()
    ->send();
```

Contoh dengan body:

```php
Notification::make()
    ->title('Berhasil')
    ->body('Komentar sudah tampil di website.')
    ->success()
    ->send();
```

Jenis notifikasi:

```php
->success()
->warning()
->danger()
->info()
```

## 26. Mengubah label bulk action

Kode:

```php
Tables\Actions\BulkAction::make('publish')
    ->label('Publikasikan')
```

Ubah menjadi:

```php
->label('Terbitkan Artikel Terpilih')
```

Contoh bulk action delete:

```php
Tables\Actions\DeleteBulkAction::make()
    ->label('Hapus Data Terpilih')
```

## 27. Mengubah tombol create di halaman list

File:

```txt
app/Filament/Resources/ArticleResource/Pages/ListArticles.php
```

Kode saat ini:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make(),
    ];
}
```

Ubah label tombol create:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make()
            ->label('Tulis Artikel Baru')
            ->icon('heroicon-o-pencil-square'),
    ];
}
```

## 28. Mengubah tombol delete di halaman edit

File:

```txt
app/Filament/Resources/ArticleResource/Pages/EditArticle.php
```

Kode saat ini:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\DeleteAction::make(),
    ];
}
```

Ubah menjadi:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\DeleteAction::make()
            ->label('Hapus Artikel')
            ->modalHeading('Hapus artikel ini?')
            ->modalDescription('Data artikel akan dihapus dari CMS.')
            ->modalSubmitActionLabel('Ya, hapus'),
    ];
}
```

## 29. Mengubah navigation badge

Kode artikel:

```php
public static function getNavigationBadge(): ?string
{
    return static::getModel()::where('is_published', true)->count() . '/' . static::getModel()::count();
}
```

Jika hanya ingin menampilkan total artikel:

```php
public static function getNavigationBadge(): ?string
{
    return (string) static::getModel()::count();
}
```

Ubah warna badge:

```php
public static function getNavigationBadgeColor(): ?string
{
    return 'warning';
}
```

## 30. Mengubah widget statistik

File:

```txt
app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php
```

Contoh ubah label card:

```php
Stat::make('Total Subscribers', $total)
```

Menjadi:

```php
Stat::make('Total Pelanggan', $total)
```

Ubah description:

```php
->description('Total semua subscriber')
```

Menjadi:

```php
->description('Jumlah seluruh email yang pernah mendaftar')
```

Ubah warna:

```php
->color('primary')
```

Menjadi:

```php
->color('success')
```

## 31. Menambah field baru ke form Filament

Urutan umum:

1. Tambahkan kolom di migration.
2. Tambahkan kolom ke `$fillable` model.
3. Tambahkan field ke `form()` Resource.
4. Tambahkan kolom ke `table()` jika perlu.

Contoh menambah field SEO title artikel:

```php
Forms\Components\TextInput::make('seo_title')
    ->label('SEO Title')
    ->maxLength(255)
    ->helperText('Judul khusus untuk mesin pencari')
```

Contoh menampilkan di table:

```php
Tables\Columns\TextColumn::make('seo_title')
    ->label('SEO Title')
    ->searchable()
    ->toggleable(isToggledHiddenByDefault: true)
```

## 32. Menambah action baru di table

Contoh action untuk duplicate artikel:

```php
Tables\Actions\Action::make('duplicate')
    ->label('Duplikat')
    ->icon('heroicon-o-document-duplicate')
    ->color('gray')
    ->requiresConfirmation()
    ->action(function (Article $record) {
        $copy = $record->replicate();
        $copy->title = $record->title . ' Copy';
        $copy->slug = $record->slug . '-copy';
        $copy->is_published = false;
        $copy->published_at = null;
        $copy->save();
    })
```

Letakkan di dalam `ActionGroup::make([...])` pada `ArticleResource::table()`.

## 33. Menambah filter baru

Contoh filter artikel dengan views lebih dari 100:

```php
Tables\Filters\Filter::make('popular')
    ->label('Populer')
    ->query(fn($query) => $query->where('views_count', '>=', 100))
    ->toggle()
```

Letakkan di array `->filters([...])`.

## 34. Menambah kolom badge status custom

Contoh:

```php
Tables\Columns\TextColumn::make('status_label')
    ->label('Status')
    ->badge()
    ->state(fn(Article $record): string => $record->is_published ? 'Published' : 'Draft')
    ->color(fn(Article $record): string => $record->is_published ? 'success' : 'warning')
```

Ini berguna jika ingin status tampil sebagai teks badge, bukan icon.

## 35. Membuat field conditional

Contoh field hanya muncul saat artikel published:

```php
Forms\Components\DateTimePicker::make('published_at')
    ->label('Tanggal Publikasi')
    ->visible(fn(Forms\Get $get) => $get('is_published'))
```

Jika field perlu reactive, toggle sumbernya harus memakai:

```php
->live()
```

## 36. Menonaktifkan field saat edit

Contoh dari `CommentResource`:

```php
Forms\Components\Select::make('article_id')
    ->label('Artikel')
    ->relationship('article', 'title')
    ->required()
    ->searchable()
    ->preload()
    ->disabled(fn(?Comment $record) => $record !== null)
```

Artinya field artikel hanya bisa dipilih saat create, lalu disabled saat edit.

## 37. File-file yang paling sering diedit

| Tujuan | File |
| --- | --- |
| Ubah URL admin, warna panel, widget dashboard | `app/Providers/Filament/AdminPanelProvider.php` |
| Ubah menu/form/table/action artikel | `app/Filament/Resources/ArticleResource.php` |
| Ubah halaman list artikel | `app/Filament/Resources/ArticleResource/Pages/ListArticles.php` |
| Ubah halaman create artikel | `app/Filament/Resources/ArticleResource/Pages/CreateArticle.php` |
| Ubah halaman edit artikel | `app/Filament/Resources/ArticleResource/Pages/EditArticle.php` |
| Ubah kategori | `app/Filament/Resources/CategoryResource.php` |
| Ubah penulis | `app/Filament/Resources/AuthorResource.php` |
| Ubah komentar | `app/Filament/Resources/CommentResource.php` |
| Ubah newsletter | `app/Filament/Resources/NewsletterSubscriberResource.php` |
| Ubah widget newsletter | `app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php` |
| Ubah tags | `app/Filament/Resources/TagResource.php` |

## 38. Pola cepat custom label

Cari kode seperti ini:

```php
->label('...')
```

Lalu ubah teksnya.

Contoh:

```php
->label('Publikasikan')
```

Menjadi:

```php
->label('Terbitkan Artikel')
```

## 39. Pola cepat custom card

Cari kode seperti ini:

```php
Section::make('...')
```

Lalu ubah teksnya.

Contoh:

```php
Forms\Components\Section::make('Status & Publikasi')
```

Menjadi:

```php
Forms\Components\Section::make('Pengaturan Terbit')
```

## 40. Pola cepat custom tombol action

Cari kode seperti ini:

```php
Action::make('nama_action')
    ->label('Teks Tombol')
    ->icon('heroicon-o-icon')
    ->color('success')
```

Ubah label, icon, dan color sesuai kebutuhan.

## 41. Rekomendasi customisasi berikutnya

Agar dashboard lebih matang, pertimbangkan:

1. Tambahkan policy/role agar editor, author, dan admin punya akses berbeda.
2. Tambahkan halaman ViewRecord khusus jika ingin `ViewAction` membuka halaman detail penuh.
3. Tambahkan `RelationManager` untuk komentar di halaman edit artikel.
4. Tambahkan SEO fields di artikel.
5. Tambahkan custom dashboard widgets untuk total artikel, draft, views, komentar pending.
6. Ubah export newsletter menjadi CSV download sungguhan.
7. Ubah test email newsletter agar benar-benar mengirim email melalui `Mail` atau queue.
