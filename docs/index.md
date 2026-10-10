# 👋 Dokumentasi Filament CMS Blog

Dokumentasi ini menjelaskan dashboard admin CMS blog yang dibangun dengan **Laravel 10** dan **Filament v3**.

## 🎯 Tujuan Dokumentasi

Dokumentasi ini dibuat supaya developer mudah mencari:

- 🧭 struktur dashboard Filament
- 📁 file mana yang harus diedit
- 🏷️ cara mengubah label menu, label field, dan label tombol
- 🎨 cara mengubah icon, warna, dan urutan menu sidebar
- 📝 cara mengubah form create/edit
- 📊 cara mengubah table list data, searching, sorting, filter, dan action dropdown
- 🔘 cara mengubah button, modal konfirmasi, dan bulk action

## 🚪 Lokasi Admin Panel

Dashboard admin berada di:

```txt
/admin
```

Konfigurasi panel ada di:

```txt
app/Providers/Filament/AdminPanelProvider.php
```

## 🗺️ Mulai dari Mana?

Jika ingin memahami struktur besar, baca:

- [🗺️ Peta File](./peta-file.md)
- [🚪 Panel Admin](./filament/panel-admin.md)
- [📦 Resource & Pages](./filament/struktur.md)

Jika ingin langsung custom tampilan/teks, baca:

- [🎯 Cheatsheet Edit](./customisasi/cheatsheet.md)
- [🏷️ Label & Teks](./customisasi/label-teks.md)
- [🎨 Icon Warna Menu](./customisasi/icon-warna-menu.md)
- [🔘 Button & Modal](./customisasi/button-modal.md)

## ⚙️ Menjalankan Docs

```bash
npm run docs:dev
```

Build docs:

```bash
npm run docs:build
```
