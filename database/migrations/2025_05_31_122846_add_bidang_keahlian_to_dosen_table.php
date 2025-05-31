<?php

// 1. database/migrations/2024_01_01_000015_add_bidang_keahlian_to_dosen_table.php
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
    Schema::table('dosen', function (Blueprint $table) {
      $table->string('bidang_keahlian')->nullable()->after('pendidikan_terakhir');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('dosen', function (Blueprint $table) {
      $table->dropColumn('bidang_keahlian');
    });
  }
};
