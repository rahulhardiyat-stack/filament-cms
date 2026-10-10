# ⚡ Actions & Bulk Actions

Action adalah tombol aksi pada setiap row table. Bulk action adalah aksi untuk banyak record sekaligus.

## 📁 File yang Diedit

Contoh:

```txt
app/Filament/Resources/ArticleResource.php
app/Filament/Resources/CommentResource.php
app/Filament/Resources/NewsletterSubscriberResource.php
```

Cari bagian:

```php
->actions([...])
->bulkActions([...])
```

## 📂 ActionGroup Dropdown

Kode artikel:

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

`ActionGroup` membuat tombol action menjadi dropdown agar table tetap rapi.

## 🏷️ Mengubah Label Action

Ubah:

```php
->label('Lihat di Website')
```

Menjadi:

```php
->label('Buka Artikel')
```

Action bawaan juga bisa diberi label:

```php
Tables\Actions\EditAction::make()
    ->label('Ubah')

Tables\Actions\DeleteAction::make()
    ->label('Hapus')
```

## 🎨 Mengubah Icon dan Warna Action

Kode:

```php
->icon('heroicon-o-check-circle')
->color('success')
```

Contoh:

```php
->icon('heroicon-o-pencil-square')
->color('warning')
```

## 👻 Menyembunyikan Action Berdasarkan Kondisi

Kode approve komentar:

```php
->hidden(fn(Comment $record) => $record->is_approved)
```

Artinya tombol `Setujui` disembunyikan jika komentar sudah disetujui.

## ✅ Action dengan Konfirmasi dan Notifikasi

Kode:

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

## 📝 Action dengan Form Modal

Kode reply komentar:

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

## 📦 Bulk Action

Kode publish banyak artikel:

```php
Tables\Actions\BulkAction::make('publish')
    ->label('Publikasikan')
    ->icon('heroicon-o-check-circle')
    ->requiresConfirmation()
    ->action(fn($records) => $records->each->update(['is_published' => true, 'published_at' => now()]))
    ->deselectRecordsAfterCompletion()
```

## 🏷️ Mengubah Label Bulk Action

Ubah:

```php
->label('Publikasikan')
```

Menjadi:

```php
->label('Terbitkan Artikel Terpilih')
```

## 🗑️ Delete Bulk Action

Kode:

```php
Tables\Actions\DeleteBulkAction::make()
```

Custom modal:

```php
Tables\Actions\DeleteBulkAction::make()
    ->modalHeading('Hapus data terpilih?')
    ->modalDescription('Data yang dipilih akan dihapus permanen.')
    ->modalSubmitActionLabel('Ya, hapus')
```
