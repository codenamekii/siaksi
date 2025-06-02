<?php

return [

  'broadcasting' => [
    // Nonaktifkan broadcasting jika tidak digunakan (default sudah aman)
  ],

  'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

  // Tidak perlu ubah path asset kalau tidak punya kebutuhan khusus
  'assets_path' => null,

  // Aktifkan cache komponen untuk mempercepat loading admin panel
  'cache_path' => base_path('bootstrap/cache/filament'),

  // Tampilkan loading indicator segera agar pengguna sadar proses sedang berjalan
  'livewire_loading_delay' => 'none', // Ganti dari 'default' ke 'none'

];