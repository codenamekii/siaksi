@extends('layouts.asesor')

@section('content')
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Back Button -->
      <div class="mb-6">
        <a href="{{ route('asesor.galeri') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Kembali ke Galeri
        </a>
      </div>

      <!-- Main Content -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Image -->
        <div class="relative">
          @if ($galeri->gambar)
            <img src="{{ $galeri->gambar_url }}" alt="{{ $galeri->judul }}"
              class="w-full h-auto max-h-[600px] object-contain bg-gray-100">
          @else
            <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
              <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
              </svg>
            </div>
          @endif
        </div>

        <!-- Content -->
        <div class="p-6 lg:p-8">
          <div class="mb-4">
            <span
              class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $galeri->kategori == 'kegiatan' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $galeri->kategori == 'prestasi' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $galeri->kategori == 'fasilitas' ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $galeri->kategori == 'lainnya' ? 'bg-gray-100 text-gray-800' : '' }}">
              {{ ucfirst($galeri->kategori) }}
            </span>
          </div>

          <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $galeri->judul }}</h1>

          @if ($galeri->deskripsi)
            <div class="prose max-w-none text-gray-700 mb-6">
              {!! nl2br(e($galeri->deskripsi)) !!}
            </div>
          @endif

          <!-- Meta Information -->
          <div class="border-t pt-6 mt-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              @if ($galeri->tanggal_kegiatan)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Tanggal Kegiatan</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $galeri->tanggal_kegiatan->format('d F Y') }}</dd>
                </div>
              @endif

              <div>
                <dt class="text-sm font-medium text-gray-500">Level</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($galeri->level) }}</dd>
              </div>

              @if ($galeri->programStudi)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $galeri->programStudi->nama }}</dd>
                </div>
              @elseif($galeri->fakultas)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Fakultas</dt>
                  <dd class="mt-1 text-sm text-gray-900">{{ $galeri->fakultas->nama }}</dd>
                </div>
              @endif

              <div>
                <dt class="text-sm font-medium text-gray-500">Ditambahkan pada</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $galeri->created_at->format('d F Y H:i') }}</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>

      <!-- Related Gallery -->
      @if ($relatedGaleri->count() > 0)
        <div class="mt-12">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">Galeri Terkait</h2>

          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($relatedGaleri as $related)
              <a href="{{ route('asesor.galeri.detail', $related->id) }}"
                class="group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all">
                <div class="aspect-w-4 aspect-h-3">
                  @if ($related->gambar)
                    <img src="{{ $related->gambar_url }}" alt="{{ $related->judul }}"
                      class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                  @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                      <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                      </svg>
                    </div>
                  @endif

                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                    <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                      <h3 class="text-sm font-medium line-clamp-2">{{ $related->judul }}</h3>
                    </div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
