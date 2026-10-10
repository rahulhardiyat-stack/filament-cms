<section class="py-20 px-6 bg-black text-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">Jangan Biarkan, Segera Melapor</h2>
        <p class="text-xl text-gray-400 mb-10">
            Satgas PPKS akan menjaga keamanan dan privasi Anda dengan tidak menjual atau
            membagikan data Anda.
        </p>

        <!-- Form dibuat Flex & Center -->
        {{--<form action="{{ route('lapor.index') }}" method="POST" class="flex justify-center my-6">
            @csrf
            <button type="submit"
                    class="bg-white text-black px-8 py-4 font-medium rounded-lg hover:bg-gray-100 transition">
                Laporkan Segera
            </button>
        </form>--}}


        <div class="flex justify-center my-6">
            <button class="bg-white text-black px-8 py-4 font-medium rounded-lg hover:bg-gray-100 transition">
                <a href="{{ route('lapor.index') }}">Laporkan Segera</a>
            </button>
        </div>


        <p class="text-sm text-gray-500 mt-6">Gratis Konsultasi. Harap Menghubungi email kami.</p>
    </div>
</section>
