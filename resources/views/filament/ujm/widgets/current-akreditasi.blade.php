?>
<x-filament-widgets::widget>
  <x-filament::section>
    <div class="space-y-4">
      @if ($akreditasi)
        <div
          class="bg-gradient-to-r from-{{ $akreditasi->status_akreditasi == 'Unggul' ? 'green' : ($akreditasi->status_akreditasi == 'Baik Sekali' ? 'blue' : 'yellow') }}-50 to-white p-6 rounded-lg">
          <div class="flex items-start justify-between">
            <div>
              <h3 class="text-2xl font-bold text-gray-900">
                Status Akreditasi: {{ $akreditasi->status_akreditasi }}
              </h3>
              <p class="text-gray-600 mt-1">
                {{ $akreditasi->lembaga_akreditasi }} - SK No. {{ $akreditasi->nomor_sk }}
              </p>

              <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <p class="text-sm text-gray-500">Tanggal Akreditasi</p>
                  <p class="font-semibold">{{ $akreditasi->tanggal_akreditasi->format('d F Y') }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Berlaku Sampai</p>
                  <p class="font-semibold">{{ $akreditasi->tanggal_berakhir->format('d F Y') }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Sisa Masa Berlaku</p>
                  <p
                    class="font-semibold {{ $akreditasi->tanggal_berakhir->diffInMonths(now()) <= 6 ? 'text-red-600' : 'text-green-600' }}">
                    @if ($akreditasi->tanggal_berakhir->isPast())
                      Kadaluarsa
                    @else
                      {{ $akreditasi->tanggal_berakhir->diffForHumans() }}
                    @endif
                  </p>
                </div>
              </div>
            </div>

            @if ($akreditasi->sertifikat)
              <a href="{{ asset('storage/' . $akreditasi->sertifikat) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                  </path>
                </svg>
                Download Sertifikat
              </a>
            @endif
          </div>

          @if ($akreditasi->tanggal_berakhir->diffInMonths(now()) <= 6)
            <div class="mt-4 bg-red-50 border border-red-200 rounded-md p-4">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                      clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm text-red-800">
                    <strong>Perhatian!</strong> Akreditasi akan berakhir dalam
                    {{ $akreditasi->tanggal_berakhir->diffInMonths(now()) }} bulan.
                    Segera persiapkan dokumen untuk re-akreditasi.
                  </p>
                </div>
              </div>
            </div>
          @endif
        </div>
      @else
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          <p class="mt-2 text-gray-600">Belum ada data akreditasi aktif</p>
          <p class="text-sm text-gray-500">Silakan tambahkan data akreditasi program studi</p>
        </div>
      @endif
    </div>
  </x-filament::section>
</x-filament-widgets::widget>
