{{-- Lokasi file: resources/views/asesor/berita/index.blade.php --}}

@extends('layouts.asesor')

@section('title', 'Berita & Pengumuman')

@section('content')
  <!-- Page Header -->
  <div class="py-12">
    <section class="bg-gradient-to-br from-gray-900 to-gray-800 text-black py-4">
      <div class="max-w-7xl mt-8 mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl font-bold mb-4">Berita & Pengumuman</h1>
          <p class="text-xl text-gray-600">Informasi terkini seputar akreditasi dan penjaminan mutu</p>
        </div>
      </div>
    </section>
  </div>

  <!-- Filter and Search Section -->
  <section class="bg-white shadow-sm sticky top-20 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <!-- Filter Buttons -->
        <div class="flex space-x-2 gap-2">
          <a href="{{ route('asesor.berita.index', ['kategori' => 'semua']) }}" 
            class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ $kategori === 'semua' ? 'bg-blue-600 text-black shadow-lg' : 'bg-gray-500 text-black hover:bg-gray-700' }}">
            Semua
          </a>
          <a href="{{ route('asesor.berita.index', ['kategori' => 'berita']) }}" 
            class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ $kategori === 'berita' ? 'bg-blue-600 text-black shadow-lg' : 'bg-gray-500 text-black hover:bg-gray-700' }}">
            Berita
          </a>
          <a href="{{ route('asesor.berita.index', ['kategori' => 'pengumuman']) }}" 
            class="px-4 py-2 rounded-lg font-medium transition-all duration-300 {{ $kategori === 'pengumuman' ? 'bg-blue-600 text-black shadow-lg' : 'bg-gray-500 text-black hover:bg-gray-700' }}">
            Pengumuman
          </a>
        </div>

        <!-- Search Form -->
        {{-- <form method="GET" action="{{ route('asesor.berita.index') }}" class="flex items-center">
          <input type="hidden" name="kategori" value="{{ $kategori }}">
          <div class="relative">
            <input type="text" name="search" value="{{ $search }}" 
              placeholder="Cari berita atau pengumuman..." 
              class="pl-10 pr-4 py-2 w-64 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Cari
          </button>
        </form> --}}
      </div>
    </div>
  </section>

  <!-- Articles Grid -->
  <section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      @if($berita->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 rounded-md">
          @foreach($berita as $item)
            <article class="bg-white rounded-md shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
              @if($item->getFirstMediaUrl('gambar'))
                <div class="h-48 overflow-hidden">
                  <img src="{{ $item->getFirstMediaUrl('gambar') }}" alt="{{ $item->judul }}" 
                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
              @else
                <div class="h-48 bg-gradient-to-br {{ $item->kategori === 'berita' ? 'from-blue-400 to-blue-600' : 'from-purple-400 to-purple-600' }} flex items-center justify-center">
                  <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($item->kategori === 'berita')
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    @else
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    @endif
                  </svg>
                </div>
              @endif
              
              <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->kategori === 'berita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ ucfirst($item->kategori) }}
                  </span>
                  <time class="text-xs text-gray-500">{{ $item->formatted_published_date }}</time>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                  <a href="{{ route('asesor.berita.detail', $item->slug) }}" class="hover:text-blue-600 transition">
                    {{ $item->judul }}
                  </a>
                </h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $item->excerpt }}</p>
                
                <div class="flex items-center justify-between">
                  <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ $item->user->name }}
                  </div>
                  <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">
                    {{ ucfirst($item->level) }}
                  </span>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-100">
                  <a href="{{ route('asesor.berita.detail', $item->slug) }}" 
                    class="text-blue-600 hover:text-blue-800 font-medium text-sm inline-flex items-center group">
                    Baca Selengkapnya
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                  </a>
                </div>
              </div>
            </article>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
          {{ $berita->withQueryString()->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
          </svg>
          <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada {{ $kategori === 'semua' ? 'berita atau pengumuman' : $kategori }}</h3>
          <p class="mt-1 text-sm text-gray-500">
            @if($search)
              Tidak ditemukan hasil untuk pencarian "{{ $search }}"
            @else
              Belum ada {{ $kategori === 'semua' ? 'berita atau pengumuman' : $kategori }} yang dipublikasikan
            @endif
          </p>
          @if($search)
            <div class="mt-6">
              <a href="{{ route('asesor.berita.index') }}" class="text-blue-600 hover:text-blue-500">
                Hapus pencarian
              </a>
            </div>
          @endif
        </div>
      @endif
    </div>
  </section>
@endsection