# Filament Admin Dashboard

Halaman ini menjelaskan keseluruhan penggunaan **Filament v3** pada dashboard admin CMS blog.

## 1. Panel admin

File utama panel:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

Isi penting:

```php
return $panel
    ->default()
    ->id('admin')
    ->path('admin')
    ->login()
    ->colors([
        'primary' => Color::Amber,
    ])
    ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
    ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
    ->pages([
        Pages\Dashboard::class,
    ])
    ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
    ->widgets([
        Widgets\AccountWidget::class,
        NewsletterStatsWidget::class,
        Widgets\FilamentInfoWidget::class,
    ])
    ->middleware([
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        AuthenticateSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
        SubstituteBindings::class,
        DisableBladeIconComponents::class,
        DispatchServingFilamentEvent::class,
    ])
    ->authMiddleware([
        Authenticate::class,
    ]);
```

Penjelasan:

| Kode | Fungsi |
| --- | --- |
| `->id('admin')` | ID panel Filament. |
| `->path('admin')` | URL dashboard menjadi `/admin`. |
| `->login()` | Mengaktifkan halaman login bawaan Filament. |
| `->colors(['primary' => Color::Amber])` | Mengubah warna utama panel menjadi Amber. |
| `->discoverResources(...)` | Otomatis membaca semua Resource di `app/Filament/Resources`. |
| `->pages([Pages\Dashboard::class])` | Mengaktifkan halaman dashboard bawaan. |
| `->widgets([...])` | Menampilkan widget di dashboard. |
| `->middleware(...)` | Middleware web/session/CSRF Filament. |
| `->authMiddleware([Authenticate::class])` | Panel hanya bisa dibuka user yang login. |

## 2. Resource yang tersedia

Resource adalah pusat konfigurasi CRUD Filament. Project ini memiliki:

| Resource | Model | Menu | Group |
| --- | --- | --- | --- |
| `ArticleResource` | `Article` | Artikel | Konten |
| `CategoryResource` | `Category` | Kategori | Konten |
| `AuthorResource` | `Author` | Penulis | Konten |
| `TagResource` | `Tag` | Tags | Konten |
| `CommentResource` | `Comment` | Komentar | Interaksi |
| `NewsletterSubscriberResource` | `NewsletterSubscriber` | Newsletter | Interaksi |

Contoh konfigurasi menu pada `ArticleResource`:

```php
protected static ?string $model = Article::class;
protected static ?string $navigationIcon = 'heroicon-o-document-text';
protected static ?string $navigationLabel = 'Artikel';
protected static ?string $modelLabel = 'Artikel';
protected static ?string $pluralModelLabel = 'Artikel';
protected static ?string $navigationGroup = 'Konten';
protected static ?int $navigationSort = 3;
```

Penjelasan:

| Property | Fungsi |
| --- | --- |
| `$model` | Model Eloquent yang dikelola Resource. |
| `$navigationIcon` | Icon menu sidebar. |
| `$navigationLabel` | Nama menu sidebar. |
| `$modelLabel` | Label singular untuk record. |
| `$pluralModelLabel` | Label plural untuk list. |
| `$navigationGroup` | Group menu sidebar. |
| `$navigationSort` | Urutan menu dalam group. |

## 3. Struktur halaman Resource

Setiap Resource punya halaman bawaan:

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListArticles::route('/'),
        'create' => Pages\CreateArticle::route('/create'),
        'edit' => Pages\EditArticle::route('/{record}/edit'),
    ];
}
```

Artinya:

| Page | URL relatif | Fungsi |
| --- | --- | --- |
| `index` | `/admin/articles` | List data. |
| `create` | `/admin/articles/create` | Tambah data. |
| `edit` | `/admin/articles/{record}/edit` | Edit data. |

Pada file page list, tombol tambah dibuat dari header action:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make(),
    ];
}
```

Pada file page edit, tombol hapus dibuat dari header action:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\DeleteAction::make(),
    ];
}
```

## 4. Form create/edit

Form didefinisikan di method:

```php
public static function form(Form $form): Form
```

### Layout form artikel

`ArticleResource` memakai layout 3 kolom:

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

Efeknya:

- Area kiri mengambil 2 kolom untuk konten artikel.
- Area kanan mengambil 1 kolom untuk pengaturan, status, dan metadata.
- Layout ini membuat halaman create/edit terlihat rapi seperti dashboard CMS profesional.

### Section form

Contoh section:

```php
Forms\Components\Section::make('Konten Artikel')
    ->schema([
        Forms\Components\TextInput::make('title')
            ->label('Judul Artikel')
            ->required()
            ->maxLength(255),
    ])
