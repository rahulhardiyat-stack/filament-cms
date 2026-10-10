<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $user = [
            [
                'name' => 'satgasppks',
                'email' => 'satgasppks@staindirundeng.ac.id',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'admin',
                'email' => 'rahulhardiyat@staindirundeng.ac.id',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),

                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Hijrah',
                'email' => 'hijrah@staindirundeng.ac.id',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($user as $users) {
            User::create($users);
        }
    }
}
