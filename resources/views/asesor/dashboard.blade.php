@extends('layouts.asesor')

@section('title', 'Dashboard')

@section('content')
  <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    {{-- Hero Section --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 pb-32">
      <div class="absolute inset-0">
        <img src="{{ asset('storage/login.jpg') }}" alt="Hero Background" class="w-full h-full object-cover opacity-30">
      </div>

      <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-12 pb-8">
        <div class="text-center">
          <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
            Dashboard Asesor
          </h1>
          <p class="mt-3 max-w-2xl mx-auto text-xl text-blue-100 sm:mt-4">
            Selamat datang, {{ auth()->user()->name }}
          </p>
          <p class="mt-2 text-blue-200">
            Sistem Informasi Akreditasi - {{ now()->format('l, d F Y') }}
          </p>
        </div>
      </div>
    </div>

    {{-- Quick Stats Cards --}}
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-24">
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total Fakultas Card --}}
        <div
          class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-blue-500 opacity-10"></div>
          <div class="relative">
            <div class="flex items-center">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                  </path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Fakultas</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalFakultas ?? 0 }}</p>
              </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
              <span class="text-green-600 font-medium">
                <svg class="inline h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"></path>
                </svg>
                100% Aktif
              </span>
            </div>
          </div>
        </div>

        {{-- Total Program Studi Card --}}
        <div
          class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-indigo-500 opacity-10"></div>
          <div class="relative">
            <div class="flex items-center">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                  </path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Program Studi</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalProdi ?? 0 }}</p>
              </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
              <span class="text-indigo-600 font-medium">
                {{ $prodiTerakreditasi ?? 0 }} Terakreditasi
              </span>
            </div>
          </div>
        </div>

        {{-- Total Dokumen Card --}}
        <div
          class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-green-500 opacity-10"></div>
          <div class="relative">
            <div class="flex items-center">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                  </path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Dokumen</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalDokumen ?? 0 }}</p>
              </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-sm">
              <span class="text-gray-600">Dapat diakses</span>
              <span class="text-green-600 font-medium">{{ $dokumenVisible ?? 0 }}</span>
            </div>
          </div>
        </div>

        {{-- Akreditasi Status Card --}}
        <div
          class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all hover:shadow-2xl hover:-translate-y-1">
          <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-purple-500 opacity-10"></div>
          <div class="relative">
            <div class="flex items-center">
              <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500 text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                  </path>
                </svg>
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Status Akreditasi</p>
                <p class="text-2xl font-bold text-gray-900">{{ $akreditasiAktif ?? 0 }}</p>
              </div>
            </div>
            <div class="mt-4">
              <div class="flex items-center justify-between text-xs">
                <span class="text-gray-600">Unggul</span>
                <span class="font-medium text-purple-600">{{ $akreditasiUnggul ?? 0 }}</span>
              </div>
              <div class="flex items-center justify-between text-xs mt-1">
                <span class="text-gray-600">Baik Sekali</span>
                <span class="font-medium text-blue-600">{{ $akreditasiBaikSekali ?? 0 }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Recent Documents & Activities --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        {{-- Recent Documents --}}
        <div class="lg:col-span-2">
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
              <h2 class="text-xl font-semibold text-white flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                  </path>
                </svg>
                Dokumen Terbaru
              </h2>
            </div>
            <div class="p-6">
              <div class="space-y-4">
                @forelse($recentDocuments ?? [] as $doc)
                  <div
                    class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="flex items-center space-x-4">
                      <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                          <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                            </path>
                          </svg>
                        </div>
                      </div>
                      <div>
                        <h4 class="text-sm font-medium text-gray-900">{{ $doc->nama }}</h4>
                        <p class="text-xs text-gray-500">{{ $doc->created_at->diffForHumans() }}</p>
                      </div>
                    </div>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $doc->level == 'universitas'
                                        ? 'bg-purple-100 text-purple-800'
                                        : ($doc->level == 'fakultas'
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'bg-green-100 text-green-800') }}">
                      {{ ucfirst($doc->level) }}
                    </span>
                  </div>
                @empty
                  <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                      </path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada dokumen terbaru</p>
                  </div>
                @endforelse
              </div>
            </div>
          </div>
        </div>

        {{-- Quick Access --}}
        <div class="space-y-6">
          {{-- Calendar Widget --}}
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
              <h2 class="text-xl font-semibold text-white">Kalender</h2>
            </div>
            <div class="p-6">
              <div class="text-center">
                <div class="text-4xl font-bold text-gray-900">{{ now()->format('d') }}</div>
                <div class="text-lg text-gray-600">{{ now()->format('F Y') }}</div>
                <div class="mt-4 space-y-2">
                  <div class="text-sm text-gray-500">Jadwal AMI Terdekat</div>
                  <div class="text-sm font-medium text-purple-600">15 Juni 2025</div>
                </div>
              </div>
            </div>
          </div>

          {{-- Quick Links --}}
          <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
              <h2 class="text-xl font-semibold text-white">Akses Cepat</h2>
            </div>
            <div class="p-6 space-y-3">
              <a href="{{ route('asesor.dokumen-institusi') }}"
                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <span class="text-sm font-medium text-gray-700">Dokumen Institusi</span>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
              <a href="{{ route('asesor.dokumen-fakultas') }}"
                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <span class="text-sm font-medium text-gray-700">Dokumen Fakultas</span>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
              <a href="{{ route('asesor.dokumen-prodi') }}"
                class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors">
                <span class="text-sm font-medium text-gray-700">Dokumen Program Studi</span>
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Chart/Statistics Section --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-12">
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Statistik Dokumen per Kategori</h2>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
              $categories = [
                  ['name' => 'Kebijakan Mutu', 'count' => 12, 'color' => 'blue'],
                  ['name' => 'Standar Mutu', 'count' => 8, 'color' => 'indigo'],
                  ['name' => 'Laporan AMI', 'count' => 15, 'color' => 'purple'],
                  ['name' => 'Evaluasi Diri', 'count' => 6, 'color' => 'pink'],
              ];
            @endphp
            @foreach ($categories as $cat)
              <div class="text-center">
                <div class="relative inline-flex items-center justify-center w-20 h-20 mb-3">
                  <svg class="transform -rotate-90 w-20 h-20">
                    <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-width="8"
                      fill="none" class="text-gray-200"></circle>
                    <circle cx="40" cy="40" r="36" stroke="currentColor" stroke-width="8"
                      fill="none" class="text-{{ $cat['color'] }}-600"
                      stroke-dasharray="{{ 226.2 * ($cat['count'] / 20) }} 226.2" stroke-linecap="round"></circle>
                  </svg>
                  <span class="absolute text-xl font-semibold text-gray-700">{{ $cat['count'] }}</span>
                </div>
                <h3 class="text-sm font-medium text-gray-900">{{ $cat['name'] }}</h3>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    // Add any interactive features here
  </script>
@endpush
