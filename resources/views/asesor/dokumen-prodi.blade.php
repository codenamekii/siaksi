{{-- resources/views/asesor/dokumen-prodi.blade.php --}}
@extends('layouts.asesor')

@section('title', 'Dokumen Program Studi')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl py-4 mx-auto sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dokumen Program Studi</h1>
        <p class="mt-2 text-sm text-gray-600">Pilih program studi untuk melihat dokumen akreditasi dan mutu</p>
      </div>

      <!-- Filter -->
      <div class="mb-6">
        <div class="bg-white shadow-sm rounded-lg p-4">
          <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
              <label class="block text-sm font-medium text-gray-700 mb-1">Cari Program Studi</label>
              <input type="text" id="searchProdi" placeholder="Ketik nama program studi..."
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div class="min-w-[150px]">
              <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
              <select id="filterJenjang"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Semua Jenjang</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="D3">D3</option>
                <option value="D4">D4</option>
              </select>
            </div>
            <div class="min-w-[150px]">
              <label class="block text-sm font-medium text-gray-700 mb-1">Status Akreditasi</label>
              <select id="filterAkreditasi"
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Semua Status</option>
                <option value="Unggul">Unggul</option>
                <option value="Baik Sekali">Baik Sekali</option>
                <option value="Baik">Baik</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Program Studi Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="prodiContainer">
        @foreach ($programStudi as $prodi)
          @php
            // Determine color based on program name
            $colorClass = 'from-gray-500 to-gray-600'; // default
            $prodiLower = strtolower($prodi->nama);

            if (str_contains($prodiLower, 'teknik informatika') || str_contains($prodiLower, 'informatika')) {
                $colorClass = 'from-green-500 to-green-600';
            } elseif (str_contains($prodiLower, 'teknik mesin') || str_contains($prodiLower, 'mesin')) {
                $colorClass = 'from-green-500 to-green-600';
            } elseif (str_contains($prodiLower, 'teknik industri') || str_contains($prodiLower, 'industri')) {
                $colorClass = 'from-green-500 to-green-600';
            } elseif (str_contains($prodiLower, 'teknik elektro') || str_contains($prodiLower, 'elektro')) {
                $colorClass = 'from-green-500 to-green-600';
            } elseif (str_contains($prodiLower, 'teknik sipil') || str_contains($prodiLower, 'sipil')) {
                $colorClass = 'from-green-500 to-green-600';
            } 

            $akreditasiStatus = $prodi->akreditasiAktif ? $prodi->akreditasiAktif->status_akreditasi : '';
          @endphp

          <a href="{{ route('asesor.dokumen-prodi.detail', $prodi->id) }}"
            class="prodi-card block bg-white shadow-sm rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1"
            data-nama="{{ strtolower($prodi->nama) }}" data-jenjang="{{ $prodi->jenjang }}"
            data-akreditasi="{{ $akreditasiStatus }}">

            <!-- Header with dynamic color -->
            <div class="bg-gradient-to-r {{ $colorClass }} px-6 py-4">
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-lg font-semibold text-white">{{ $prodi->nama }}</h3>
                  <p class="text-white text-opacity-90 text-sm">{{ $prodi->kode }} - {{ $prodi->jenjang }}</p>
                </div>
                @if ($prodi->akreditasiAktif)
                  <span class="px-3 py-1 bg-white bg-opacity-20 text-white text-sm font-medium rounded-full">
                    {{ $prodi->akreditasiAktif->status_akreditasi }}
                  </span>
                @endif
              </div>
            </div>

            <!-- Info Section -->
            <div class="p-6">
              <!-- Akreditasi Info -->
              @if ($prodi->akreditasiAktif)
                <div class="mb-4 pb-4 border-b">
                  <div class="flex items-center text-sm text-gray-600">
                    <svg class="h-4 w-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $prodi->akreditasiAktif->lembaga_akreditasi }}</span>
                  </div>
                  <div class="flex items-center text-sm text-gray-600 mt-1">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Berlaku s.d {{ $prodi->akreditasiAktif->tanggal_berakhir->format('d M Y') }}</span>
                  </div>
                </div>
              @endif

              <!-- Document Summary -->
              <div class="space-y-2">
                <div class="flex justify-between items-center">
                  <span class="text-sm text-gray-600">Total Dokumen</span>
                  <span class="text-sm font-semibold text-gray-900">{{ $prodi->dokumen->count() }}</span>
                </div>

                @php
                  $dokumenByKategori = $prodi->dokumen->groupBy('kategori');
                  $kategoriSummary = [
                      'lkps' => [
                          'label' => 'LKPS',
                          'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
            01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                      ],
                      'evaluasi_diri' => [
                          'label' => 'LED',
                          'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0
            00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
                      ],
                      'sertifikat_akreditasi' => [
                          'label' => 'Sertifikat',
                          'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0
            001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806
            1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806
            3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42
            3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                      ],
                  ];
                @endphp

                @if ($dokumenByKategori->count() > 0)
                  <div class="grid grid-cols-3 gap-2 mt-3">
                    @foreach ($kategoriSummary as $key => $info)
                      @if (isset($dokumenByKategori[$key]))
                        <div class="text-center p-2 bg-gray-50 rounded">
                          <svg class="h-5 w-5 mx-auto mb-1 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="{{ $info['icon'] }}"></path>
                          </svg>
                          <p class="text-xs text-gray-600">{{ $info['label'] }}</p>
                          <p class="text-sm font-semibold">{{ $dokumenByKategori[$key]->count() }}</p>
                        </div>
                      @endif
                    @endforeach
                  </div>
                @endif
              </div>

              <!-- Action Button -->
              <div class="mt-4 pt-4 border-t">
                <div class="flex items-center justify-center text-indigo-600 group">
                  <span class="text-sm font-medium group-hover:text-indigo-800">Lihat Dokumen</span>
                  <svg class="ml-2 h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>

      @if ($programStudi->isEmpty())
        <div class="bg-white shadow-sm rounded-lg p-8">
          <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
              </path>
            </svg>
            <p class="mt-2 text-gray-500">Belum ada program studi yang tersedia.</p>
          </div>
        </div>
      @endif
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchProdi');
        const jenjangFilter = document.getElementById('filterJenjang');
        const akreditasiFilter = document.getElementById('filterAkreditasi');
        const prodiCards = document.querySelectorAll('.prodi-card');

        function filterProdi() {
          const searchTerm = searchInput.value.toLowerCase();
          const selectedJenjang = jenjangFilter.value;
          const selectedAkreditasi = akreditasiFilter.value;

          prodiCards.forEach(card => {
            const nama = card.dataset.nama;
            const jenjang = card.dataset.jenjang;
            const akreditasi = card.dataset.akreditasi;

            const matchSearch = nama.includes(searchTerm);
            const matchJenjang = !selectedJenjang || jenjang === selectedJenjang;
            const matchAkreditasi = !selectedAkreditasi || akreditasi === selectedAkreditasi;

            card.style.display = (matchSearch && matchJenjang && matchAkreditasi) ? 'block' : 'none';
          });
        }

        searchInput.addEventListener('input', filterProdi);
        jenjangFilter.addEventListener('change', filterProdi);
        akreditasiFilter.addEventListener('change', filterProdi);
      });
    </script>
  @endpush
@endsection
