                    <article class="bg-white border border-gray-200 rounded-xl p-5">
                        <div class="flex flex-wrap justify-between gap-3">
                            <p class="font-medium break-all">{{ $report->reference }}</p>
                            <span class="text-sm rounded-full bg-blue-50 text-blue-700 px-3 py-1">{{ \App\Models\PpksReport::STATUSES[$report->status] ?? $report->status }}</span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Dikirim {{ $report->created_at->format('d/m/Y H:i') }}</p>
                        @if($report->evidence_paths)
                            <p class="font-medium mt-4">Bukti laporan</p>
                            <div class="grid grid-cols-3 gap-3 mt-2">
                                @foreach($report->evidence_paths as $index => $path)
                                    <a href="{{ route('lapor.evidence', [$report->reference, $index]) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ route('lapor.evidence', [$report->reference, $index]) }}" alt="Bukti {{ $index + 1 }}" loading="lazy" class="w-full h-28 object-cover rounded-lg border border-gray-200">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                        @if($report->response)
                            <p class="font-medium mt-4">Tanggapan petugas</p>
                            <p class="text-gray-700 whitespace-pre-line mt-1">{{ $report->response }}</p>
                        @endif
                    </article>
