<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with(['category', 'author'])
            ->published()
            ->latest();

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(3);

        return view('pages.articles', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::with(['category', 'author', 'tags', 'approvedComments.replies'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $article->incrementViews();

        // Get related articles
        $relatedArticles = $article->relatedArticles(4);

        // Get popular articles for sidebar
        $popularArticles = Article::published()
            ->popular()
            ->limit(5)
            ->get();

        // Get all categories for sidebar
        $sidebarCategories = Category::active()
            ->withCount('publishedArticles')
            ->get();

        return view('pages.article-detail', compact(
            'article',
            'relatedArticles',
            'popularArticles',
            'sidebarCategories'
        ));
    }
}