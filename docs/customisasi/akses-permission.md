# 🔐 Custom Akses & Permission

Halaman ini menjelaskan opsi custom akses Filament v3. Project saat ini belum memiliki role/policy khusus, jadi bagian ini adalah panduan pengembangan berikutnya.

## 📁 File yang Berkaitan

| Kebutuhan | File |
| --- | --- |
| Akses panel admin | `app/Models/User.php` |
| Middleware auth panel | `app/Providers/Filament/AdminPanelProvider.php` |
| Policy Laravel | `app/Policies/*Policy.php` |
| Mapping policy | `app/Providers/AuthServiceProvider.php` |
| Resource authorization | `app/Filament/Resources/*Resource.php` |

## 🚪 Membatasi User yang Bisa Masuk Panel

Di Filament v3, umumnya user model mengimplementasikan `FilamentUser`.

File:

```txt
app/Models/User.php
```

Contoh:

```php
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@example.com');
    }
}
```

Jika punya kolom `is_admin`:

```php
public function canAccessPanel(Panel $panel): bool
{
    return $this->is_admin === true;
}
```

## 🧭 Menyembunyikan Resource dari Sidebar

Di Resource:

```php
public static function shouldRegisterNavigation(): bool
{
    return auth()->user()?->is_admin === true;
}
```

Ini membuat menu hanya muncul untuk admin.

## 🔒 Membatasi Akses View/Edit/Delete Resource

Filament akan mengikuti Laravel Policy jika dibuat.

Contoh policy artikel:

```php
public function update(User $user, Article $article): bool
{
    return $user->is_admin === true;
}
```

## 🙈 Menyembunyikan Action Berdasarkan Role

Contoh di `ArticleResource.php`:

```php
Tables\Actions\DeleteAction::make()
    ->hidden(fn() => auth()->user()?->is_admin !== true)
```

## 🔘 Menyembunyikan Button Berdasarkan Kondisi Record

Contoh tombol publish hanya tampil jika artikel belum publish:

```php
Tables\Actions\Action::make('publish')
    ->label('Publikasikan')
    ->hidden(fn(Article $record) => $record->is_published)
```

## 📝 Disable Field Berdasarkan Role

Contoh hanya admin bisa mengubah slug:

```php
Forms\Components\TextInput::make('slug')
    ->label('Slug')
    ->disabled(fn() => auth()->user()?->is_admin !== true)
```

## 📊 Menyembunyikan Kolom Berdasarkan Role

Contoh email komentar hanya untuk admin:

```php
Tables\Columns\TextColumn::make('author_email')
    ->label('Email')
    ->visible(fn() => auth()->user()?->is_admin === true)
```

## ⚠️ Catatan Project Saat Ini

Saat ini project belum memiliki:

- role admin/editor/author
- permission package
- policy Resource
- `canAccessPanel()` eksplisit di `User`

Jika dashboard akan dipakai production, bagian akses ini sebaiknya diprioritaskan.
