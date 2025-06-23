{{-- resources/views/asesor/dokumen-fakultas.blade.php --}}
@extends('layouts.asesor')

@section('title', 'Dokumen Fakultas')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dokumen Fakultas</h1>
        <p class="mt-2 text-sm text-gray-600">Dokumen mutu dan akreditasi tingkat fakultas</p>
      </div>


      @forelse($fakultas as $fak)
        <div class="mb-8">
          <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Fakultas Header -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
              <h2 class="text-xl font-semibold text-white">{{ $fak->nama }}</h2>
              <p class="text-white text-opacity-90 text-sm">Kode: {{ $fak->kode }}</p>
            </div>

            <!-- Dokumen List -->
            <div class="p-6">
              @if ($fak->dokumen->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  @foreach ($fak->dokumen->groupBy('kategori') as $kategori => $docs)
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                      <h3 class="font-medium text-gray-900 mb-3">
                        {{ ucwords(str_replace('_', ' ', $kategori)) }}
                      </h3>
                      <div class="space-y-3">
                        @foreach ($docs as $doc)
                          <div class="flex items-center justify-between py-2 border-b last:border-0">
                            <div class="flex items-center flex-1 min-w-0">
                              @php
                                // Determine icon color based on category
                                $iconColor = match ($kategori) {
                                    'kebijakan_mutu' => 'text-red-600',
                                    'standar_mutu' => 'text-blue-600',
                                    'laporan_ami' => 'text-green-600',
                                    'rencana_strategis' => 'text-purple-600',
                                    'prosedur' => 'text-orange-600',
                                    'instrumen' => 'text-teal-600',
                                    default => 'text-gray-600',
                                };
                              @endphp
                              <svg class="h-5 w-5 {{ $iconColor }} mr-3 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                  d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"></path>
                              </svg>
                              <div class="min-w-0">
                                <p class="text-sm text-gray-700 truncate">{{ $doc->nama }}</p>
                                @if ($doc->deskripsi)
                                  <p class="text-xs text-gray-500 truncate">{{ $doc->deskripsi }}</p>
                                @endif
                              </div>
                            </div>
                            @if ($doc->tipe == 'file')
                              @php
                                $fileExists = file_exists(storage_path('app/public/' . $doc->path));
                              @endphp
                              @if ($fileExists)
                                <a href="{{ asset('storage/' . $doc->path) }}" target="_blank"
                                  class="ml-4 inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 flex-shrink-0">
                                  <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                  </svg>
                                  Download
                                </a>
                              @else
                                <span
                                  class="ml-4 inline-flex items-center px-3 py-1.5 border border-gray-200 text-xs font-medium rounded text-gray-400 bg-gray-50 flex-shrink-0"
                                  title="File tidak ditemukan">
                                  Tidak Tersedia
                                </span>
                              @endif
                            @elseif(in_array($doc->tipe, ['url', 'link']) && !empty($doc->url))
                              <a href="{{ $doc->url }}" target="_blank"
                                class="ml-4 inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 flex-shrink-0">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                  </path>
                                </svg>
                                Buka Link
                              </a>
                            @else
                              <span
                                class="ml-4 inline-flex items-center px-3 py-1.5 border border-gray-200 text-xs font-medium rounded text-gray-400 bg-gray-50 flex-shrink-0">
                                Tidak Tersedia
                              </span>
                            @endif
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <p class="text-gray-500 text-center py-4">Belum ada dokumen yang tersedia untuk fakultas ini.</p>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="bg-white shadow-sm rounded-lg p-6">
          <p class="text-gray-500 text-center">Belum ada data fakultas yang tersedia.</p>
        </div>
      @endforelse
    </div>
  </div>
@endsection
