{{-- Lokasi file: resources/views/asesor/dokumen-institusi.blade.php --}}
@extends('layouts.asesor')

@section('title', 'Dokumen Institusi')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl py-4 mx-auto sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dokumen Institusi</h1>
        <p class="mt-2 text-sm text-gray-600">Dokumen kebijakan dan standar mutu tingkat universitas</p>
      </div>

      <!-- Kebijakan SPMI -->
      <div id="kebijakan" class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Kebijakan SPMI Universitas</h2>
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
          <div class="p-6">
            @if (isset($dokumen['kebijakan_mutu']) && $dokumen['kebijakan_mutu']->count() > 0)
              <div class="space-y-4">
                @foreach ($dokumen['kebijakan_mutu'] as $doc)
                  <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                    <div class="flex items-center">
                      <svg class="h-10 w-10 text-red-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"
                          clip-rule="evenodd" />
                      </svg>
                      <div>
                        <h3 class="text-sm font-medium text-gray-900">{{ $doc->nama }}</h3>
                        @if ($doc->deskripsi)
                          <p class="text-sm text-gray-500">{{ $doc->deskripsi }}</p>
                        @endif
                      </div>
                    </div>
                    <a href="{{ $doc->download_url }}" target="_blank"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                      <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                      </svg>
                      Download
                    </a>
                  </div>
                @endforeach
              </div>
            @else
              <p class="text-gray-500">Belum ada dokumen kebijakan SPMI yang tersedia.</p>
            @endif
          </div>
        </div>
      </div>

      <!-- Standar Mutu -->
      <div id="standar" class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Standar Mutu Universitas</h2>
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
          <div class="p-6">
            @if (isset($dokumen['standar_mutu']) && $dokumen['standar_mutu']->count() > 0)
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($dokumen['standar_mutu'] as $doc)
                  <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start">
                      <svg class="h-8 w-8 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd"
                          d="M4 5a2 2 0 012-2 1 1 0 000 2H6a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2 1 1 0 100-2 2 2 0 012 2v8a2 2 0 01-2 2H6a2 2 0 01-2-2V5z">
                        </path>
                      </svg>
                      <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">{{ $doc->nama }}</h3>
                        @if ($doc->kriteria)
                          <p class="text-xs text-gray-500 mt-1">{{ $doc->kriteria }}</p>
                        @endif
                      </div>
                    </div>
                    <div class="mt-4">
                      <a href="{{ $doc->download_url }}" target="_blank"
                        class="text-sm text-indigo-600 hover:text-indigo-900">
                        Lihat Dokumen →
                      </a>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <p class="text-gray-500">Belum ada dokumen standar mutu yang tersedia.</p>
            @endif
          </div>
        </div>
      </div>

      <!-- Other Categories -->
      @foreach ($dokumen as $kategori => $docs)
        @if (!in_array($kategori, ['kebijakan_mutu', 'standar_mutu']))
          <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ ucwords(str_replace('_', ' ', $kategori)) }}</h2>
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
              <div class="p-6">
                <div class="space-y-4">
                  @foreach ($docs as $doc)
                    <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                      <div class="flex items-center">
                        <svg class="h-10 w-10 text-gray-600 mr-4" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"
                            clip-rule="evenodd" />
                        </svg>
                        <div>
                          <h3 class="text-sm font-medium text-gray-900">{{ $doc->nama }}</h3>
                          @if ($doc->deskripsi)
                            <p class="text-sm text-gray-500">{{ $doc->deskripsi }}</p>
                          @endif
                        </div>
                      </div>
                      <a href="{{ $doc->download_url }}" target="_blank"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                          </path>
                        </svg>
                        Download
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach

      @if ($dokumen->isEmpty())
        <div class="bg-white shadow-sm rounded-lg p-6">
          <p class="text-gray-500 text-center">Belum ada dokumen institusi yang tersedia.</p>
        </div>
      @endif
    </div>
  </div>
@endsection
