<footer class="bg-white border-t border-gray-200 py-12 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <h3 class="text-2xl font-bold mb-4">Satgas PPKS</h3>
                <p class="text-gray-600 text-sm">
                    Platform yang hadir sebagai ruang aman bagi seluruh civitas akademika
                    STAIN Teungku Dirundeng Meulaboh.
                </p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Kategori</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    @foreach (\App\Models\Category::active()->ordered()->limit(4)->get() as $category)
                        <li>
                            <a href="{{ route('articles', ['category' => $category->slug]) }}"
                                class="hover:text-black transition">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Halaman</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="{{ route('articles') }}" class="hover:text-black transition">Artikel</a></li>
                    <li><a href="{{ route('categories') }}" class="hover:text-black transition">Kategori</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-black transition">Tentang</a></li>
                    <li><a href="{{ route('lapor.index') }}" class="hover:text-black transition">Lapor</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-black transition">satgasppks.staindirundeng.ac.id </a></li>
                </ul>
            </div>
        </div>
        <div
            class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} TIPD. Hak cipta dilindungi.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-black transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-black transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
