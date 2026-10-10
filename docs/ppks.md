# Pelaporan PPKS

Menu **Lapor** tersedia di navigasi desktop dan seluler. Mahasiswa masuk dengan NIM dan tanggal lahir, mengirim laporan sebagai korban atau saksi, lalu melihat status dan tanggapan petugas pada `/lapor`.

## Menyiapkan akun

1. Jalankan `php artisan migrate` jika migrasi belum dijalankan.
2. Login ke `/admin`, buka **PPKS → Mahasiswa PPKS**, lalu tambah NIM, nama, program studi, dan tanggal lahir mahasiswa dari data kampus yang sudah diverifikasi.
3. Mahasiswa menggunakan NIM dan tanggal lahir tersebut untuk login. Tidak ada pendaftaran mandiri.
4. Petugas membuka **PPKS → Laporan PPKS → Tindak lanjuti** untuk melihat laporan, mengubah status, dan memberi tanggapan kepada mahasiswa.

Pada edit mahasiswa, tanggal lahir dikosongkan karena nilai asli tidak disimpan. Isi kembali hanya jika kredensial perlu diubah. Nonaktifkan akun untuk menghentikan akses, termasuk sesi mahasiswa yang masih berjalan.

Pilih tanggal lahir melalui date picker dengan tampilan `dd/mm/yyyy`. Date picker mengirim nilai tanggal beserta waktu untuk validasi; saat disimpan, Filament mengubahnya menjadi `Y-m-d` sebelum dibuat hash. Karena itu, validasi menerima tanggal dari date picker tanpa mewajibkan format mentah `Y-m-d`. Login mahasiswa tetap menggunakan tanggal yang sama melalui input tanggal.

## Penyimpanan dan akses

- Login mahasiswa menggunakan guard `student`; login admin tetap menggunakan guard `web`.
- Tanggal lahir disimpan sebagai hash, dengan pembatasan percobaan login.
- Lokasi, terlapor, kronologi, kontak, kebutuhan bantuan, dan tanggapan dienkripsi menggunakan `APP_KEY`. Simpan kunci tersebut dengan aman; menggantinya tanpa migrasi enkripsi menyebabkan data lama tidak bisa dibaca.
- Identitas mahasiswa hanya dapat diakses mahasiswa bersangkutan dan pengguna panel admin. Saat ini semua pengguna admin dapat menangani PPKS; gunakan akun panel admin hanya untuk petugas yang berwenang. Pemisahan peran petugas PPKS dari admin konten belum tersedia.
- Laporan tidak dapat dihapus lewat panel. Pelapor tidak dapat mengubah laporan setelah dikirim. Status awal selalu Diterima.
- Form menyediakan upload bukti opsional maksimal 3 gambar (JPG, PNG, WebP), masing-masing maksimal 2 MB. Batas jumlah, jenis, dan ukuran diperiksa pada browser serta server. Pilih ulang gambar jika form gagal dikirim.
- Bukti disimpan secara privat pada disk `local` di `storage/app/ppks-evidence`, di luar folder publik. Daftar lokasinya disimpan terenkripsi. Pelapor dapat melihat bukti pada Laporan saya; admin dapat melihatnya pada Tindak lanjuti. Endpoint gambar memeriksa akses pelapor/admin sebelum mengirim file. File gambar sendiri tidak dienkripsi di disk.
- Integrasi dengan sistem akademik kampus belum tersedia.

Tanggal lahir merupakan kredensial yang mudah diketahui; sebelum penggunaan nyata dengan data sensitif, penguatan login dengan OTP atau SSO kampus disarankan.

## Verifikasi

### Akun mahasiswa dummy

Jalankan `php artisan db:seed --class=StudentSeeder` untuk menambahkan 5 mahasiswa dummy aktif. Seeder juga terdaftar di `DatabaseSeeder`. Menjalankan ulang `StudentSeeder` tidak menggandakan akun atau mengubah akun yang NIM-nya sudah ada. Tanggal lahir otomatis disimpan sebagai hash oleh model `Student`.

| NIM | Nama | Program studi | Tanggal lahir untuk login |
| --- | --- | --- | --- |
| 2026100001 | Andi Pratama | Informatika | 2003-05-17 |
| 2026100002 | Siti Rahma | Sistem Informasi | 2004-02-10 |
| 2026100003 | Bima Saputra | Manajemen | 2003-08-25 |
| 2026100004 | Nadia Putri | Psikologi | 2004-11-03 |
| 2026100005 | Rizky Ramadhan | Hukum | 2003-01-12 |

Akun ini untuk pengembangan dan pengujian. Buka `/lapor/login`, isi NIM, lalu pilih tanggal lahir sesuai tabel.

Jalankan `php artisan test --filter=PpksTest`. Pengujian menggunakan SQLite dalam memori dan tidak mengubah database aplikasi.
