<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('akreditasi_prodi', function (Blueprint $table) {
      if (!Schema::hasColumn('akreditasi_prodi', 'tahun_akreditasi')) {
        $table->integer('tahun_akreditasi')->nullable()->after('tanggal_berakhir');
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('akreditasi_prodi', function (Blueprint $table) {
      $table->dropColumn('tahun_akreditasi');
    });
  }
};