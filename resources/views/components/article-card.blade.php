@props(['article'])

<article class="border border-gray-200 rounded-2xl overflow-hidden hover-lift cursor-pointer">
    <a href="{{ route('article.detail', $article->slug) }}">
        @if ($article->featured_image_url)
            <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                class="w-full aspect-[16/10] object-cover">
        @else
            <div class="aspect-[16/10] bg-gray-100 flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
        @endif
    </a>
    <div class="p-6">
        <div class="flex items-center space-x-3 mb-3">
            <span class="text-xs font-semibold {{ $article->category->color_class }} uppercase tracking-wide">
                {{ $article->category->name }}
            </span>
            <span class="text-sm text-gray-500">{{ $article->read_time_text }}</span>
        </div>
        <a href="{{ route('article.detail', $article->slug) }}">
            <h3 class="text-xl font-bold mb-3 hover:text-blue-600 transition">{{ $article->title }}</h3>
        </a>
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $article->excerpt }}</p>
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <div class="flex items-center">
                @if ($article->author->avatar_url)
                    <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}"
                        class="w-8 h-8 rounded-full mr-2">
                @else
                    <div class="w-8 h-8 bg-gray-300 rounded-full mr-2"></div>
                @endif
                <span class="text-sm font-medium">{{ $article->author->name }}</span>
            </div>
            <span class="text-xs text-gray-500">{{ $article->short_date }}</span>
        </div>
    </div>
</article>
