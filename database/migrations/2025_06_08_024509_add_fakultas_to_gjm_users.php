<?php
// Lokasi file: database/migrations/2025_06_08_add_fakultas_to_gjm_users.php

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
    // Only add if column doesn't exist
    if (!Schema::hasColumn('users', 'fakultas_id')) {
      Schema::table('users', function (Blueprint $table) {
        $table->foreignId('fakultas_id')->nullable()->after('role')->constrained('fakultas')->onDelete('set null');
      });
    }
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropForeign(['fakultas_id']);
      $table->dropColumn('fakultas_id');
    });
  }
};