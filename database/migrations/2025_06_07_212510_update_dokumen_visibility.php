<?php
// Lokasi file: database/migrations/2025_06_08_update_dokumen_visibility.php

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
    // Update all existing documents to be visible to asesor by default
    DB::table('dokumen')->update(['is_visible_to_asesor' => true]);

    // Optionally add can_access_asesor column if you want to use it
    if (!Schema::hasColumn('dokumen', 'can_access_asesor')) {
      Schema::table('dokumen', function (Blueprint $table) {
        $table->boolean('can_access_asesor')->default(true)->after('is_visible_to_asesor');
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Revert documents visibility
    DB::table('dokumen')->update(['is_visible_to_asesor' => false]);

    // Remove can_access_asesor column if it was added
    if (Schema::hasColumn('dokumen', 'can_access_asesor')) {
      Schema::table('dokumen', function (Blueprint $table) {
        $table->dropColumn('can_access_asesor');
      });
    }
  }
};
