{{-- Lokasi file: resources/views/asesor/berita/detail.blade.php --}}

@extends('layouts.asesor')

@section('title', $berita->judul)

@section('content')
  <!-- Article Header -->
  <div class="relative py-16">
    <section class="relative bg-gradient-to-br from-gray-900 to-gray-800 text-white">
      <div class="absolute inset-0 bg-black/50"></div>
      @if($berita->getFirstMediaUrl('gambar'))
        <div class="absolute inset-0">
          <img src="{{ $berita->getFirstMediaUrl('gambar') }}" alt="{{ $berita->judul }}" 
            class="w-full h-full object-cover opacity-30">
        </div>
      @endif
      
      <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <!-- Breadcrumb -->
        <nav class="mb-3 mt-3">
          <ol class="flex items-center space-x-2 text-sm">
            <li>
              <a href="{{ route('asesor.dashboard') }}" class="text-gray-300 hover:text-white transition">
                Beranda
              </a>
            </li>
            <li class="text-gray-500">/</li>
            <li>
              <a href="{{ route('asesor.berita.index') }}" class="text-gray-300 hover:text-white transition">
                Berita & Pengumuman
              </a>
            </li>
            <li class="text-gray-500">/</li>
            <li class="text-gray-400">{{ Str::limit($berita->judul, 30) }}</li>
          </ol>
        </nav>

        <!-- Article Meta -->
        <div class="flex items-center space-x-4 mb-6">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $berita->kategori === 'berita' ? 'bg-blue-100 text-black' : 'bg-purple-100 text-black' }}">
            {{ ucfirst($berita->kategori) }}
          </span>
          <span class="text-sm text-gray-300">{{ $berita->formatted_published_date }}</span>
          <span class="text-sm text-gray-300">{{ $berita->level === 'fakultas' ? 'Fakultas' : 'Program Studi' }}</span>
        </div>

        <!-- Title -->
        <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">{{ $berita->judul }}</h1>

        <!-- Author Info -->
        <div class="flex items-center space-x-4">
          {{-- <div class="h-12 w-12 rounded-full relative bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
            <span class="text-white font-bold text-lg">{{ substr($berita->user->name, 0, 1) }}</span>
          </div> --}}
          <div>
            <p class="font-medium">{{ $berita->user->name }}</p>
            <p class="text-sm text-gray-300">
              @if($berita->level === 'prodi' && $berita->programStudi)
                {{ $berita->programStudi->nama }} - {{ $berita->programStudi->fakultas->nama }}
              @elseif($berita->fakultas)
                {{ $berita->fakultas->nama }}
              @endif
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Article Content -->
  <section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="prose prose-lg max-w-none">
        {!! $berita->konten !!}
      </div>

      <!-- Share Buttons -->
      <div class="mt-12 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan artikel ini:</h3>
        <div class="flex space-x-4">
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            Facebook
          </a>
          <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
            Twitter
          </a>
          <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            WhatsApp
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Related Articles -->
  @if($relatedBerita->count() > 0)
    <section class="py-12 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ ucfirst($berita->kategori) }} Terkait</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          @foreach($relatedBerita as $related)
            <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
              @if($related->getFirstMediaUrl('gambar'))
                <div class="h-48 overflow-hidden">
                  <img src="{{ $related->getFirstMediaUrl('gambar') }}" alt="{{ $related->judul }}" 
                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
              @else
                <div class="h-48 bg-gradient-to-br {{ $related->kategori === 'berita' ? 'from-blue-400 to-blue-600' : 'from-purple-400 to-purple-600' }} flex items-center justify-center">
                  <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($related->kategori === 'berita')
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    @else
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    @endif
                  </svg>
                </div>
              @endif
              
              <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $related->kategori === 'berita' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ ucfirst($related->kategori) }}
                  </span>
                  <time class="text-xs text-gray-500">{{ $related->formatted_published_date }}</time>
                </div>
                
                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                  <a href="{{ route('asesor.berita.detail', $related->slug) }}" class="hover:text-blue-600 transition">
                    {{ $related->judul }}
                  </a>
                </h3>
                <p class="text-gray-600 text-sm line-clamp-3">{{ $related->excerpt }}</p>
              </div>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endsection