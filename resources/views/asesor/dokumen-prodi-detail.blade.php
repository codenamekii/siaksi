{{-- resources/views/asesor/dokumen-prodi-detail.blade.php --}}
@extends('layouts.asesor')

@section('title', 'Dokumen ' . $programStudi->nama)

@section('content')
  <div class="py-12">
    <div class="max-w-7xl py-4 mx-auto sm:px-6 lg:px-8">
      <!-- Breadcrumb -->
      <nav class="mb-6" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
          <li>
            <a href="{{ route('asesor.dashboard') }}" class="text-gray-500 hover:text-gray-700">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path
                  d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                </path>
              </svg>
            </a>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"></path>
            </svg>
            <a href="{{ route('asesor.dokumen-prodi') }}" class="ml-2 text-gray-500 hover:text-gray-700">Dokumen Program
              Studi</a>
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd"></path>
            </svg>
            <span class="ml-2 text-gray-700 font-medium">{{ $programStudi->nama }}</span>
          </li>
        </ol>
      </nav>

      <!-- Header -->
      <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
        @php
          // Determine color based on program name
          $colorClass = 'from-gray-500 to-gray-600'; // default
          $prodiLower = strtolower($programStudi->nama);

          if (str_contains($prodiLower, 'teknik informatika') || str_contains($prodiLower, 'informatika')) {
              $colorClass = 'from-blue-500 to-blue-600';
          } elseif (str_contains($prodiLower, 'teknik mesin') || str_contains($prodiLower, 'mesin')) {
              $colorClass = 'from-blue-500 to-blue-600';
          } elseif (str_contains($prodiLower, 'teknik industri') || str_contains($prodiLower, 'industri')) {
              $colorClass = 'from-blue-500 to-blue-600';
          } elseif (str_contains($prodiLower, 'teknik elektro') || str_contains($prodiLower, 'elektro')) {
              $colorClass = 'from-blue-500 to-blue-600';
          } elseif (str_contains($prodiLower, 'teknik sipil') || str_contains($prodiLower, 'sipil')) {
              $colorClass = 'from-blue-500 to-blue-600';
          } 
        @endphp

        <div class="bg-gradient-to-r {{ $colorClass }} px-6 py-8">
          <div class="flex justify-between items-start">
            <div>
              <h1 class="text-2xl font-bold text-white">{{ $programStudi->nama }}</h1>
              <p class="text-white text-opacity-90 mt-1">{{ $programStudi->kode }} - {{ $programStudi->jenjang }}</p>
              @if ($programStudi->fakultas)
                <p class="text-white text-opacity-80 text-sm mt-2">{{ $programStudi->fakultas->nama }}</p>
              @endif
            </div>
            @if ($programStudi->akreditasiAktif)
              <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 text-white font-medium rounded-lg">
                  <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  {{ $programStudi->akreditasiAktif->status_akreditasi }}
                </span>
                <p class="text-white text-opacity-80 text-sm mt-2">
                  {{ $programStudi->akreditasiAktif->lembaga_akreditasi }}
                </p>
                <p class="text-white text-opacity-70 text-xs mt-1">
                  Berlaku s.d {{ $programStudi->akreditasiAktif->tanggal_berakhir->format('d M Y') }}
                </p>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Search and Filter -->
      <div class="bg-white shadow-sm rounded-lg p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
          <div class="flex-1 min-w-[300px]">
            <input type="text" id="searchDokumen" placeholder="Cari dokumen..."
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
          </div>
          <div class="min-w-[200px]">
            <select id="filterKategori"
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              <option value="">Semua Kategori</option>
              <option value="lkps">LKPS (Laporan Kinerja)</option>
              <option value="evaluasi_diri">LED (Evaluasi Diri)</option>
              <option value="sertifikat_akreditasi">Sertifikat Akreditasi</option>
              <option value="kurikulum">Kurikulum</option>
              <option value="data_pendukung">Data Pendukung</option>
              <option value="kebijakan_mutu">Kebijakan Mutu</option>
              <option value="standar_mutu_prodi">Standar Mutu</option>
              <option value="prosedur/SOP">Prosedur/SOP</option>
              <option value="instrumen">Instrumen</option>
              <option value="laporan_hasil_AMI">Laporan AMI</option>
              <option value="laporan_survey_kepuasan">Laporan Survey</option>
              <option value="dokumentasi_kegiatan">Dokumentasi</option>
            </select>
          </div>
          <div class="min-w-[150px]">
            <select id="filterTahun"
              class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              <option value="">Semua Tahun</option>
              @php
                $currentYear = date('Y');
                for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                    echo "<option value=\"$year\">$year</option>";
                }
              @endphp
            </select>
          </div>
        </div>
      </div>

      <!-- Documents Section -->
      @if ($dokumen->count() > 0)
        @php
          $dokumenByKategori = $dokumen->groupBy('kategori');
          $kategoriInfo = [
              'lkps' => [
                  'label' => 'LKPS (Laporan Kinerja Program Studi)',
                  'color' => 'blue',
                  'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2
    0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
              ],
              'evaluasi_diri' => [
                  'label' => 'LED (Laporan Evaluasi Diri)',
                  'color' => 'purple',
                  'icon' => 'M9 5H7a2 2 0 00-2
    2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
              ],
              'sertifikat_akreditasi' => [
                  'label' => 'Sertifikat Akreditasi',
                  'color' => 'green',
                  'icon' => 'M9 12l2 2 4-4M7.835
    4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0
    00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806
    3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0
    010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
              ],
              'kurikulum' => [
                  'label' => 'Struktur Kurikulum & Mata Kuliah',
                  'color' => 'orange',
                  'icon' => 'M12
    6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5
    1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746
    0-3.332.477-4.5 1.253',
              ],
              'data_pendukung' => [
                  'label' => 'Data Pendukung',
                  'color' => 'teal',
                  'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0
    01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
              ],
              'kebijakan_mutu' => [
                  'label' => 'Kebijakan Mutu',
                  'color' => 'red',
                  'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955
    11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332
    9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
              ],
              'standar_mutu_prodi' => [
                  'label' => 'Standar Mutu Program Studi',
                  'color' => 'yellow',
                  'icon' => 'M11
    5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0
    7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z',
              ],
              'prosedur/SOP' => [
                  'label' => 'Prosedur & SOP',
                  'color' => 'indigo',
                  'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002
    2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3
    4h3m-6-4h.01M9 16h.01',
              ],
              'instrumen' => [
                  'label' => 'Instrumen',
                  'color' => 'pink',
                  'icon' => 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2
    2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4',
              ],
              'laporan_hasil_AMI' => [
                  'label' => 'Laporan Hasil AMI',
                  'color' => 'gray',
                  'icon' => 'M10 21h7a2 2 0 002-2V9.414a1 1
    0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0
    00-4.243 4.242z',
              ],
              'laporan_survey_kepuasan' => [
                  'label' => 'Laporan Survey Kepuasan',
                  'color' => 'cyan',
                  'icon' => 'M16 7a4 4 0 11-8 0
    4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
              ],
              'dokumentasi_kegiatan' => [
                  'label' => 'Dokumentasi Kegiatan',
                  'color' => 'emerald',
                  'icon' => 'M4 16l4.586-4.586a2 2
    0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2
    2v12a2 2 0 002 2z',
              ],
          ];

          $kategoriPrioritas = array_keys($kategoriInfo);
        @endphp

        <div class="space-y-6" id="dokumenContainer">
          @foreach ($kategoriPrioritas as $kategori)
            @if (isset($dokumenByKategori[$kategori]))
              @php
                $info = $kategoriInfo[$kategori];
                $docs = $dokumenByKategori[$kategori];
              @endphp

              <div class="dokumen-kategori bg-white shadow-sm rounded-lg overflow-hidden"
                data-kategori="{{ $kategori }}">
                <!-- Category Header -->
                <div class="bg-{{ $info['color'] }}-50 px-6 py-4 border-b border-{{ $info['color'] }}-100">
                  <div class="flex items-center">
                    <svg class="h-6 w-6 text-{{ $info['color'] }}-600 mr-3" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $info['icon'] }}">
                      </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $info['label'] }}</h3>
                    <span
                      class="ml-auto bg-{{ $info['color'] }}-100 text-{{ $info['color'] }}-800 text-xs font-medium px-2.5 py-0.5 rounded">
                      {{ $docs->count() }} dokumen
                    </span>
                  </div>
                </div>

                <!-- Documents List -->
                <div class="divide-y divide-gray-200">
                  @foreach ($docs as $doc)
                    <div class="dokumen-item px-6 py-4 hover:bg-gray-50" data-nama="{{ strtolower($doc->nama) }}"
                      data-tahun="{{ $doc->tahun ?? '' }}">
                      <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                          <div class="flex items-start">
                            <div class="flex-shrink-0">
                              @if ($doc->tipe == 'file')
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"
                                    clip-rule="evenodd" />
                                </svg>
                              @elseif($doc->tipe == 'url' || $doc->tipe == 'link')
                                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor"
                                  viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                  </path>
                                </svg>
                              @else
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"
                                    clip-rule="evenodd" />
                                </svg>
                              @endif
                            </div>
                            <div class="ml-3 flex-1">
                              <p class="text-sm font-medium text-gray-900">{{ $doc->nama }}</p>
                              <div class="mt-1 flex items-center text-xs text-gray-500">
                                @if ($doc->kriteria)
                                  <span class="bg-gray-100 px-2 py-0.5 rounded mr-2">Kriteria:
                                    {{ $doc->kriteria }}</span>
                                @endif
                                @if ($doc->sub_kriteria)
                                  <span class="bg-gray-100 px-2 py-0.5 rounded mr-2">Sub:
                                    {{ $doc->sub_kriteria }}</span>
                                @endif
                                @if ($doc->tahun)
                                  <span class="mr-2">Tahun: {{ $doc->tahun }}</span>
                                @endif
                                @if ($doc->catatan)
                                  <span class="text-gray-400">{{ Str::limit($doc->catatan, 50) }}</span>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="ml-4 flex-shrink-0 flex items-center space-x-2">
                          @if ($doc->updated_at)
                            <span class="text-xs text-gray-500" title="Terakhir diperbarui">
                              {{ $doc->updated_at->diffForHumans() }}
                            </span>
                          @endif

                          @if ($doc->tipe == 'file')
                            @php
                              $fileExists = file_exists(storage_path('app/public/' . $doc->path));
                            @endphp
                            @if ($fileExists)
                              <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                  </path>
                                </svg>
                                Download
                              </a>
                            @else
                              <span
                                class="inline-flex items-center px-3 py-1.5 border border-gray-200 text-xs font-medium rounded-md text-gray-400 bg-gray-50">
                                File tidak tersedia
                              </span>
                            @endif
                          @elseif(in_array($doc->tipe, ['url', 'link']) && !empty($doc->url))
                            <a href="{{ $doc->url }}" target="_blank"
                              class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                              <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                              </svg>
                              Buka Link
                            </a>
                          @else
                            <span
                              class="inline-flex items-center px-3 py-1.5 border border-gray-200 text-xs font-medium rounded-md text-gray-400 bg-gray-50">
                              Tidak tersedia
                            </span>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach

          {{-- Other categories not in priority list --}}
          @foreach ($dokumenByKategori as $kategori => $docs)
            @if (!in_array($kategori, $kategoriPrioritas))
              <div class="dokumen-kategori bg-white shadow-sm rounded-lg overflow-hidden"
                data-kategori="{{ $kategori }}">
                <div class="bg-gray-50 px-6 py-4 border-b">
                  <div class="flex items-center">
                    <svg class="h-6 w-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                      </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $kategori)) }}</h3>
                    <span class="ml-auto bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">
                      {{ $docs->count() }} dokumen
                    </span>
                  </div>
                </div>
                <div class="divide-y divide-gray-200">
                  @foreach ($docs as $doc)
                    <div class="dokumen-item px-6 py-4 hover:bg-gray-50" data-nama="{{ strtolower($doc->nama) }}"
                      data-tahun="{{ $doc->tahun ?? '' }}">
                      <!-- Same document item structure as above -->
                    </div>
                  @endforeach
                </div>
              </div>
            @endif
          @endforeach
        </div>
      @else
        <div class="bg-white shadow-sm rounded-lg p-8">
          <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
              </path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada dokumen</h3>
            <p class="mt-1 text-sm text-gray-500">Dokumen untuk program studi ini belum tersedia.</p>
          </div>
        </div>
      @endif
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchDokumen');
        const kategoriFilter = document.getElementById('filterKategori');
        const tahunFilter = document.getElementById('filterTahun');

        function filterDokumen() {
          const searchTerm = searchInput.value.toLowerCase();
          const selectedKategori = kategoriFilter.value;
          const selectedTahun = tahunFilter.value;

          // Filter categories
          document.querySelectorAll('.dokumen-kategori').forEach(kategoriDiv => {
            const kategori = kategoriDiv.dataset.kategori;
            const shouldShowKategori = !selectedKategori || kategori === selectedKategori;

            if (shouldShowKategori) {
              kategoriDiv.style.display = 'block';

              // Filter documents within category
              let visibleDocs = 0;
              kategoriDiv.querySelectorAll('.dokumen-item').forEach(item => {
                const nama = item.dataset.nama;
                const tahun = item.dataset.tahun;

                const matchSearch = nama.includes(searchTerm);
                const matchTahun = !selectedTahun || tahun === selectedTahun;

                if (matchSearch && matchTahun) {
                  item.style.display = 'flex';
                  visibleDocs++;
                } else {
                  item.style.display = 'none';
                }
              });

              // Hide category if no documents visible
              if (visibleDocs === 0 && (searchTerm || selectedTahun)) {
                kategoriDiv.style.display = 'none';
              }
            } else {
              kategoriDiv.style.display = 'none';
            }
          });
        }

        searchInput.addEventListener('input', filterDokumen);
        kategoriFilter.addEventListener('change', filterDokumen);
        tahunFilter.addEventListener('change', filterDokumen);
      });
    </script>
  @endpush
@endsection
