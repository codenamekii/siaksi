?>
<div class="p-4">
  <div class="text-center space-y-4">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
          {{ $record->judul }}
      </h3>
      
      @if($record->deskripsi)
          <p class="text-sm text-gray-600 dark:text-gray-400">
              {{ $record->deskripsi }}
          </p>
      @endif
      
      <div class="flex justify-center">
          <img 
              src="{{ Storage::disk('public')->url($record->gambar) }}" 
              alt="{{ $record->judul }}"
              class="max-w-full h-auto rounded-lg shadow-lg"
              style="max-height: 70vh;"
          >
      </div>
      
      <div class="text-xs text-gray-500 dark:text-gray-400">
          Diupload pada: {{ $record->created_at->format('d F Y') }}
      </div>
  </div>
</div>