```

`Section::make('Konten Artikel')` adalah judul card/section di form. Untuk mengganti nama card, ubah teks tersebut.

### TextInput dan auto slug

```php
Forms\Components\TextInput::make('title')
    ->label('Judul Artikel')
    ->required()
    ->maxLength(255)
    ->live(onBlur: true)
    ->afterStateUpdated(
        fn(string $operation, $state, Forms\Set $set) =>
        $operation === 'create' ? $set('slug', Str::slug($state)) : null
    )
```

Penjelasan:

- `label('Judul Artikel')` mengubah label field.
- `required()` membuat field wajib.
- `maxLength(255)` membatasi panjang input.
- `live(onBlur: true)` membuat field mengirim perubahan setelah user keluar dari input.
- `afterStateUpdated(...)` mengisi field `slug` otomatis saat create.

Slug field:

```php
Forms\Components\TextInput::make('slug')
    ->label('Slug')
    ->required()
    ->maxLength(255)
    ->unique(ignoreRecord: true)
    ->helperText('URL-friendly version of the title')
```

`unique(ignoreRecord: true)` membuat slug unik, tapi saat edit record yang sama tidak dianggap duplikat.

### Textarea

```php
Forms\Components\Textarea::make('excerpt')
    ->label('Excerpt/Ringkasan')
    ->required()
    ->rows(3)
    ->maxLength(500)
    ->helperText('Ringkasan singkat artikel (maks. 500 karakter)')
```

Dipakai untuk ringkasan artikel, deskripsi kategori, bio penulis, dan isi komentar.

### RichEditor

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

Fungsi:

- Field konten artikel berbasis rich text editor.
- Attachment upload disimpan ke folder `articles`.
- Toolbar diatur manual melalui `toolbarButtons()`.
- Jika ingin menambah/mengurangi tombol editor, ubah array di `toolbarButtons()`.

### FileUpload image

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
    ->helperText('Ukuran maksimal: 5MB. Rasio yang disarankan: 16:9')
```

Fungsi:

- Upload gambar utama artikel.
- Hanya menerima file image.
- File disimpan ke `storage/app/public/articles/featured` jika memakai disk public.
- Maksimal 5120 KB.
- Editor gambar aktif.
- Rasio crop yang tersedia: 16:9, 4:3, 1:1.

### Select relationship

```php
Forms\Components\Select::make('category_id')
    ->label('Kategori')
    ->relationship('category', 'name')
    ->required()
    ->searchable()
    ->preload()
    ->createOptionForm([
        Forms\Components\TextInput::make('name')->required()->maxLength(255),
        Forms\Components\TextInput::make('slug')->required()->maxLength(255),
        Forms\Components\Select::make('color')->options([...])->required(),
    ])
```

Fungsi:

- Field memilih kategori dari relasi `category` di model `Article`.
- Data yang ditampilkan adalah kolom `name`.
- `searchable()` mengaktifkan pencarian di dropdown.
- `preload()` memuat opsi lebih awal.
- `createOptionForm()` memungkinkan membuat kategori langsung dari form artikel.

Tags memakai relasi many-to-many:

```php
Forms\Components\Select::make('tags')
    ->label('Tags')
    ->relationship('tags', 'name')
    ->multiple()
    ->preload()
    ->createOptionForm([
        Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
    ])
```

`multiple()` membuat field dapat memilih banyak tag.

### Toggle

```php
Forms\Components\Toggle::make('is_published')
    ->label('Publikasikan')
    ->default(false)
    ->live()
```

Digunakan untuk status publish, featured, active, approved, dan author reply.

Contoh field tanggal publikasi hanya muncul jika toggle publish aktif:

```php
Forms\Components\DateTimePicker::make('published_at')
    ->label('Tanggal Publikasi')
    ->default(now())
    ->required()
    ->visible(fn(Forms\Get $get) => $get('is_published'))
```

`visible(...)` membuat field conditional.

### Placeholder metadata

```php
Forms\Components\Placeholder::make('views_count')
    ->label('Total Views')
    ->content(fn(?Article $record): string => $record ? number_format($record->views_count) : '0')
```

Placeholder hanya menampilkan informasi, bukan input. Di project ini digunakan untuk:

- views artikel
- created at
- updated at
- subscribed at
- total artikel tag

Biasanya metadata disembunyikan saat create:

```php
->hidden(fn(?Article $record) => $record === null)
```

## 5. Table list data

Table didefinisikan di method:

```php
public static function table(Table $table): Table
```

Table berisi:

- Columns
- Default sort
- Filters
- Row actions
- Bulk actions

### TextColumn searchable dan sortable

```php
Tables\Columns\TextColumn::make('title')
    ->label('Judul')
    ->searchable()
    ->sortable()
    ->limit(50)
    ->weight('bold')
    ->wrap()
```

Fungsi:

