<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SyncStudentsFromSiakad extends Command
{
    protected $signature = 'students:sync-siakad';
    protected $description = 'Sinkron mahasiswa baru dari SIAKAD (password awal = tgl_lahir, di-hash Bcrypt)';

    public function handle(): int
    {
        $total = 0;

        DB::connection('siakad')
            ->table('mahasiswa')                 // sesuaikan nama tabel
            ->select('mhs_no', 'mhs_nama', 'mhs_tgllahir', 'jur_id')    // HANYA kolom yang dibutuhkan
            ->whereNotNull('mhs_no')
            ->whereNotNull('mhs_tgllahir')
            ->orderBy('mhs_no')
            ->chunk(1000, function ($rows) use (&$total) {
                $nim = $rows->pluck('mhs_no')->map(fn ($u) => trim($u))->all();

                $existing = DB::table('students')
                    ->whereIn('nim', $nim)
                    ->pluck('nim')
                    ->flip();

                $data = [];
                foreach ($rows as $r) {
                    $nim = trim($r->mhs_no);
                    if ($existing->has($nim)) {
                        continue;
                    }

                    // Samakan format dengan yang akan diketik user saat login
                    $plain = Carbon::parse($r->mhs_tgllahir)->format('Y-m-d');

                    $data[] = [
                        'nim'   => $nim,
                        'name'  => trim($r->mhs_nama),
                        'program_studi' => trim($r->jur_id),
                        'birth_date_password'   => Hash::make($plain),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if ($data) {
                    DB::table('students')->insertOrIgnore($data);
                    $total += count($data);
                }

                $this->info("Mahasiswa baru ditambahkan: {$total}");
            });

        $this->info("Selesai. {$total} mahasiswa baru.");
        return self::SUCCESS;
    }
}
