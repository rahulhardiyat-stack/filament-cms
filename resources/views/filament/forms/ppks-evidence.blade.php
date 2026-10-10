<div>
    <h3 class="text-sm font-medium mb-3">Bukti laporan</h3>
    <div class="grid grid-cols-3 gap-4">
        @forelse(($getRecord()?->evidence_paths ?? []) as $index => $path)
            <a href="{{ route('lapor.evidence', [$getRecord()->reference, $index]) }}" target="_blank" rel="noopener noreferrer">
                <img src="{{ route('lapor.evidence', [$getRecord()->reference, $index]) }}" alt="Bukti {{ $index + 1 }}" loading="lazy" class="w-full h-32 object-cover rounded-lg">
                <span class="text-sm">Lihat bukti {{ $index + 1 }}</span>
            </a>
        @empty
            <p class="text-sm text-gray-500 col-span-3">Tidak ada bukti gambar yang dilampirkan.</p>
        @endforelse
    </div>
</div>
