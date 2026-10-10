@extends('layouts.app')
@section('title', 'Lapor PPKS ? Masyarakat Umum')
@section('content')
<section class="pt-32 pb-20 px-6 bg-gray-50 min-h-screen"><div class="max-w-4xl mx-auto">
<a href="{{ route('lapor.choose') }}" class="text-blue-600">Pilihan layanan pelaporan</a>
<div class="flex flex-wrap justify-between items-center gap-4 my-6"><div><h1 class="text-3xl font-bold">Pelaporan masyarakat umum</h1><p class="text-gray-600 mt-2">{{ $reporter->name }} ? {{ $reporter->username }}</p></div>
<form method="POST" action="{{ route('lapor.public.logout') }}">@csrf<button class="border rounded-lg px-4 py-2">Keluar</button></form></div>
<p class="p-5 bg-blue-50 rounded-xl mb-6">Identitas dan isi laporan tidak ditampilkan ke publik. Untuk bantuan mendesak, hubungi petugas PPKS atau keamanan kampus secara langsung.</p>
@if(session('success'))<p role="status" class="mb-4 text-green-800">{{ session('success') }}</p>@endif
@if($errors->any())<div role="alert" class="mb-6 text-red-700"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@include('pages.lapor.form', ['submitRoute' => route('lapor.public.store')])
<h2 class="text-2xl font-bold mt-12 mb-5">Laporan saya</h2>
<div class="space-y-4">@forelse($reports as $report)
@include('pages.lapor.report')
@empty<p class="text-gray-500">Belum ada laporan yang dikirim.</p>@endforelse</div>
<div class="mt-5">{{ $reports->links() }}</div>
</div></section>
@endsection
