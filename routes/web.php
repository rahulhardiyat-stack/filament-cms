<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PpksController;
use App\Http\Middleware\AuthenticateStudent;
use Illuminate\Support\Facades\Route;

Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    return 'Storage linked successfully!';
});

Route::prefix('lapor')->name('lapor.')->group(function () {
    Route::view('/pilih', 'pages.lapor.choose')->name('choose');
//    Route::prefix('umum')->name('public.')->controller(\App\Http\Controllers\PublicPpksController::class)->group(function () {
//        Route::get('/login', 'loginForm')->name('login');
//        Route::post('/login', 'login')->middleware('throttle:10,1')->name('authenticate');
//        Route::get('/registrasi', 'registerForm')->name('register');
//        Route::post('/registrasi', 'register')->middleware('throttle:5,1')->name('register.store');
//        Route::middleware(\App\Http\Middleware\AuthenticatePublicReporter::class)->group(function () {
//            Route::get('/', 'index')->name('index');
//            Route::post('/', 'store')->middleware('throttle:5,1')->name('store');
//            Route::post('/logout', 'logout')->name('logout');
//        });
//    });
    Route::get('/{report:reference}/bukti/{index}', [PpksController::class, 'evidence'])->whereNumber('index')->name('evidence');
    Route::get('/login', [PpksController::class, 'loginForm'])->name('login');
    Route::post('/login', [PpksController::class, 'login'])->middleware('throttle:10,1')->name('authenticate');
    Route::middleware(AuthenticateStudent::class)->group(function () {
        Route::get('/', [PpksController::class, 'index'])->name('index');
        Route::get('/form', [PpksController::class, 'form'])->name('form');
        Route::post('/', [PpksController::class, 'store'])->middleware('throttle:5,1')->name('store');
        Route::post('/logout', [PpksController::class, 'logout'])->name('logout');
    });
});

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('article.detail');

// Comments
Route::post('/articles/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
