<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $totalArticles = Article::published()->count();
        $totalReaders = Article::published()->sum('views_count');
        $totalCategories = Category::active()->count();
        $yearsWriting = 3; // Bisa di-dynamic dari setting

        return view('pages.about', compact(
            'totalArticles',
            'totalReaders',
            'totalCategories',
            'yearsWriting'
        ));
    }
}