| Method | Fungsi |
| --- | --- |
| `label()` | Label kolom. |
| `searchable()` | Kolom masuk pencarian global table. |
| `sortable()` | Kolom bisa diurutkan. |
| `limit(50)` | Teks dipotong maksimal 50 karakter. |
| `weight('bold')` | Teks dibuat tebal. |
| `wrap()` | Teks boleh turun baris. |

### Relationship column

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

`category.name` membaca nama kategori dari relasi artikel.

### ImageColumn

```php
Tables\Columns\ImageColumn::make('featured_image')
    ->label('Gambar')
    ->square()
```

Dipakai untuk menampilkan gambar utama artikel.

Avatar penulis memakai bentuk lingkaran:

```php
Tables\Columns\ImageColumn::make('avatar')
    ->label('Avatar')
    ->circular()
    ->defaultImageUrl(url('/images/default-avatar.png'))
```

### IconColumn boolean

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

- Boolean `true` tampil sebagai icon check warna success.
- Boolean `false` tampil sebagai icon x warna danger.
- Bisa disortir.

### ToggleColumn

```php
Tables\Columns\ToggleColumn::make('is_active')
    ->label('Aktif')
    ->sortable()
```

`ToggleColumn` bisa mengubah nilai boolean langsung dari table tanpa masuk halaman edit.

Dipakai di:

- kategori aktif/tidak aktif
- penulis aktif/tidak aktif

### Copyable column

```php
Tables\Columns\TextColumn::make('slug')
    ->label('Slug')
    ->searchable()
    ->copyable()
    ->icon('heroicon-m-link')
    ->color('gray')
```

`copyable()` membuat isi kolom bisa dicopy dari UI.

Dipakai untuk slug kategori/tag dan email subscriber/commenter.

### Toggleable column

```php
Tables\Columns\TextColumn::make('created_at')
    ->label('Dibuat')
    ->dateTime('d M Y H:i')
    ->sortable()
    ->toggleable(isToggledHiddenByDefault: true)
```

`toggleable()` membuat kolom bisa ditampilkan/disembunyikan dari pengaturan table. Jika `isToggledHiddenByDefault: true`, kolom default-nya tersembunyi.

### Counts relationship

```php
Tables\Columns\TextColumn::make('articles_count')
    ->label('Artikel')
    ->counts('articles')
    ->sortable()
    ->badge()
    ->color('success')
```

`counts('articles')` membuat Filament menghitung jumlah relasi `articles` secara efisien.

Dipakai di:

- AuthorResource untuk jumlah artikel penulis.
- TagResource untuk jumlah artikel per tag.
- CommentResource untuk jumlah balasan.

### Format state

```php
Tables\Columns\TextColumn::make('views_count')
    ->label('Views')
    ->sortable()
    ->formatStateUsing(fn($state) => number_format($state))
    ->icon('heroicon-m-eye')
    ->color('gray')
```

`formatStateUsing()` mengubah tampilan value sebelum dirender.

## 6. Filter table

### SelectFilter relationship

```php
Tables\Filters\SelectFilter::make('category')
    ->label('Kategori')
    ->relationship('category', 'name')
    ->preload()
```

Membuat filter dropdown berdasarkan relasi kategori.

### TernaryFilter boolean

```php
Tables\Filters\TernaryFilter::make('is_published')
    ->label('Status Publikasi')
    ->placeholder('Semua')
    ->trueLabel('Published')
    ->falseLabel('Draft')
```

Filter 3 kondisi:

- Semua
- True
- False

Dipakai untuk:

- status publikasi artikel
- artikel pilihan
- kategori aktif
- penulis aktif
- komentar approved
- subscriber aktif

### Filter custom tanggal

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

Filter ini menambahkan form custom berisi dua date picker, lalu query disesuaikan berdasarkan input tanggal.

### Filter toggle custom

```php
Tables\Filters\Filter::make('has_replies')
    ->label('Memiliki Balasan')
    ->query(fn($query) => $query->has('replies'))
    ->toggle()
```

`toggle()` membuat filter tampil sebagai switch sederhana.

## 7. Action button dan dropdown

### ActionGroup

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

`ActionGroup` membuat tombol action dalam bentuk dropdown. Ini cocok agar table tetap rapi ketika banyak action.

Isi dropdown artikel:

- View
- Edit
- Lihat di Website
- Delete

### Custom action dengan URL

```php
Tables\Actions\Action::make('visit')
    ->label('Lihat di Website')
    ->url(fn(Article $record): string => route('article.detail', $record->slug))
    ->icon('heroicon-m-arrow-top-right-on-square')
    ->openUrlInNewTab()
```

Action ini membuka artikel di frontend website.

### Custom action dengan confirmation dan notification

