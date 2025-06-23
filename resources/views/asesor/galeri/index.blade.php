@extends('layouts.asesor')

@section('content')
  <div class="min-h-screen bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Galeri Kegiatan</h1>
        <p class="mt-2 text-gray-600">Dokumentasi kegiatan dan fasilitas</p>
      </div>

      <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select id="kategori-filter" onchange="applyFilters()"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="all">Semua Kategori</option>
              @foreach ($categories as $key => $label)
                <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                  {{ $label }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="flex items-end">
            <button onclick="resetFilters()"
              class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors">
              Reset Filter
            </button>
          </div>
        </div>
      </div>

      @if ($galeri->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          @foreach ($galeri as $item)
            <div
              class="group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
              <a href="{{ route('asesor.galeri.detail', $item->id) }}" class="block">
                <div class="aspect-w-4 aspect-h-3 overflow-hidden bg-gray-100">
                  @php
                    $hasImage = false;
                    $imageUrl = '';

                    if (!empty($item->gambar)) {
                        $imagePath = is_array($item->gambar) ? $item->gambar['path'] ?? '' : $item->gambar;

                        if (is_string($imagePath)) {
                            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                $hasImage = true;
                                $imageUrl = $imagePath;
                            } else {
                                if (str_starts_with($imagePath, 'storage/')) {
                                    $imagePath = substr($imagePath, 8);
                                }

                                if (file_exists(storage_path('app/public/' . $imagePath))) {
                                    $hasImage = true;
                                    $imageUrl = asset('storage/' . $imagePath);
                                }
                            }
                        }
                    }

                    if (!$hasImage && method_exists($item, 'getGambarUrlAttribute')) {
                        $accessorUrl = $item->gambar_url;
                        if (!empty($accessorUrl)) {
                            $hasImage = true;
                            $imageUrl = $accessorUrl;
                        }
                    }
                  @endphp

                  @if ($hasImage)
                    <img src="{{ $imageUrl }}" alt="{{ $item->judul }}"
                      class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                      onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-64 bg-gray-200 flex items-center justify-center\'><svg class=\'w-12 h-12 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>';">
                  @else
                    <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                      <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                      </svg>
                    </div>
                  @endif

                  <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div
                      class="absolute bottom-0 left-0 right-0 p-4 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                      <p class="text-xs font-medium mb-1">{{ ucfirst($item->kategori) }}</p>
                      <h3 class="font-semibold text-sm line-clamp-2">{{ $item->judul }}</h3>
                      @if ($item->tanggal_kegiatan)
                        <p class="text-xs mt-1 opacity-90">
                          {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}
                        </p>
                      @endif
                    </div>
                  </div>
                </div>
              </a>

              <div class="absolute top-2 right-2">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $item->kategori == 'kegiatan' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $item->kategori == 'prestasi' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $item->kategori == 'fasilitas' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $item->kategori == 'lainnya' ? 'bg-gray-100 text-gray-800' : '' }}">
                  {{ ucfirst($item->kategori) }}
                </span>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-8">
          {{ $galeri->withQueryString()->links() }}
        </div>
      @else
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
            </path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada galeri</h3>
          <p class="mt-1 text-sm text-gray-500">Belum ada galeri yang tersedia.</p>
        </div>
      @endif
    </div>
  </div>

  @push('scripts')
    <script>
      function applyFilters() {
        const kategori = document.getElementById('kategori-filter').value;
        let url = new URL(window.location.href);

        if (kategori && kategori !== 'all') {
          url.searchParams.set('kategori', kategori);
        } else {
          url.searchParams.delete('kategori');
        }

        window.location.href = url.toString();
      }

      function resetFilters() {
        window.location.href = '{{ route('asesor.galeri') }}';
      }
    </script>
  @endpush
@endsection
