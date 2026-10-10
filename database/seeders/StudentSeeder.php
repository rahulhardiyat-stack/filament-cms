<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Student::truncate();
        Schema::enableForeignKeyConstraints();

        $students = [
            ['nim' => '2026100001', 'name' => 'Andi Pratama', 'program_studi' => 'Informatika', 'birth_date_password' => '2003-05-17'],
            ['nim' => '2026100002', 'name' => 'Siti Rahma', 'program_studi' => 'Sistem Informasi', 'birth_date_password' => '2026-10-07'],
            ['nim' => '2026100003', 'name' => 'Bima Saputra', 'program_studi' => 'Manajemen', 'birth_date_password' => '2003-08-25'],
            ['nim' => '2026100004', 'name' => 'Nadia Putri', 'program_studi' => 'Psikologi', 'birth_date_password' => '2004-11-03'],
            ['nim' => '2026100005', 'name' => 'Rizky Ramadhan', 'program_studi' => 'Hukum', 'birth_date_password' => '2003-01-12'],
        ];

        DB::transaction(function () use ($students): void {
            foreach ($students as $student) {
                // Preserve existing identities, credentials, and activation status.
                Student::firstOrCreate(
                    ['nim' => $student['nim']],
                    array_merge($student, ['is_active' => true]),
                );
            }
        });
    }
}
