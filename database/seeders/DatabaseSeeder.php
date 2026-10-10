<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StudentSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            ArticleSeeder::class,
            TagSeeder::class,
            UserSeeder::class,
        ]);

//        User::factory()->create([
//            'name' => 'Admin',
//            'email' => 'admin@admin.com',
//        ]);
    }
}
