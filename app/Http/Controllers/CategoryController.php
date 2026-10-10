<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Get all active categories with article counts
        $categories = Category::active()
            ->ordered()
            ->withCount('publishedArticles')
            ->get();

        // Get featured articles from first category
        $featuredCategory = $categories->first();

        $featuredArticles = collect();
        if ($featuredCategory) {
            $featuredArticles = Article::with(['category', 'author'])
                ->published()
                ->where('category_id', $featuredCategory->id)
                ->latest()
                ->limit(5)
                ->get();
        }

        // Get total stats
        $totalArticles = Article::published()->count();
        $totalReaders = Article::published()->sum('views_count');
        $totalCategories = $categories->count();

        return view('pages.categories', compact(
            'categories',
            'featuredArticles',
            'totalArticles',
            'totalReaders',
            'totalCategories'
        ));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $articles = Article::with(['category', 'author'])
            ->published()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('pages.category-show', compact('category', 'articles'));
    }
}