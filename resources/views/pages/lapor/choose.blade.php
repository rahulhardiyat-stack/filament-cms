@extends('layouts.app')
@section('title', 'Layanan Pelaporan PPKS')
@section('content')
<section class="pt-32 pb-20 px-6 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold mb-4">Layanan pelaporan PPKS</h1>
        <p class="text-gray-600 mb-8">Pilih jalur pelaporan. Identitas dan isi laporan hanya digunakan petugas untuk tindak lanjut.</p>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white border rounded-xl p-6">
                    <h2 class="flex justify-center items-center text-xl font-bold mb-3">Mahasiswa</h2>
                    <p class="flex justify-center items-center text-center">Masuk dengan NIM dan tanggal lahir untuk mengirim laporan dan melihat tindak lanjut.</p>
                    <button class="mx-auto block bg-slate-700 hover:bg-slate-900 text-white font-bold py-2 px-4 mt-6 rounded-md">
                        <a href="{{ route('lapor.index') }}">Lapor</a>
                    </button>
                </div>
                <div class="bg-white border rounded-xl p-6 opacity-50">
                    <h2 class=" flex justify-center items-center text-xl font-bold mb-3">Masyarakat Umum</h2>
                    <p class="flex justify-center items-center text-center">Daftar atau masuk menggunakan username dan password untuk mengirim laporan dan melihat tindak lanjut.</p>
                    <button class="mx-auto block bg-slate-700 hover:bg-slate-900 text-white font-bold py-2 px-4 mt-6 rounded-md" disabled>
                        {{-- pointer buttun not allowed--}}
{{--                        <a href="{{ route('lapor.public.index') }}"--}}
{{--                           class="pointer-events-none cursor-not-allowed">--}}
{{--                            Lapor--}}
{{--                        </a>--}}
                        Lapor
                    </button>
                </div>
                </div>

    </div>
</section>
@endsection
