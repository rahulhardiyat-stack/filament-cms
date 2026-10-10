@extends('layouts.app')

@section('title', 'Semua Artikel - Blog Modern')

@section('styles')
    <style>
        .category-badge {
            transition: all 0.2s ease;
        }

        .category-badge:hover {
            transform: scale(1.05);
        }

        .filter-active {
            background-color: black;
            color: white;
            border-color: black;
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-16 px-6 border-b border-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">Semua Artikel</h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Jelajahi koleksi lengkap artikel kami tentang teknologi, desain, bisnis, dan topik menarik lainnya.
                </p>
            </div>
        </div>
    </section>

    <!-- Filter & Search Section -->
    <section class="py-8 px-6 bg-gray-50 sticky top-16 z-40 border-b border-gray-200">
        <div class="max-w-7xl mx-auto">
            <form method="GET" action="{{ route('articles') }}"
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                        class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition" />
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <!-- Category Filter -->
                <div class="flex items-center gap-3 pb-2 md:pb-0">
                    <a href="{{ route('articles') }}"
                        class="category-badge px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg whitespace-nowrap {{ !request('category') && !request('search') ? 'filter-active' : 'hover:border-black' }} transition">
                        Semua
                    </a>
                    @foreach (\App\Models\Category::active()->ordered()->get() as $cat)
                        <a href="{{ route('articles', ['category' => $cat->slug]) }}"
                            class="category-badge px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg whitespace-nowrap {{ request('category') == $cat->slug ? 'filter-active' : 'hover:border-black' }} transition">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>
    </section>

    <!-- Articles Grid -->
    <section class="py-16 px-6">
        <div class="max-w-7xl mx-auto">
            @if ($articles->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($articles as $article)
                        <x-article-card :article="$article" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-16">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Tidak ada artikel ditemukan</h3>
                    <p class="text-gray-600 mb-6">Coba ubah filter atau kata kunci pencarian Anda.</p>
                    <a href="{{ route('articles') }}"
                        class="inline-block bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition">
                        Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
