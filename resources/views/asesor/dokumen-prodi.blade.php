<?php
// 1. resources/views/asesor/dokumen-prodi.blade.php
?>
@extends('layouts.asesor')

@section('title', 'Dokumen Program Studi')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl py-4 mx-auto sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dokumen Program Studi</h1>
        <p class="mt-2 text-sm text-gray-600">Dokumen akreditasi dan mutu tingkat program studi</p>
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
          </div>
        </div>
      </div>

      <!-- Program Studi Cards -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="prodiContainer">
        @foreach ($programStudi as $prodi)
          <div class="prodi-card bg-white shadow-sm rounded-lg overflow-hidden" data-nama="{{ strtolower($prodi->nama) }}"
            data-jenjang="{{ $prodi->jenjang }}">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-lg font-semibold text-white">{{ $prodi->nama }}</h3>
                  <p class="text-green-100 text-sm">{{ $prodi->kode }} - {{ $prodi->jenjang }}</p>
                </div>
                @if ($prodi->akreditasiAktif)
                  <span class="px-3 py-1 bg-white bg-opacity-20 text-white text-sm font-medium rounded-full">
                    {{ $prodi->akreditasiAktif->status_akreditasi }}
                  </span>
                @endif
              </div>
            </div>

            <!-- Info Akreditasi -->
            @if ($prodi->akreditasiAktif)
              <div class="px-6 py-3 bg-gray-50 border-b">
                <div class="flex items-center text-sm text-gray-600">
                  <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Akreditasi {{ $prodi->akreditasiAktif->lembaga_akreditasi }} - Berlaku s.d
                  {{ $prodi->akreditasiAktif->tanggal_berakhir->format('d M Y') }}
                </div>
              </div>
            @endif

            <!-- Dokumen List -->
            <div class="p-6">
              @if ($prodi->dokumen->count() > 0)
                @php
                  $dokumenByKategori = $prodi->dokumen->groupBy('kategori');
                  $kategoriPrioritas = [
                      'lkps',
                      'evaluasi_diri',
                      'sertifikat_akreditasi',
                      'kurikulum',
                      'data_pendukung',
                  ];
                @endphp

                <div class="space-y-3">
                  @foreach ($kategoriPrioritas as $kat)
                    @if (isset($dokumenByKategori[$kat]))
                      @foreach ($dokumenByKategori[$kat] as $doc)
                        <div class="flex items-center justify-between py-2 border-b last:border-0">
                          <div class="flex items-center flex-1">
                            @php
                              $iconColor = match ($kat) {
                                  'lkps' => 'text-blue-600',
                                  'evaluasi_diri' => 'text-purple-600',
                                  'sertifikat_akreditasi' => 'text-green-600',
                                  'kurikulum' => 'text-orange-600',
                                  default => 'text-gray-600',
                              };
                            @endphp
                            <svg class="h-5 w-5 {{ $iconColor }} mr-3" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"></path>
                            </svg>
                            <div>
                              <p class="text-sm font-medium text-gray-900">{{ $doc->nama }}</p>
                              <p class="text-xs text-gray-500">{{ ucwords(str_replace('_', ' ', $kat)) }}</p>
                            </div>
                          </div>
                          <a href="{{ $doc->tipe == 'url' ? $doc->url : asset('storage/' . $doc->path) }}" target="_blank"
                            class="ml-4 inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                            Download
                          </a>
                        </div>
                      @endforeach
                    @endif
                  @endforeach
                </div>
              @else
                <p class="text-sm text-gray-500 text-center py-4">Belum ada dokumen yang tersedia</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchProdi');
        const jenjangFilter = document.getElementById('filterJenjang');
        const prodiCards = document.querySelectorAll('.prodi-card');

        function filterProdi() {
          const searchTerm = searchInput.value.toLowerCase();
          const selectedJenjang = jenjangFilter.value;

          prodiCards.forEach(card => {
            const nama = card.dataset.nama;
            const jenjang = card.dataset.jenjang;

            const matchSearch = nama.includes(searchTerm);
            const matchJenjang = !selectedJenjang || jenjang === selectedJenjang;

            card.style.display = (matchSearch && matchJenjang) ? 'block' : 'none';
          });
        }

        searchInput.addEventListener('input', filterProdi);
        jenjangFilter.addEventListener('change', filterProdi);
      });
    </script>
  @endpush
@endsection
