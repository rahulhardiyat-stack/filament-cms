@extends('layouts.app')
@section('title', 'Lapor PPKS')
@section('content')
    <section class="pt-32 pb-20 px-6 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
                <div>
                    <p class="text-sm font-semibold text-blue-600 mb-2">LAYANAN PPKS</p>
                    <h1 class="text-3xl font-bold">Form pelaporan</h1>
                </div>
                <div>
                    <p class="p-5 bg-blue-50 text-blue-900 rounded-xl mb-6">Ceritakan kejadian sesuai yang Anda ketahui. Identitas dan isi laporan tidak ditampilkan ke publik. Untuk bantuan mendesak, hubungi petugas PPKS atau keamanan kampus secara langsung.</p>
                    @if(session('success'))
                        <div role="status" class="p-4 bg-green-50 text-green-800 rounded-lg mb-6">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div role="alert" class="p-4 bg-red-50 text-red-700 rounded-lg mb-6">
                            <p class="font-semibold">Periksa kembali isian berikut:</p>
                            <ul class="list-disc pl-5 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('lapor.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="reporter_role" class="block font-medium mb-2">Melapor sebagai *</label>
                            <select id="reporter_role" name="reporter_role" required class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                <option value="">Pilih peran</option>
                                @foreach(\App\Models\PpksReport::ROLES as $value => $label)
                                    <option value="{{ $value }}" @selected(old('reporter_role') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="incident_date" class="block font-medium mb-2">Tanggal kejadian *</label>
                            <input id="incident_date" name="incident_date" type="date" value="{{ old('incident_date') }}" max="{{ now()->toDateString() }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        </div>
                    </div>
                    <div>
                        <label for="location" class="block font-medium mb-2">Lokasi atau media kejadian *</label>
                        <input id="location" name="location" value="{{ old('location') }}" maxlength="500" required placeholder="Contoh: area kampus atau media komunikasi daring" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label for="reported_person" class="block font-medium mb-2">Nama atau keterangan terlapor (opsional)</label>
                        <input id="reported_person" name="reported_person" value="{{ old('reported_person') }}" maxlength="500" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label for="chronology" class="block font-medium mb-2">Kronologi kejadian *</label>
                        <textarea id="chronology" name="chronology" rows="7" minlength="20" maxlength="10000" required aria-describedby="chronology-help" class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('chronology') }}</textarea>
                        <p id="chronology-help" class="text-sm text-gray-500 mt-2">Minimal 20 karakter. Tuliskan urutan kejadian dan informasi yang Anda ketahui.</p>
                    </div>
                    <div>
                        <label for="contact" class="block font-medium mb-2">Kontak yang aman untuk dihubungi *</label>
                        <input id="contact" name="contact" value="{{ old('contact') }}" maxlength="255" required placeholder="Nomor telepon atau email" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label for="support_needed" class="block font-medium mb-2">Bantuan yang dibutuhkan (opsional)</label>
                        <textarea id="support_needed" name="support_needed" rows="3" maxlength="2000" placeholder="Contoh: pendampingan, konseling, atau cara aman untuk menghubungi Anda" class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('support_needed') }}</textarea>
                    </div>
                    <div>
                        <label for="evidence" class="block font-medium mb-2">Upload bukti (opsional)</label>
                        <input id="evidence" name="evidence[]" type="file" multiple accept="image/jpeg,image/png,image/webp" aria-describedby="evidence-help evidence-status" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        <p id="evidence-help" class="text-sm text-gray-500 mt-2">Maksimal 3 gambar, masing-masing maksimal 2 MB. Format JPG, PNG, atau WebP. Bukti hanya dapat diakses pelapor dan admin. Jika form gagal dikirim, pilih ulang gambarnya.</p>
                        <p id="evidence-status" role="status" class="text-sm mt-2"></p>
                    </div>
                    <label class="flex items-start gap-3">
                        <input type="checkbox" name="consent" value="1" required @checked(old('consent')) class="mt-1">
                        <span class="text-sm text-gray-700">Saya menyampaikan informasi sesuai yang saya ketahui dan menyetujui penggunaan data laporan oleh petugas PPKS untuk tindak lanjut. *</span>
                    </label>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold px-6 py-3">Kirim laporan</button>
                </form>

            </div>
        </div>
    </section>
@endsection


@push('scripts')
<script>
    const evidenceInput = document.getElementById('evidence');
    evidenceInput.addEventListener('change', () => {
        const files = Array.from(evidenceInput.files);
        let message = '';
        if (files.length > 3) {
            message = 'Bukti maksimal 3 gambar.';
        } else if (files.some(file => file.size > 2 * 1024 * 1024)) {
            message = 'Ukuran setiap gambar maksimal 2 MB.';
        } else if (files.some(file => !['image/jpeg', 'image/png', 'image/webp'].includes(file.type))) {
            message = 'Format bukti harus JPG, PNG, atau WebP.';
        }
        evidenceInput.setCustomValidity(message);
        document.getElementById('evidence-status').textContent = message || (files.length ? `${files.length} gambar dipilih.` : '');
        if (message) evidenceInput.reportValidity();
    });
</script>
@endpush