```php
Tables\Actions\Action::make('approve')
    ->label('Setujui')
    ->icon('heroicon-o-check-circle')
    ->color('success')
    ->hidden(fn(Comment $record) => $record->is_approved)
    ->requiresConfirmation()
    ->action(function (Comment $record) {
        $record->update(['is_approved' => true]);

        Notification::make()
            ->title('Komentar disetujui')
            ->success()
            ->send();
    })
```

Fungsi:

- `label()` mengatur teks tombol.
- `icon()` mengatur icon.
- `color()` mengatur warna.
- `hidden()` menyembunyikan action pada kondisi tertentu.
- `requiresConfirmation()` menampilkan modal konfirmasi.
- `action()` menjalankan logic.
- `Notification::make()` menampilkan notifikasi setelah action selesai.

### Action dengan form modal

```php
Tables\Actions\Action::make('reply')
    ->label('Balas')
    ->icon('heroicon-o-chat-bubble-left')
    ->color('info')
    ->form([
        Forms\Components\Textarea::make('content')
            ->label('Balasan Anda')
            ->required()
            ->rows(4),
        Forms\Components\Toggle::make('is_author_reply')
            ->label('Tandai sebagai balasan penulis')
            ->default(true),
    ])
    ->action(function (Comment $record, array $data) {
        Comment::create([
            'article_id' => $record->article_id,
            'parent_id' => $record->id,
            'author_name' => auth()->user()->name ?? 'Admin',
            'author_email' => auth()->user()->email ?? 'admin@blog.com',
            'content' => $data['content'],
            'is_approved' => true,
            'is_author_reply' => $data['is_author_reply'],
        ]);
    })
```

Action ini membuka modal form untuk membalas komentar langsung dari table.

## 8. Bulk action

Bulk action digunakan untuk memproses banyak record sekaligus.

Contoh publish banyak artikel:

```php
Tables\Actions\BulkAction::make('publish')
    ->label('Publikasikan')
    ->icon('heroicon-o-check-circle')
    ->requiresConfirmation()
    ->action(fn($records) => $records->each->update(['is_published' => true, 'published_at' => now()]))
    ->deselectRecordsAfterCompletion()
```

Contoh unpublish:

```php
Tables\Actions\BulkAction::make('unpublish')
    ->label('Unpublish')
    ->icon('heroicon-o-x-circle')
    ->requiresConfirmation()
    ->action(fn($records) => $records->each->update(['is_published' => false]))
    ->deselectRecordsAfterCompletion()
    ->color('danger')
```

Semua bulk action biasanya dibungkus di:

```php
Tables\Actions\BulkActionGroup::make([
    // bulk actions
])
```

## 9. Navigation badge

Badge sidebar dibuat dengan method Resource:

```php
public static function getNavigationBadge(): ?string
{
    return static::getModel()::where('is_published', true)->count() . '/' . static::getModel()::count();
}

public static function getNavigationBadgeColor(): ?string
{
    return 'success';
}
```

Pada artikel, badge menampilkan jumlah artikel published dibanding total artikel.

Komentar menampilkan badge hanya jika ada komentar pending:

```php
public static function getNavigationBadge(): ?string
{
    $pending = static::getModel()::where('is_approved', false)->count();
    return $pending > 0 ? (string) $pending : null;
}
```

## 10. Widget dashboard

Widget newsletter berada di:

```txt
app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php
```

Kode:

```php
class NewsletterStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = NewsletterSubscriber::count();
        $active = NewsletterSubscriber::where('is_active', true)->count();
        $inactive = NewsletterSubscriber::where('is_active', false)->count();
        $thisMonth = NewsletterSubscriber::whereMonth('subscribed_at', now()->month)->count();

        return [
            Stat::make('Total Subscribers', $total)
                ->description('Total semua subscriber')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Active Subscribers', $active)
                ->description('Subscriber aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Inactive Subscribers', $inactive)
                ->description('Subscriber tidak aktif')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('New This Month', $thisMonth)
                ->description('Subscriber baru bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}
```

Widget ini menampilkan kartu statistik di dashboard admin.

## 11. Catatan penting project ini

Beberapa bagian sudah berfungsi, tetapi masih perlu perhatian:

1. `ViewAction::make()` dipakai di beberapa Resource, tetapi `getPages()` belum mendaftarkan halaman `view`. Jika ingin halaman detail khusus, tambahkan page view record.
2. `CategoryResource` memakai `article_count` accessor. Ini bisa membuat query tambahan. Untuk optimasi, gunakan `counts('publishedArticles')` atau `withCount`.
3. `NewsletterSubscriberResource` action `send_test` masih placeholder. Kode hanya menampilkan notifikasi, belum mengirim email.
4. `NewsletterStatsWidget` menghitung `New This Month` hanya berdasarkan bulan, belum tahun. Sebaiknya tambah `whereYear()`.
5. Belum ada policy/role untuk membatasi siapa yang boleh mengakses Resource tertentu.
