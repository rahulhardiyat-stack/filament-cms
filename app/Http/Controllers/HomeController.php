<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest 5 published articles
        $latestArticles = Article::with(['category', 'author'])
            ->published()
            ->latest()
            ->limit(5)
            ->get();

        // Get featured articles
        $featuredArticles = Article::with(['category', 'author'])
            ->published()
            ->featured()
            ->latest()
            ->limit(3)
            ->get();

        return view('pages.home', compact('latestArticles', 'featuredArticles'));
    }
}
