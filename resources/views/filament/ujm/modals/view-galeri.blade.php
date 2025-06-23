?>
<div class="p-4">
  <div class="space-y-4">
    @if ($record->tipe === 'foto')
      <div class="text-center">
        <img src="{{ asset('storage/' . $record->file_path) }}" alt="{{ $record->judul }}"
          class="max-w-full h-auto rounded-lg shadow-lg mx-auto">
      </div>
    @else
      <div class="aspect-w-16 aspect-h-9">
        @if (str_contains($record->video_url, 'youtube.com'))
          @php
            preg_match(
                '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                $record->video_url,
                $matches,
            );
            $videoId = $matches[1] ?? '';
          @endphp
          <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen class="w-full h-full rounded-lg">
          </iframe>
        @else
          <div class="bg-gray-100 rounded-lg p-8 text-center">
            <p class="text-gray-600">Video URL: {{ $record->video_url }}</p>
          </div>
        @endif
      </div>
    @endif

    <div class="border-t pt-4">
      <h3 class="font-semibold text-lg mb-2">{{ $record->judul }}</h3>

      @if ($record->deskripsi)
        <p class="text-gray-600 mb-4">{{ $record->deskripsi }}</p>
      @endif

      <div class="flex items-center justify-between text-sm text-gray-500">
        <span>📅 Tanggal Kegiatan: {{ $record->tanggal_kegiatan->format('d F Y') }}</span>
        <span>📤 Diupload: {{ $record->created_at->format('d F Y') }}</span>
      </div>
    </div>
  </div>
</div>
