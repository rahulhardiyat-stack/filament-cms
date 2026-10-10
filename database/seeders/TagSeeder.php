<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Article;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Artificial Intelligence',
            'Machine Learning',
            'Technology',
            'Future Tech',
            'Innovation',
            'Web Development',
            'React',
            'JavaScript',
            'Frontend',
            'Marketing',
            'Digital Strategy',
            'SEO',
            'Startup',
            'Entrepreneurship',
            'Business',
            'UI/UX',
            'Design',
            'User Experience',
            'Blockchain',
            'Web3',
            'Cryptocurrency'
        ];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        // Attach tags to articles
        $articles = Article::all();

        foreach ($articles as $article) {
            $randomTags = Tag::inRandomOrder()->limit(rand(3, 5))->pluck('id');
            $article->tags()->attach($randomTags);
        }
    }
}