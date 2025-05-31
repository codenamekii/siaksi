?>
<x-filament-panels::page>
    <div class="mb-6">
        <h2 class="text-2xl font-bold tracking-tight">
            Selamat Datang, {{ auth()->user()->name }}!
        </h2>
        <p class="text-gray-600 mt-1">
            Anda login sebagai Gugus Jaminan Mutu (GJM) Fakultas Teknik
        </p>
    </div>

    {{ $this->getWidgets() }}
</x-filament-panels::page>