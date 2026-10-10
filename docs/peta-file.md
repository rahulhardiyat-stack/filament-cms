# 🗺️ Peta File Filament CMS

Halaman ini adalah peta cepat untuk mencari file yang harus diedit ketika ingin mengubah dashboard admin.

## 🚪 Panel Admin

| Kebutuhan | File |
| --- | --- |
| Ubah URL `/admin` | `app/Providers/Filament/AdminPanelProvider.php` |
| Ubah warna utama panel | `app/Providers/Filament/AdminPanelProvider.php` |
| Tambah/hapus widget dashboard | `app/Providers/Filament/AdminPanelProvider.php` |
| Middleware/auth panel | `app/Providers/Filament/AdminPanelProvider.php` |

## 📦 Resource CRUD

| Menu Admin | File Utama |
| --- | --- |
| Artikel | `app/Filament/Resources/ArticleResource.php` |
| Kategori | `app/Filament/Resources/CategoryResource.php` |
| Penulis | `app/Filament/Resources/AuthorResource.php` |
| Tags | `app/Filament/Resources/TagResource.php` |
| Komentar | `app/Filament/Resources/CommentResource.php` |
| Newsletter | `app/Filament/Resources/NewsletterSubscriberResource.php` |

## 📄 Halaman List/Create/Edit

Contoh untuk artikel:

| Halaman | File |
| --- | --- |
| List artikel | `app/Filament/Resources/ArticleResource/Pages/ListArticles.php` |
| Create artikel | `app/Filament/Resources/ArticleResource/Pages/CreateArticle.php` |
| Edit artikel | `app/Filament/Resources/ArticleResource/Pages/EditArticle.php` |

Pola ini sama untuk Resource lain:

```txt
app/Filament/Resources/{NamaResource}/Pages/List...
app/Filament/Resources/{NamaResource}/Pages/Create...
app/Filament/Resources/{NamaResource}/Pages/Edit...
```

## 🧩 Widget Dashboard

| Widget | File |
| --- | --- |
| Statistik newsletter | `app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php` |

Widget didaftarkan di:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

## 🎯 Mau Edit Apa?

| Mau edit | Cari kode |
| --- | --- |
| Nama menu sidebar | `$navigationLabel` |
| Icon menu sidebar | `$navigationIcon` |
| Group menu sidebar | `$navigationGroup` |
| Urutan menu | `$navigationSort` |
| Label model | `$modelLabel`, `$pluralModelLabel` |
| Label field form | `->label('...')` di method `form()` |
| Judul card form | `Section::make('...')` |
| Layout form | `->columns(...)`, `Group::make()`, `->columnSpan(...)` |
| Label kolom table | `->label('...')` di method `table()` |
| Search table | `->searchable()` |
| Sorting table | `->sortable()` |
| Filter table | `->filters([...])` |
| Tombol action row | `->actions([...])` |
| Tombol dropdown | `ActionGroup::make([...])` |
| Tombol massal | `->bulkActions([...])` |
| Modal konfirmasi | `->requiresConfirmation()`, `->modalHeading(...)` |
| Notifikasi | `Notification::make()` |
| Badge sidebar | `getNavigationBadge()` |
