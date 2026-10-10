@extends('layouts.app')

@section('title', $article->title . ' - Blog Modern')

@section('styles')
    <style>
        .share-button {
            transition: all 0.2s ease;
        }

        .share-button:hover {
            transform: translateY(-2px);
        }

        .prose {
            max-width: none;
        }

        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #374151;
        }

        .prose h2 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: #111827;
        }

        .prose h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            color: #111827;
        }

        .prose ul,
        .prose ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .prose li {
            margin-bottom: 0.75rem;
            line-height: 1.8;
            color: #374151;
        }

        .prose blockquote {
            border-left: 4px solid #000;
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #6b7280;
        }

        .prose code {
            background-color: #f3f4f6;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <!-- Article Header -->
    <article class="pt-32 pb-12 px-6">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <div class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
                <a href="{{ route('home') }}" class="hover:text-black transition">Beranda</a>
                <span>/</span>
                <a href="{{ route('articles') }}" class="hover:text-black transition">Artikel</a>
                <span>/</span>
                <a href="{{ route('articles', ['category' => $article->category->slug]) }}"
                    class="hover:text-black transition">
                    {{ $article->category->name }}
                </a>
                <span>/</span>
                <span class="text-black">Artikel Ini</span>
            </div>

            <!-- Category Badge -->
            <div class="mb-6">
                <span
                    class="inline-block px-4 py-1 {{ $article->category->bg_color_class }} {{ $article->category->color_class }} text-xs font-semibold tracking-wide uppercase">
                    {{ $article->category->name }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-6">{{ $article->title }}</h1>

            <!-- Meta Info -->
            <div class="flex flex-wrap items-center gap-6 pb-8 border-b border-gray-200">
                <div class="flex items-center">
                    @if ($article->author->avatar_url)
                        <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}"
                            class="w-12 h-12 rounded-full mr-3">
                    @else
                        <div class="w-12 h-12 bg-gray-300 rounded-full mr-3"></div>
                    @endif
                    <div>
                        <p class="font-semibold">{{ $article->author->name }}</p>
                        <p class="text-sm text-gray-600">{{ $article->author->title ?? 'Writer' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-6 text-sm text-gray-600">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $article->formatted_date }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $article->read_time_text }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        {{ number_format($article->views_count) }} Views
                    </div>
                </div>
            </div>
        </div>
    </article>

    <!-- Featured Image -->
    @if ($article->featured_image_url)
        <section class="px-6 mb-12">
            <div class="max-w-5xl mx-auto">
                <div class="aspect-[21/9] rounded-2xl overflow-hidden">
                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                        class="w-full h-full object-cover">
                </div>
            </div>
        </section>
    @else
        <section class="px-6 mb-12">
            <div class="max-w-5xl mx-auto">
                <div class="aspect-[21/9] bg-gray-100 rounded-2xl overflow-hidden flex items-center justify-center">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </section>
    @endif

    <!-- Article Content & Sidebar -->
    <section class="px-6 pb-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-12 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <div class="prose text-lg">
                        {!! $article->content !!}
                    </div>

                    <!-- Tags -->
                    @if ($article->tags->count() > 0)
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h4 class="text-sm font-semibold mb-4">Tags:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($article->tags as $tag)
                                    <span
                                        class="px-4 py-2 bg-gray-100 text-sm font-medium rounded-lg">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-sm font-semibold mb-4">Bagikan Artikel:</h4>
                        <div class="flex space-x-3">
                            <button onclick="shareOnFacebook()"
                                class="share-button w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </button>
                            <button onclick="shareOnTwitter()"
                                class="share-button w-12 h-12 bg-sky-500 text-white rounded-lg flex items-center justify-center hover:bg-sky-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </button>
                            <button onclick="shareOnLinkedIn()"
                                class="share-button w-12 h-12 bg-blue-700 text-white rounded-lg flex items-center justify-center hover:bg-blue-800">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </button>
                            <button onclick="shareOnWhatsApp()"
                                class="share-button w-12 h-12 bg-green-600 text-white rounded-lg flex items-center justify-center hover:bg-green-700">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Author Bio -->
                    <div class="mt-12 p-8 bg-gray-50 rounded-2xl">
                        <div class="flex items-start space-x-4">
                            @if ($article->author->avatar_url)
                                <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}"
                                    class="w-20 h-20 rounded-full flex-shrink-0">
                            @else
                                <div class="w-20 h-20 bg-gray-300 rounded-full flex-shrink-0"></div>
                            @endif
                            <div>
                                <h4 class="text-xl font-bold mb-2">{{ $article->author->name }}</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    {{ $article->author->bio ?? 'Professional writer and content creator.' }}
                                </p>
                                <div class="flex space-x-3">
                                    @if ($article->author->twitter_url)
                                        <a href="{{ $article->author->twitter_url }}" target="_blank"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-700">Twitter</a>
                                    @endif
                                    @if ($article->author->linkedin_url)
                                        <a href="{{ $article->author->linkedin_url }}" target="_blank"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-700">LinkedIn</a>
                                    @endif
                                    @if ($article->author->website_url)
                                        <a href="{{ $article->author->website_url }}" target="_blank"
                                            class="text-sm font-medium text-blue-600 hover:text-blue-700">Website</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-4">
                    <div class="sticky top-24 space-y-8">
                        <!-- Newsletter Signup -->
                        <div class="bg-black text-white rounded-2xl p-6">
                            <h3 class="text-xl font-bold mb-3">Newsletter</h3>
                            <p class="text-sm text-gray-400 mb-6">Dapatkan artikel terbaru langsung ke inbox Anda.</p>
                            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                                @csrf
                                <input type="email" name="email" placeholder="Email Anda" required
                                    class="w-full px-4 py-3 mb-3 bg-white text-black rounded-lg focus:outline-none text-sm" />
                                <button type="submit"
                                    class="w-full bg-white text-black px-4 py-3 font-medium rounded-lg hover:bg-gray-100 transition text-sm">Subscribe</button>
                            </form>
                        </div>

                        <!-- Popular Posts -->
                        @if ($popularArticles->count() > 0)
                            <div class="border border-gray-200 rounded-2xl p-6">
                                <h3 class="text-lg font-bold mb-6">Artikel Popular</h3>
                                <div class="space-y-6">
                                    @foreach ($popularArticles as $popular)
                                        <a href="{{ route('article.detail', $popular->slug) }}" class="block group">
                                            @if ($popular->featured_image_url)
                                                <div class="aspect-[16/9] rounded-lg mb-3 overflow-hidden">
                                                    <img src="{{ $popular->featured_image_url }}"
                                                        alt="{{ $popular->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                                </div>
                                            @else
                                                <div
                                                    class="aspect-[16/9] bg-gray-100 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <h4
                                                class="font-semibold text-sm mb-2 group-hover:text-blue-600 transition line-clamp-2">
                                                {{ $popular->title }}
                                            </h4>
                                            <p class="text-xs text-gray-600">{{ $popular->short_date }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Categories -->
                        @if ($sidebarCategories->count() > 0)
                            <div class="border border-gray-200 rounded-2xl p-6">
                                <h3 class="text-lg font-bold mb-4">Kategori</h3>
                                <div class="space-y-2">
                                    @foreach ($sidebarCategories as $category)
                                        <a href="{{ route('articles', ['category' => $category->slug]) }}"
                                            class="flex items-center justify-between py-2 text-sm hover:text-blue-600 transition">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-gray-500">{{ $category->published_articles_count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Related Articles -->
    @if ($relatedArticles->count() > 0)
        <section class="py-20 px-6 bg-gray-50">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl font-bold mb-12">Artikel Terkait</h2>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($relatedArticles as $related)
                        <x-article-card :article="$related" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Comments Section -->
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold mb-8">Komentar ({{ $article->approvedComments->count() }})</h2>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Comment Form -->
            <div class="mb-12 p-8 border border-gray-200 rounded-2xl">
                <h3 class="text-xl font-bold mb-6">Tinggalkan Komentar</h3>
                <form action="{{ route('comments.store', $article->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" name="author_name" value="{{ old('author_name') }}" placeholder="Nama"
                            required
                            class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition" />
                        <input type="email" name="author_email" value="{{ old('author_email') }}" placeholder="Email"
                            required
                            class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition" />
                    </div>
                    <textarea name="content" rows="4" placeholder="Tulis komentar Anda..." required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-black transition resize-none">{{ old('content') }}</textarea>
                    <button type="submit"
                        class="bg-black text-white px-8 py-3 font-medium rounded-lg hover:bg-gray-800 transition">
                        Kirim Komentar
                    </button>
                </form>
            </div>

            <!-- Comments List -->
            @if ($article->approvedComments->count() > 0)
                <div class="space-y-8">
                    @foreach ($article->approvedComments as $comment)
                        <div class="flex space-x-4">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0"></div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="font-semibold">{{ $comment->author_name }}</h4>
                                    @if ($comment->is_author_reply)
                                        <span
                                            class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded font-medium">Author</span>
                                    @endif
                                    <span class="text-sm text-gray-500">{{ $comment->time_ago }}</span>
                                </div>
                                <p class="text-gray-700 mb-3">{{ $comment->content }}</p>

                                <!-- Replies -->
                                @if ($comment->replies->count() > 0)
                                    <div class="mt-6 space-y-6">
                                        @foreach ($comment->replies as $reply)
                                            <div class="flex space-x-4">
                                                <div class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0"></div>
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-3 mb-2">
                                                        <h4 class="font-semibold">{{ $reply->author_name }}</h4>
                                                        @if ($reply->is_author_reply)
                                                            <span
                                                                class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded font-medium">Author</span>
                                                        @endif
                                                        <span class="text-sm text-gray-500">{{ $reply->time_ago }}</span>
                                                    </div>
                                                    <p class="text-gray-700">{{ $reply->content }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
        }

        function shareOnTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $article->title }}');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
        }

        function shareOnLinkedIn() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
        }

        function shareOnWhatsApp() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $article->title }}');
            window.open(`https://wa.me/?text=${text} ${url}`, '_blank');
        }
    </script>
@endpush
