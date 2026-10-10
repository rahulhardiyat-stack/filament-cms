<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'name' => 'Ahmad Rizki',
                'slug' => 'ahmad-rizki',
                'email' => 'ahmad@example.com',
                'bio' => 'Senior Tech Writer dengan pengalaman lebih dari 8 tahun dalam menulis tentang teknologi, AI, dan inovasi digital. Passionate tentang bagaimana teknologi dapat meningkatkan kualitas hidup manusia.',
                'title' => 'Senior Tech Writer',
                'is_active' => true
            ],
            [
                'name' => 'Dewi Kartika',
                'slug' => 'dewi-kartika',
                'email' => 'dewi@example.com',
                'bio' => 'Full-stack developer dan technical writer yang fokus pada web development dan framework modern.',
                'title' => 'Full-stack Developer',
                'is_active' => true
            ],
            [
                'name' => 'Budi Santoso',
                'slug' => 'budi-santoso',
                'email' => 'budi@example.com',
                'bio' => 'Backend engineer dengan spesialisasi di cloud computing dan arsitektur sistem.',
                'title' => 'Backend Engineer',
                'is_active' => true
            ],
            [
                'name' => 'Sari Indah',
                'slug' => 'sari-indah',
                'email' => 'sari@example.com',
                'bio' => 'UI/UX designer dengan passion untuk menciptakan pengalaman pengguna yang luar biasa.',
                'title' => 'UI/UX Designer',
                'is_active' => true
            ],
            [
                'name' => 'Eko Prasetyo',
                'slug' => 'eko-prasetyo',
                'email' => 'eko@example.com',
                'bio' => 'Digital marketing strategist dan business consultant.',
                'title' => 'Marketing Strategist',
                'is_active' => true
            ],
            [
                'name' => 'Fitri Amaliah',
                'slug' => 'fitri-amaliah',
                'email' => 'fitri@example.com',
                'bio' => 'Entrepreneur dan startup mentor yang senang berbagi pengalaman membangun bisnis.',
                'title' => 'Entrepreneur',
                'is_active' => true
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}