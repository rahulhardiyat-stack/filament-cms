@extends('layouts.app')
@section('title', $mode === 'register' ? 'Registrasi Masyarakat' : 'Login Masyarakat')
@section('content')
<section class="pt-32 pb-20 px-6 bg-gray-50 min-h-screen"><div class="max-w-lg mx-auto bg-white border rounded-2xl p-8">
<a href="{{ route('lapor.choose') }}" class="text-blue-600">Pilihan layanan pelaporan</a>
<p class="text-sm font-semibold text-blue-600 mt-5 mb-3">LAYANAN PPKS ? MASYARAKAT UMUM</p>
<h1 class="text-3xl font-bold mb-4">{{ $mode === 'register' ? 'Daftar akun masyarakat' : 'Login masyarakat' }}</h1>
<p class="text-gray-600 mb-6">Gunakan username dan password untuk mengirim laporan dan melihat tindak lanjut.</p>
@if($errors->any())<div role="alert" class="mb-5 text-red-700"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route($mode === 'register' ? 'lapor.public.register.store' : 'lapor.public.authenticate') }}" class="space-y-5">@csrf
@if($mode === 'register')
<div><label for="name" class="block font-medium mb-2">Nama lengkap</label><input id="name" name="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name" class="w-full border rounded-lg px-4 py-3"></div>
@endif
<div><label for="username" class="block font-medium mb-2">Username</label><input id="username" name="username" value="{{ old('username') }}" required maxlength="50" autocomplete="username" autocapitalize="none" spellcheck="false" class="w-full border rounded-lg px-4 py-3">
@if($mode === 'register')<p class="text-sm text-gray-500 mt-2">3?50 karakter: huruf, angka, titik, atau garis bawah. Huruf besar akan diubah menjadi huruf kecil.</p>@endif</div>
<div><label for="password" class="block font-medium mb-2">Password</label><input id="password" name="password" type="password" required maxlength="128" autocomplete="{{ $mode === 'register' ? 'new-password' : 'current-password' }}" class="w-full border rounded-lg px-4 py-3">
@if($mode === 'register')<p class="text-sm text-gray-500 mt-2">Minimal 12 karakter, termasuk huruf dan angka.</p>@endif</div>
@if($mode === 'register')<div><label for="password_confirmation" class="block font-medium mb-2">Konfirmasi password</label><input id="password_confirmation" name="password_confirmation" type="password" required maxlength="128" autocomplete="new-password" class="w-full border rounded-lg px-4 py-3"></div>@endif
<button class="w-full bg-blue-600 text-white font-semibold rounded-lg px-4 py-3">{{ $mode === 'register' ? 'Daftar dan mulai melapor' : 'Masuk' }}</button></form>
<p class="mt-6"><a href="{{ route($mode === 'register' ? 'lapor.public.login' : 'lapor.public.register') }}" class="text-blue-600">{{ $mode === 'register' ? 'Sudah punya akun? Login' : 'Belum punya akun? Daftar' }}</a></p>
</div></section>
@endsection
