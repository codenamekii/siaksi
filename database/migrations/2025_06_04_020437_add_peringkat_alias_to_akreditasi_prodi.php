<?php

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
    // Add peringkat column as alias for status_akreditasi
    Schema::table('akreditasi_prodi', function (Blueprint $table) {
      $table->string('peringkat')->nullable()->after('status_akreditasi');
    });

    // Copy data from status_akreditasi to peringkat
    DB::table('akreditasi_prodi')->update([
      'peringkat' => DB::raw('status_akreditasi')
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('akreditasi_prodi', function (Blueprint $table) {
      $table->dropColumn('peringkat');
    });
  }
};