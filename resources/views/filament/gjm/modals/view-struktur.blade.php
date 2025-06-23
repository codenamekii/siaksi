{{-- Lokasi file: resources/views/filament/gjm/modals/view-struktur.blade.php --}}

<div class="p-4">
  <div class="text-center mb-4">
    <h3 class="text-lg font-semibold text-gray-900">{{ $record->nama }}</h3>
    @if ($record->periode)
      <p class="text-sm text-gray-600">Periode: {{ $record->periode }}</p>
    @endif
    @if ($record->deskripsi)
      <p class="text-sm text-gray-500 mt-2">{{ $record->deskripsi }}</p>
    @endif
  </div>

  <div class="bg-gray-50 rounded-lg p-4">
    @if ($record->tipe === 'image')
      <img src="{{ asset('storage/' . $record->file_path) }}" alt="{{ $record->nama }}"
        class="w-full h-auto rounded-lg shadow-lg">
    @elseif($record->tipe === 'pdf')
      <div class="bg-white rounded-lg p-8 text-center">
        {{-- <svg class="mx-auto h-16 w-16 text-red-500 mb-4" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-5L9 2H4z"
            clip-rule="evenodd" />
        </svg> --}}
        <p class="text-gray-700 mb-4">File PDF tidak dapat ditampilkan di sini.</p>
        <a href="{{ asset('storage/' . $record->file_path) }}" target="_blank"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
          </svg>
          Buka PDF di Tab Baru
        </a>
      </div>
    @endif
  </div>

  <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
    <span>Diupload: {{ $record->created_at->format('d M Y H:i') }}</span>
    <span class="flex items-center">
      <span
        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $record->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
        {{ $record->is_active ? 'Aktif' : 'Nonaktif' }}
      </span>
    </span>
  </div>
</div>
