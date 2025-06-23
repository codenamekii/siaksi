@if (session('gjm_original_user') || session('ujm_original_user'))
    <div class="fi-dropdown">
        <x-filament::button
            color="info"
            icon="heroicon-o-arrow-left"
            {{-- href="{{ route('return.to.original') }}" --}}
            tag="a"
            size="sm"
        >
            @if (session('gjm_original_user'))
                Kembali ke GJM
            @else
                Kembali ke UJM
            @endif
        </x-filament::button>
    </div>
@endif