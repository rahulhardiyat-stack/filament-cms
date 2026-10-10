@extends('layouts.app')

@section('title', 'SatgasPPKS')

@section('content')
    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="asymmetric-grid items-center">
                <div class="span-5">
                    <div
                        class="inline-block px-4 py-1 bg-blue-50 text-blue-600 text-xs font-semibold tracking-wide uppercase mb-6">
                        Satgas PPKS
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">
                        Mewujudkan Kampus Aman, Nyaman, dan Bebas dari Kekerasan Seksual
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Satgas Satuan Tugas Pencegahan dan Penanganan Kekerasan Seksual (PPKS) hadir sebagai ruang aman bagi seluruh civitas akademika. Kami berkomitmen untuk
                        mencegah, menangani, dan mendampingi setiap bentuk kekerasan seksual secara rahasia dan profesional.
                    </p>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('lapor.index') }}"
                            class="bg-black text-white px-8 py-3 font-medium hover:bg-gray-800 transition">
                            Lapor Kejadian
                        </a>
                        <a href="{{ route('categories') }}"
                            class="border border-gray-300 px-8 py-3 font-medium hover:border-gray-900 transition">
                            Lihat Berita
                        </a>
                    </div>
                </div>
                <div class="span-7">
                    @if ($featuredArticles->first())
                        <a href="{{ route('article.detail', $featuredArticles->first()->slug) }}"
                            class="block bg-gray-100 rounded-2xl overflow-hidden hover-lift">
                            @if ($featuredArticles->first()->featured_image_url)
                                <img src="{{ $featuredArticles->first()->featured_image_url }}"
                                    alt="{{ $featuredArticles->first()->title }}" class="w-full aspect-[4/3] object-cover">
                            @else
                                <div class="aspect-[4/3] bg-gray-200 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </a>
                    @else
                        <div class="bg-gray-100 rounded-2xl overflow-hidden">
                            <div class="aspect-[4/3] bg-gray-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Articles -->
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-4xl font-bold mb-3">Artikel Pilihan</h2>
                    <p class="text-gray-600">Konten terbaik yang dipilih khusus untuk Anda</p>
                </div>
                <a href="{{ route('articles') }}"
                    class="hidden md:block text-sm font-medium hover:text-blue-600 transition">
                    Lihat Semua →
                </a>
            </div>

            @if ($featuredArticles->count() > 0)
                <div class="asymmetric-grid">
                    <!-- Large Card -->
                    @if ($featuredArticles->first())
                        <article class="span-7 bg-white rounded-2xl overflow-hidden hover-lift">
                            <a href="{{ route('article.detail', $featuredArticles->first()->slug) }}">
                                @if ($featuredArticles->first()->featured_image_url)
                                    <img src="{{ $featuredArticles->first()->featured_image_url }}"
                                        alt="{{ $featuredArticles->first()->title }}"
                                        class="w-full aspect-[16/10] object-cover">
                                @else
                                    <div class="aspect-[16/10] bg-gray-200 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-8">
                                <div class="flex items-center space-x-4 mb-4">
                                    <span
                                        class="text-xs font-semibold {{ $featuredArticles->first()->category->color_class }} uppercase tracking-wide">
                                        {{ $featuredArticles->first()->category->name }}
                                    </span>
                                    <span
                                        class="text-sm text-gray-500">{{ $featuredArticles->first()->read_time_text }}</span>
                                </div>
                                <a href="{{ route('article.detail', $featuredArticles->first()->slug) }}">
                                    <h3 class="text-2xl font-bold mb-3 hover:text-blue-600 transition">
                                        {{ $featuredArticles->first()->title }}
                                    </h3>
                                </a>
                                <p class="text-gray-600 mb-6 line-clamp-3">{{ $featuredArticles->first()->excerpt }}</p>
                                <div class="flex items-center">
                                    @if ($featuredArticles->first()->author->avatar_url)
                                        <img src="{{ $featuredArticles->first()->author->avatar_url }}"
                                            alt="{{ $featuredArticles->first()->author->name }}"
                                            class="w-10 h-10 rounded-full mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-gray-300 rounded-full mr-3"></div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-sm">{{ $featuredArticles->first()->author->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $featuredArticles->first()->formatted_date }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endif

                    <!-- Medium Cards -->
                    <div class="span-5 space-y-6">
                        @foreach ($featuredArticles->slice(1, 2) as $article)
                            <article class="bg-white rounded-2xl overflow-hidden hover-lift">
                                <a href="{{ route('article.detail', $article->slug) }}">
                                    @if ($article->featured_image_url)
                                        <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                                            class="w-full aspect-[16/9] object-cover">
                                    @else
                                        <div class="aspect-[16/9] bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-6">
                                    <span
                                        class="text-xs font-semibold {{ $article->category->color_class }} uppercase tracking-wide">
                                        {{ $article->category->name }}
                                    </span>
                                    <a href="{{ route('article.detail', $article->slug) }}">
                                        <h3 class="text-lg font-bold mt-3 mb-2 hover:text-blue-600 transition line-clamp-2">
                                            {{ $article->title }}
                                        </h3>
                                    </a>
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $article->excerpt }}</p>
                                    <p class="text-xs text-gray-500">{{ $article->formatted_date }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada artikel yang dipublikasikan.</p>
            @endif
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Yang Kami Pegang Teguh</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Prinsip yang memandu setiap tulisan dan karya saya</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Kerahasian & Keamanan</h3>
                    <p class="text-gray-600">Identitas pelapor dan korban dijamin kerahasiaannya secara penuh.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Keberpiahakan Pada Korban</h3>
                    <p class="text-gray-600">Mengutamakan perlindungan, rasa aman, dan pemulihan fisik serta psikologis korban</p>
                </div>

                <div class="bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Keadilan & Transparansi.</h3>
                    <p class="text-gray-600">: Penanganan laporan dilakukan secara obyektif, independen,
                        dan sesuai prosedur hukum yang berlaku.</p>
                </div>

                <div class="bg-white p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Edukasi & Pencegahan</h3>
                    <p class="text-gray-600">Aktif melakukan sosialisasi dan edukasi untuk mencegah terjadinya tindakan kekerasan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Posts -->
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold mb-12">Artikel Terbaru</h2>

            @if ($latestArticles->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($latestArticles as $article)
                        <x-article-card :article="$article" />
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">Belum ada artikel yang dipublikasikan.</p>
            @endif
        </div>
    </section>
@endsection
