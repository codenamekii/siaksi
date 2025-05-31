<?php
// 5. resources/views/asesor/dokumen-fakultas.blade.php
?>
@extends('layouts.asesor')

@section('title', 'Dokumen Fakultas')

@section('content')
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
              <p class="text-blue-100 text-sm">Kode: {{ $fak->kode }}</p>
            </div>

            <!-- Dokumen List -->
            <div class="p-6">
              @if ($fak->dokumen->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  @foreach ($fak->dokumen->groupBy('kategori') as $kategori => $docs)
                    <div class="border rounded-lg p-4">
                      <h3 class="font-medium text-gray-900 mb-3">
                        {{ ucwords(str_replace('_', ' ', $kategori)) }}
                      </h3>
                      <div class="space-y-2">
                        @foreach ($docs as $doc)
                          <div class="flex items-center justify-between">
                            <div class="flex items-center">
                              <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                  d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"></path>
                              </svg>
                              <span class="text-sm text-gray-700">{{ $doc->nama }}</span>
                            </div>
                            <a href="{{ $doc->tipe == 'url' ? $doc->url : asset('storage/' . $doc->path) }}" target="_blank"
                              class="text-sm text-indigo-600 hover:text-indigo-900">
                              Lihat
                            </a>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @endforeach
                </div>
              @else
                <p class="text-gray-500">Belum ada dokumen yang tersedia untuk fakultas ini.</p>
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
