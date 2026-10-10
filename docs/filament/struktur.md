# 📦 Resource & Pages

Resource adalah file utama yang mengatur CRUD di Filament.

## 📁 Daftar Resource

| Menu | File |
| --- | --- |
| Artikel | `app/Filament/Resources/ArticleResource.php` |
| Kategori | `app/Filament/Resources/CategoryResource.php` |
| Penulis | `app/Filament/Resources/AuthorResource.php` |
| Tags | `app/Filament/Resources/TagResource.php` |
| Komentar | `app/Filament/Resources/CommentResource.php` |
| Newsletter | `app/Filament/Resources/NewsletterSubscriberResource.php` |

## 🧭 Struktur Resource

Contoh dari `ArticleResource.php`:

```php
class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?string $modelLabel = 'Artikel';
    protected static ?string $pluralModelLabel = 'Artikel';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        // form create/edit
    }

    public static function table(Table $table): Table
    {
        // table list data
    }

    public static function getPages(): array
    {
        // route halaman list/create/edit
    }
}
```

## 🏷️ Fungsi Property Resource

| Property | Fungsi |
| --- | --- |
| `$model` | Model Eloquent yang dikelola. |
| `$navigationIcon` | Icon sidebar menu. |
| `$navigationLabel` | Label menu sidebar. |
| `$modelLabel` | Nama singular record. |
| `$pluralModelLabel` | Nama plural record. |
| `$navigationGroup` | Group menu di sidebar. |
| `$navigationSort` | Urutan menu. |

## 📄 Pages List/Create/Edit

Contoh dari `ArticleResource.php`:

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

| Key | URL | Fungsi |
| --- | --- | --- |
| `index` | `/admin/articles` | List artikel |
| `create` | `/admin/articles/create` | Tambah artikel |
| `edit` | `/admin/articles/{record}/edit` | Edit artikel |

## ➕ Tombol Create di Halaman List

File:

```txt
app/Filament/Resources/ArticleResource/Pages/ListArticles.php
```

Kode:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\CreateAction::make(),
    ];
}
```

Jika ingin mengubah label tombol:

```php
Actions\CreateAction::make()
    ->label('Tulis Artikel Baru')
    ->icon('heroicon-o-pencil-square')
```

## 🗑️ Tombol Delete di Halaman Edit

File:

```txt
app/Filament/Resources/ArticleResource/Pages/EditArticle.php
```

Kode:

```php
protected function getHeaderActions(): array
{
    return [
        Actions\DeleteAction::make(),
    ];
}
```

Custom label:

```php
Actions\DeleteAction::make()
    ->label('Hapus Artikel')
    ->modalHeading('Hapus artikel ini?')
    ->modalSubmitActionLabel('Ya, hapus')
```
