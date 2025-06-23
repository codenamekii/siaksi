{{-- Lokasi file: resources/views/asesor/dashboard.blade.php --}}

@extends('layouts.asesor')

@section('content')
  <!-- Hero Section with Background Image -->
  <section class="relative min-h-screen flex items-center"
    style="background-image: linear-gradient(rgba(17, 24, 39, 0.7), rgba(17, 24, 39, 0.7)), url('{{ asset('storage/UIMHero.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/50 to-gray-900"></div>

    <!-- Hero Content -->
    <div class="relative z-10 w-full">
      <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <!-- Left Content -->
          <div class="text-white space-y-8">
            <!-- Welcome Badge -->
            @if (session('gjm_original_user') || session('ujm_original_user'))
              <div
                class="inline-flex items-center px-4 py-2 bg-blue-600/20 backdrop-blur-md rounded-full border border-blue-500/30">
                <svg class="w-4 h-4 mr-2 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm">
                  @if (session('gjm_original_user'))
                    Akses dari Dashboard GJM
                  @else
                    Akses dari Dashboard UJM
                  @endif
                </span>
              </div>
            @endif

            <!-- Main Title -->
            <div>
              <h1 class="text-3xl md:text-6xl font-bold leading-tight">
                Sistem Informasi Dokumen Akreditasi
              </h1>
              <p class="mt-6 text-lg md:text-xl text-gray-300 leading-relaxed">
                Platform terpadu untuk mengelola dan mengakses dokumen akreditasi fakultas Teknik dan program studi
                di Universitas Islam Makassar dengan mudah dan efisien.
              </p>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
              <a href="#features"
                class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-300 shadow-xl">
                Mulai Eksplorasi
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                  </path>
                </svg>
              </a>
              <a href="#statistik"
                class="inline-flex items-center justify-center px-4 py-3 bg-white/10 backdrop-blur-md text-white font-semibold rounded-lg border border-white/30 hover:bg-white/20 transition-all duration-300">
                Lihat Statistik
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                  </path>
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
          <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
          </svg>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-24 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center  mt-6 mb-8">
        <h2 class="text-4xl font-bold text-white mb-4">Akses Dokumen</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-6"></div>
        <p class="text-xl text-gray-700 max-w-2xl mx-auto">
          Akses cepat dan mudah ke berbagai dokumen akreditasi yang Anda butuhkan
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Feature 1 -->
        <a href="{{ route('asesor.dokumen-institusi') }}" class="group">
          <div
            class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 hover:border-blue-500 transform hover:-translate-y-2 transition-all duration-300">
            <div
              class="w-16 h-16 bg-blue-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600/30 transition-colors">
              <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                </path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">Dokumen Institusi</h3>
            <p class="text-gray-400 mb-4">Kebijakan SPMI, standar mutu universitas, dan dokumen payung institusi</p>
            <div class="flex items-center text-blue-400 font-medium group-hover:gap-3 transition-all">
              Akses Dokumen
              <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
              </svg>
            </div>
          </div>
        </a>

        <!-- Feature 2 -->
        <a href="{{ route('asesor.dokumen-fakultas') }}" class="group">
          <div
            class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 hover:border-green-500 transform hover:-translate-y-2 transition-all duration-300">
            <div
              class="w-16 h-16 bg-green-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-green-600/30 transition-colors">
              <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">Dokumen Fakultas</h3>
            <p class="text-gray-400 mb-4">Laporan AMI, rencana strategis, dan dokumen mutu fakultas</p>
            <div class="flex items-center text-green-400 font-medium group-hover:gap-3 transition-all">
              Akses Dokumen
              <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                </path>
              </svg>
            </div>
          </div>
        </a>

        <!-- Feature 3 -->
        <a href="{{ route('asesor.dokumen-prodi') }}" class="group">
          <div
            class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 hover:border-purple-500 transform hover:-translate-y-2 transition-all duration-300">
            <div
              class="w-16 h-16 bg-purple-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600/30 transition-colors">
              <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                </path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">Dokumen Prodi</h3>
            <p class="text-gray-400 mb-4">LKPS, LED, sertifikat akreditasi, dan kurikulum program studi</p>
            <div class="flex items-center text-purple-400 font-medium group-hover:gap-3 transition-all">
              Akses Dokumen
              <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                </path>
              </svg>
            </div>
          </div>
        </a>

        <!-- Feature 4 -->
        <a href="{{ route('asesor.informasi-tambahan') }}" class="group">
          <div
            class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 hover:border-yellow-500 transform hover:-translate-y-2 transition-all duration-300">
            <div
              class="w-16 h-16 bg-yellow-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-yellow-600/30 transition-colors">
              <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-white mb-3">Informasi Tambahan</h3>
            <p class="text-gray-400 mb-4">Data SDM, sarana prasarana, dan informasi pendukung lainnya</p>
            <div class="flex items-center text-yellow-400 font-medium group-hover:gap-3 transition-all">
              Akses Informasi
              <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                </path>
              </svg>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- Statistics Section -->
  <section id="statistik" class="py-24 bg-gradient-to-b from-gray-800 to-gray-900 relative overflow-hidden">
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mt-4 mb-8">
        <h2 class="text-4xl font-bold text-white mb-4">Statistik Akreditasi</h2>
        <div class="w-24 h-1 bg-blue-500 mx-auto mb-6"></div>
        <p class="text-xl text-gray-700 max-w-2xl mx-auto">
          Data real-time tentang status akreditasi dan dokumen dalam sistem
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 items-center">
        <!-- Stat 1 -->
        <div
          class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 text-center transform hover:scale-105 transition-all duration-300">
          <div class="w-20 h-20 bg-blue-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
          </div>
          <p class="text-4xl font-bold text-white mb-2">{{ $totalDokumen ?? 0 }}</p>
          <p class="text-gray-400">Dokumen Tersedia</p>
        </div>

        <!-- Stat 3 -->
        <div
          class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 text-center transform hover:scale-105 transition-all duration-300">
          <div class="w-20 h-20 bg-purple-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
              </path>
            </svg>
          </div>
          <p class="text-4xl font-bold text-white mb-2">{{ $totalProdi ?? 0 }}</p>
          <p class="text-gray-400">Program Studi Aktif</p>
        </div>

        <!-- Stat 4 -->
        <div
          class="bg-gray-800/50 backdrop-blur-sm rounded-md p-8 border border-gray-700 text-center transform hover:scale-105 transition-all duration-300">
          <div class="w-20 h-20 bg-yellow-600/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
              </path>
            </svg>
          </div>
          <p class="text-4xl font-bold text-white mb-2">{{ $prodiTerakreditasi ?? 0 }}</p>
          <p class="text-gray-400">Prodi Terakreditasi</p>
        </div>
      </div>

      <!-- Akreditasi Status Chart -->
      <div class="bg-gray-800/50 backdrop-blur-sm rounded-md mb-3 mt-3 p-8 border border-gray-700">
        <h3 class="text-2xl font-semibold text-white mb-8 text-center">Status Akreditasi Program Studi</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="relative inline-flex">
              <svg class="w-32 h-32 transform -rotate-90">
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="none"
                  class="text-black-700"></circle>
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="none"
                  stroke-dasharray="377"
                  stroke-dashoffset="{{ 377 - (377 * ($akreditasiUnggul ?? 0)) / max($prodiTerakreditasi, 1) }}"
                  class="text-green-400 transition-all duration-1000"></circle>
              </svg>
              <div class="absolute inset-0 flex items-center justify-center">
                <div>
                  <p class="text-3xl font-bold text-white">{{ $akreditasiUnggul ?? 0 }}</p>
                  <p class="text-sm text-green-400">Unggul</p>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <div class="relative inline-flex">
              <svg class="w-32 h-32 transform -rotate-90">
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="none"
                  class="text-gray-700"></circle>
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="none"
                  stroke-dasharray="377"
                  stroke-dashoffset="{{ 377 - (377 * ($akreditasiBaikSekali ?? 0)) / max($prodiTerakreditasi, 1) }}"
                  class="text-blue-400 transition-all duration-1000"></circle>
              </svg>
              <div class="absolute inset-0 flex items-center justify-center">
                <div>
                  <p class="text-3xl font-bold text-white">{{ $akreditasiBaikSekali ?? 0 }}</p>
                  <p class="text-sm text-blue-400">Baik Sekali</p>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center">
            <div class="relative inline-flex">
              <svg class="w-32 h-32 transform -rotate-90">
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="none"
                  class="text-gray-700"></circle>
                <circle cx="64" cy="64" r="60" stroke="currentColor" stroke-width="8" fill="none"
                  stroke-dasharray="377"
                  stroke-dashoffset="{{ 377 - (377 * ($akreditasiAktif ?? 0)) / max($prodiTerakreditasi, 1) }}"
                  class="text-yellow-400 transition-all duration-1000"></circle>
              </svg>
              <div class="absolute inset-0 flex items-center justify-center">
                <div>
                  <p class="text-3xl font-bold text-white">{{ $akreditasiAktif ?? 0 }}</p>
                  <p class="text-sm text-yellow-400">Aktif</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Visi Misi Section -->
  @include('asesor.partials.visi-misi-section', ['fakultas' => $fakultas ?? null])

  <!-- Include Fakultas Section -->
  @include('asesor.partials.fakultas-section')

  <!-- Include Program Studi Section -->
  @include('asesor.partials.program-studi-section')

  <!-- Include Akreditasi Timeline Section -->
  @include('asesor.partials.berita-pengumuman-section')

  <!-- CTA Section -->
  <section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
      <p class="text-xl mb-8 text-black">
        Akses dokumen akreditasi dan informasi penting lainnya dengan mudah
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('asesor.dokumen-institusi') }}"
          class="inline-flex items-center justify-center px-4 py-3 bg-gray-400 text-blue-600 font-bold rounded-lg hover:bg-gray-700 transform hover:scale-105 transition-all duration-300">
          Mulai Eksplorasi
          <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
          </svg>
        </a>
        <a href="#features"
          class="inline-flex items-center justify-center px-4 py-3 border-2 border-white text-black font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
          Pelajari Lebih Lanjut
        </a>
      </div>
    </div>
  </section>


  <!-- Custom Styles -->
  <style>
    @keyframes blob {
      0% {
        transform: translate(0px, 0px) scale(1);
      }

      33% {
        transform: translate(30px, -50px) scale(1.1);
      }

      66% {
        transform: translate(-20px, 20px) scale(0.9);
      }

      100% {
        transform: translate(0px, 0px) scale(1);
      }
    }

    .animate-blob {
      animation: blob 7s infinite;
    }

    .animation-delay-2000 {
      animation-delay: 2s;
    }

    .animation-delay-4000 {
      animation-delay: 4s;
    }

    .bg-grid-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    @keyframes fade-in-up {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in-up {
      animation: fade-in-up 1s ease-out;
    }
  </style>
@endsection

