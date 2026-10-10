# 🎯 Cheatsheet Edit Filament

Halaman ini adalah panduan tercepat untuk mengetahui **file mana** dan **kode mana** yang harus diedit.

## 🧭 Menu Sidebar

| Mau edit | File | Kode yang dicari |
| --- | --- | --- |
| Nama menu | Resource terkait | `$navigationLabel` |
| Icon menu | Resource terkait | `$navigationIcon` |
| Group menu | Resource terkait | `$navigationGroup` |
| Urutan menu | Resource terkait | `$navigationSort` |
| Badge menu | Resource terkait | `getNavigationBadge()` |
| Warna badge | Resource terkait | `getNavigationBadgeColor()` |

Contoh file:

```txt
app/Filament/Resources/ArticleResource.php
```

## 📝 Form Create/Edit

| Mau edit | File | Kode yang dicari |
| --- | --- | --- |
| Label field | Resource terkait | `->label('...')` di `form()` |
| Judul card/section | Resource terkait | `Section::make('...')` |
| Helper text | Resource terkait | `->helperText('...')` |
| Placeholder | Resource terkait | `->placeholder('...')` |
| Layout kolom | Resource terkait | `->columns(...)` |
| Lebar field | Resource terkait | `->columnSpan(...)`, `->columnSpanFull()` |
| Required/tidak | Resource terkait | `->required()` |
| Upload folder | Resource terkait | `->directory('...')` |
| Upload maksimal | Resource terkait | `->maxSize(...)` |
| Rasio image editor | Resource terkait | `->imageEditorAspectRatios([...])` |
| Toolbar rich editor | Resource terkait | `->toolbarButtons([...])` |
| Field conditional | Resource terkait | `->visible(...)`, `->hidden(...)` |
| Field disabled | Resource terkait | `->disabled(...)` |
| Default value | Resource terkait | `->default(...)` |
| Suffix/prefix | Resource terkait | `->suffix(...)`, `->prefixIcon(...)` |
| Auto slug | Resource terkait | `->afterStateUpdated(...)` |
| Inline create select | Resource terkait | `->createOptionForm([...])` |

## 📊 Table List

| Mau edit | File | Kode yang dicari |
| --- | --- | --- |
| Label kolom | Resource terkait | `->label('...')` di `table()` |
| Search | Resource terkait | `->searchable()` |
| Sort | Resource terkait | `->sortable()` |
| Default sort | Resource terkait | `->defaultSort(...)` |
| Filter | Resource terkait | `->filters([...])` |
| Kolom hide/show | Resource terkait | `->toggleable(...)` |
| Badge kolom | Resource terkait | `->badge()` |
| Copy text | Resource terkait | `->copyable()` |
| Icon kolom | Resource terkait | `->icon('...')` |
| Warna kolom | Resource terkait | `->color(...)` |
| Format value | Resource terkait | `->formatStateUsing(...)` |
| Batasi teks | Resource terkait | `->limit(...)` |
| Date format | Resource terkait | `->dateTime(...)`, `->since()` |
| Relationship count | Resource terkait | `->counts('...')` |
| URL kolom | Resource terkait | `->url(...)`, `->openUrlInNewTab()` |

## ⚡ Action Button

| Mau edit | File | Kode yang dicari |
| --- | --- | --- |
| Dropdown action | Resource terkait | `ActionGroup::make([...])` |
| Label tombol | Resource terkait | `->label('...')` |
| Icon tombol | Resource terkait | `->icon('...')` |
| Warna tombol | Resource terkait | `->color('...')` |
| Modal konfirmasi | Resource terkait | `->requiresConfirmation()` |
| Judul modal | Resource terkait | `->modalHeading('...')` |
| Deskripsi modal | Resource terkait | `->modalDescription('...')` |
| Teks submit modal | Resource terkait | `->modalSubmitActionLabel('...')` |
| Bulk action | Resource terkait | `->bulkActions([...])` |
| Sembunyikan tombol | Resource terkait | `->hidden(...)`, `->visible(...)` |
| Form dalam modal | Resource terkait | `->form([...])` |
| Link action | Resource terkait | `->url(...)` |
| Tab baru | Resource terkait | `->openUrlInNewTab()` |
| Logic tombol | Resource terkait | `->action(function (...) { ... })` |
| Notifikasi | Resource terkait | `Notification::make()` |

## ➕ Header Button Create

File contoh:

```txt
app/Filament/Resources/ArticleResource/Pages/ListArticles.php
```

Cari:

```php
Actions\CreateAction::make()
```

Custom:

```php
Actions\CreateAction::make()
    ->label('Tulis Artikel Baru')
    ->icon('heroicon-o-pencil-square')
```

## 🗑️ Header Button Delete

File contoh:

```txt
app/Filament/Resources/ArticleResource/Pages/EditArticle.php
```

Cari:

```php
Actions\DeleteAction::make()
```

Custom:

```php
Actions\DeleteAction::make()
    ->label('Hapus Artikel')
    ->modalHeading('Hapus artikel ini?')
    ->modalSubmitActionLabel('Ya, hapus')
```

## 🧩 Widget Card

File:

```txt
app/Filament/Resources/NewsletterSubscriberResource/Widgets/NewsletterStatsWidget.php
```

| Mau edit | Kode |
| --- | --- |
| Judul card | `Stat::make('...', $value)` |
| Deskripsi | `->description('...')` |
| Icon | `->descriptionIcon('...')` |
| Warna | `->color('...')` |
