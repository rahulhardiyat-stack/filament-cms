@extends('layouts.app')
@section('title', 'Lapor PPKS — Login Mahasiswa')
@section('content')
<section class="pt-32 pb-20 px-6 bg-gray-50 min-h-screen">
    <div class="max-w-lg mx-auto bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <div class="flex justify-center items-center gap-3">
            <img src="{{ asset('storage/images/encrypted.png') }}" alt="encryptes.png"
                 class="h-10 w-auto object-contain">
        </div>
        <h1 class="flex justify-center items-center text-3xl font-bold mt-12 mb-4">Verifikasi Identitas</h1>
        <p class="flex justify-center items-center text-center text-gray-600 mb-6">
            Pengaduan hanya dapat diajukan oleh korban langsung. Masukkan NIM Anda untuk dicari di MASTER/SIAKAD.</p>
        @if($errors->any())
            <div role="alert" class="mb-5 p-4 bg-red-50 text-red-700 rounded-lg">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('lapor.authenticate') }}" class="space-y-5">
            @csrf
            <div>
                <label for="nim" class="block font-medium mb-2">NIM</label>
                <input id="nim" name="nim" type="text" value="{{ old('nim') }}" maxlength="30" autocomplete="username" required class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <div>
                <label for="birth_date" class="block font-medium mb-2">Tanggal lahir</label>
                <input id="birth_date" name="birth_date" type="date" max="{{ now()->subDay()->toDateString() }}" required class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
            <button class="w-full bg-slate-900 hover:bg-slate-700
            text-white font-semibold rounded-lg px-4 py-3">Masuk dan lapor</button>
        </form>
        <p class="text-sm text-gray-500 mt-6">Jika data tidak sesuai atau akun belum terdaftar, hubungi petugas PPKS kampus.</p>
        {{--<a href="#" class="block text-blue-600 mb-4">Lapor sebagai masyarakat umum</a>--}}
    </div>
</section>
@endsection
