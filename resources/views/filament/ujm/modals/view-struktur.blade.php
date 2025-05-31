?>
<div class="p-4">
  <div class="text-center">
    <img src="{{ asset('storage/' . $record->gambar) }}" alt="{{ $record->judul }}"
      class="max-w-full h-auto rounded-lg shadow-lg mx-auto">
  </div>
  @if ($record->deskripsi)
    <div class="mt-4">
      <p class="text-gray-600 text-center">{{ $record->deskripsi }}</p>
    </div>
  @endif
  <div class="mt-4 text-center text-sm text-gray-500">
    Diupload pada: {{ $record->created_at->format('d F Y') }}
  </div>
</div>
