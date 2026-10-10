@extends('layouts.app')
@section('title', 'Lapor PPKS')
@section('content')
<section class="pt-32 pb-20 px-6 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div>
                <p class="text-sm font-semibold text-blue-600 mb-2">LAYANAN PPKS</p>
                <h1 class="text-3xl font-bold">Form pelaporan</h1>
                <p class="text-gray-600 mt-2">{{ $student->name }} · {{ $student->nim }} · {{ $student->program_studi }}</p>
            </div>
            <div class="flex gap-4">
                <form method="GET" action="{{ route('lapor.form') }}">
                    <button class="mx-auto block bg-slate-900 hover:bg-slate-700
                    text-white font-bold py-2 px-4 rounded-lg">Buat Laporan</button>
                </form>
                <form method="POST" action="{{ route('lapor.logout') }}">
                    @csrf
                    <button class="border border-gray-300 bg-white hover:bg-gray-100 rounded-lg px-4 py-2">Keluar</button>
                </form>
            </div>
        </div>
        {{--<p class="p-5 bg-blue-50 text-blue-900 rounded-xl mb-6">Ceritakan kejadian sesuai yang Anda ketahui. Identitas dan isi laporan tidak ditampilkan ke publik. Untuk bantuan mendesak, hubungi petugas PPKS atau keamanan kampus secara langsung.</p>
        @if(session('success'))
            <div role="status" class="p-4 bg-green-50 text-green-800 rounded-lg mb-6">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div role="alert" class="p-4 bg-red-50 text-red-700 rounded-lg mb-6">
                <p class="font-semibold">Periksa kembali isian berikut:</p>
                <ul class="list-disc pl-5 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif--}}

{{--        @include('pages.lapor.form', ['submitRoute' => route('lapor.store')])--}}

        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-5">Laporan saya</h2>
            <div class="space-y-4">
                @forelse($reports as $report)
                    @include('pages.lapor.report')
                @empty
                    <p class="text-gray-500">Belum ada laporan yang dikirim.</p>
                @endforelse
            </div>
            <div class="mt-5">{{ $reports->links() }}</div>
        </div>
    </div>
</section>
@endsection
