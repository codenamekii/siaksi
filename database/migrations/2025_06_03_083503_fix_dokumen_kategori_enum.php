<?php

// Lokasi file: database/migrations/2025_06_03_000001_fix_dokumen_kategori_enum.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Update kategori ENUM to include all required values
    DB::statement("ALTER TABLE dokumen MODIFY COLUMN kategori ENUM(
            'kebijakan_mutu',
            'standar_mutu',
            'prosedur',
            'instrumen',
            'laporan_ami',
            'laporan_survei',
            'evaluasi_diri',
            'lkps',
            'sertifikat_akreditasi',
            'kurikulum',
            'data_pendukung',
            'rencana_strategis',
            'dokumentasi_kegiatan',
            'analisis_capaian',
            'rencana_tindak_lanjut',
            'laporan_kinerja'
        )");

    $this->info('✅ Updated kategori ENUM successfully');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Revert to original ENUM values (adjust as needed)
    DB::statement("ALTER TABLE dokumen MODIFY COLUMN kategori ENUM(
            'kebijakan_mutu',
            'standar_mutu',
            'prosedur',
            'instrumen',
            'laporan_ami',
            'laporan_survei',
            'evaluasi_diri',
            'lkps',
            'sertifikat_akreditasi',
            'kurikulum',
            'data_pendukung',
            'rencana_strategis',
            'dokumentasi_kegiatan'
        )");
  }

  private function info($message)
  {
    echo $message . PHP_EOL;
  }
};

/**
 * CARA MENJALANKAN:
 * 
 * 1. Simpan file ini di: database/migrations/2025_06_03_000001_fix_dokumen_kategori_enum.php
 * 
 * 2. Jalankan migration:
 *    php artisan migrate
 * 
 * Atau jalankan SQL langsung:
 * 
 * ALTER TABLE dokumen MODIFY COLUMN kategori ENUM(
 *     'kebijakan_mutu',
 *     'standar_mutu',
 *     'prosedur',
 *     'instrumen',
 *     'laporan_ami',
 *     'laporan_survei',
 *     'evaluasi_diri',
 *     'lkps',
 *     'sertifikat_akreditasi',
 *     'kurikulum',
 *     'data_pendukung',
 *     'rencana_strategis',
 *     'dokumentasi_kegiatan',
 *     'analisis_capaian',
 *     'rencana_tindak_lanjut',
 *     'laporan_kinerja'
 * );
 */
