# 🔘 Custom Button, Dropdown, dan Modal

Halaman ini menjelaskan cara mengubah tombol action, dropdown action, modal konfirmasi, dan notifikasi.

## 📁 File yang Diedit

Action table berada di Resource terkait:

```txt
app/Filament/Resources/ArticleResource.php
app/Filament/Resources/CommentResource.php
app/Filament/Resources/NewsletterSubscriberResource.php
```

Header action berada di Pages:

```txt
app/Filament/Resources/ArticleResource/Pages/ListArticles.php
app/Filament/Resources/ArticleResource/Pages/EditArticle.php
```

## 📂 Dropdown Action

Kode:

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

## 🏷️ Mengubah Label Button

Custom action:

```php
->label('Lihat di Website')
```

Ubah:

```php
->label('Buka Artikel')
```

Action bawaan:

```php
Tables\Actions\EditAction::make()
    ->label('Ubah')

Tables\Actions\DeleteAction::make()
    ->label('Hapus')
```

## 🖼️ Mengubah Icon Button

Kode:

```php
->icon('heroicon-m-arrow-top-right-on-square')
```

Ubah:

```php
->icon('heroicon-o-eye')
```

## 🎨 Mengubah Warna Button

Kode:

```php
->color('success')
```

Contoh:

```php
->color('primary')
->color('success')
->color('warning')
->color('danger')
->color('info')
```

## ❓ Modal Konfirmasi

Kode minimal:

```php
->requiresConfirmation()
```

Custom modal:

```php
->requiresConfirmation()
->modalHeading('Yakin menjalankan aksi ini?')
->modalDescription('Aksi ini akan mengubah data record.')
->modalSubmitActionLabel('Ya, lanjutkan')
->modalCancelActionLabel('Batal')
```

## 📣 Notifikasi Setelah Action

Kode:

```php
Notification::make()
    ->title('Komentar disetujui')
    ->success()
    ->send();
```

Dengan body:

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

## ➕ Button Create di Header

File:

```txt
app/Filament/Resources/ArticleResource/Pages/ListArticles.php
```

Kode:

```php
Actions\CreateAction::make()
```

Custom:

```php
Actions\CreateAction::make()
    ->label('Tulis Artikel Baru')
    ->icon('heroicon-o-pencil-square')
```

## 🗑️ Button Delete di Header Edit

File:

```txt
app/Filament/Resources/ArticleResource/Pages/EditArticle.php
```

Kode:

```php
Actions\DeleteAction::make()
```

Custom:

```php
Actions\DeleteAction::make()
    ->label('Hapus Artikel')
    ->modalHeading('Hapus artikel ini?')
    ->modalDescription('Data artikel akan dihapus dari CMS.')
    ->modalSubmitActionLabel('Ya, hapus')
```

## 📦 Bulk Action Button

Kode:

```php
Tables\Actions\BulkAction::make('publish')
    ->label('Publikasikan')
    ->icon('heroicon-o-check-circle')
    ->requiresConfirmation()
    ->action(fn($records) => $records->each->update(['is_published' => true, 'published_at' => now()]))
```

Custom label:

```php
->label('Terbitkan Artikel Terpilih')
```
