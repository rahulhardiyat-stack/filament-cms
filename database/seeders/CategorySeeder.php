<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Artikel tentang AI, machine learning, cloud computing, dan inovasi teknologi terbaru yang mengubah dunia.',
                'color' => 'blue',
                'icon' => '<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Bisnis',
                'slug' => 'bisnis',
                'description' => 'Strategi bisnis, manajemen, entrepreneurship, dan tips mengembangkan usaha di era digital.',
                'color' => 'red',
                'icon' => '<svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>',
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Desain',
                'slug' => 'desain',
                'description' => 'Inspirasi desain, tips UI/UX, tools terbaru, dan perkembangan dunia desain kreatif.',
                'color' => 'purple',
                'icon' => '<svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>',
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Inspirasi',
                'slug' => 'inspirasi',
                'description' => 'Kisah sukses, motivasi, dan cerita inspiratif dari berbagai pelaku industri kreatif.',
                'color' => 'indigo',
                'icon' => '<svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>',
                'order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Panduan step-by-step, tips praktis, dan tutorial lengkap untuk berbagai skill dan teknologi.',
                'color' => 'orange',
                'icon' => '<svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
                'order' => 5,
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}