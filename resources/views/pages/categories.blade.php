@extends('layouts.app')

@section('title', 'Kategori - Blog Modern')

@section('styles')
    <style>
        .category-card {
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .category-icon {
            transition: transform 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">Jelajahi Kategori</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Temukan artikel yang sesuai dengan minat Anda. Dari teknologi terkini hingga tips produktivitas, semua
                tersedia di sini.
            </p>
        </div>
    </section>

    <!-- Main Categories Grid -->
    <section class="pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            @if ($categories->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($categories as $category)
                        <a href="{{ route('articles', ['category' => $category->slug]) }}"
                            class="category-card block bg-white border-2 border-gray-200 rounded-3xl p-8 hover-lift">
                            <div
                                class="category-icon w-16 h-16 {{ $category->bg_color_class }} rounded-2xl flex items-center justify-center mb-6">
                                {!! $category->icon !!}
                            </div>
                            <h3 class="text-2xl font-bold mb-3">{{ $category->name }}</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">{{ $category->description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold {{ $category->color_class }}">
                                    {{ $category->article_count }} Artikel
                                </span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada kategori yang tersedia.</p>
            @endif
        </div>
    </section>

    <!-- Featured Category Section -->
    @if ($featuredArticles->count() > 0)
        <section class="py-20 px-6 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <h2 class="text-4xl font-bold mb-3">Trending di {{ $categories->first()->name ?? 'Teknologi' }}</h2>
                        <p class="text-gray-600">Artikel paling populer minggu ini</p>
                    </div>
                    <a href="{{ route('articles') }}"
                        class="hidden md:block text-sm font-medium hover:text-blue-600 transition">Lihat Semua →</a>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featuredArticles as $article)
                        <x-article-card :article="$article" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Stats Section -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div class="p-8">
                    <div class="text-5xl font-bold mb-3">{{ $totalArticles }}</div>
                    <p class="text-gray-600 font-medium">Total Artikel</p>
                </div>
                <div class="p-8">
                    <div class="text-5xl font-bold mb-3">{{ $totalCategories }}</div>
                    <p class="text-gray-600 font-medium">Kategori Utama</p>
                </div>
                <div class="p-8">
                    <div class="text-5xl font-bold mb-3">{{ number_format($totalReaders) }}+</div>
                    <p class="text-gray-600 font-medium">Total Pembaca</p>
                </div>
                <div class="p-8">
                    <div class="text-5xl font-bold mb-3">{{ \App\Models\Author::active()->count() }}</div>
                    <p class="text-gray-600 font-medium">Kontributor</p>
                </div>
            </div>
        </div>
    </section>
@endsection
