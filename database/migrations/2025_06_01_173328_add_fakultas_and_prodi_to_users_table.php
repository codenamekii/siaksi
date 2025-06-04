<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Tambahkan kolom fakultas_id, program_studi_id, dan lainnya ke tabel users.
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      // Tambahkan foreign key ke fakultas
      if (!Schema::hasColumn('users', 'fakultas_id')) {
        $table->foreignId('fakultas_id')
          ->nullable()
          ->after('role')
          ->constrained('fakultas')
          ->onDelete('set null');
      }

      // Tambahkan foreign key ke program_studi
      if (!Schema::hasColumn('users', 'program_studi_id')) {
        $table->foreignId('program_studi_id')
          ->nullable()
          ->after('fakultas_id')
          ->constrained('program_studi')
          ->onDelete('set null');
      }

      // Kolom login terakhir
      if (!Schema::hasColumn('users', 'last_login_at')) {
        $table->timestamp('last_login_at')->nullable()->after('is_active');
      }

      // Ganti kolom avatar menjadi avatar_url
      if (Schema::hasColumn('users', 'avatar') && !Schema::hasColumn('users', 'avatar_url')) {
        $table->renameColumn('avatar', 'avatar_url');
      } elseif (!Schema::hasColumn('users', 'avatar_url')) {
        $table->string('avatar_url')->nullable()->after('phone');
      }

      // Index tambahan
      $table->index('fakultas_id');
      $table->index('program_studi_id');
      $table->index('role');
    });
  }

  /**
   * Hapus perubahan jika dilakukan rollback.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      // Hapus foreign key sebelum hapus kolom atau index
      if (Schema::hasColumn('users', 'fakultas_id')) {
        $table->dropForeign(['fakultas_id']);
        $table->dropIndex(['fakultas_id']);
        $table->dropColumn('fakultas_id');
      }

      if (Schema::hasColumn('users', 'program_studi_id')) {
        $table->dropForeign(['program_studi_id']);
        $table->dropIndex(['program_studi_id']);
        $table->dropColumn('program_studi_id');
      }

      if (Schema::hasColumn('users', 'last_login_at')) {
        $table->dropColumn('last_login_at');
      }

      if (Schema::hasColumn('users', 'avatar_url')) {
        $table->dropColumn('avatar_url');
      }

      if (Schema::hasColumn('users', 'role')) {
        $table->dropIndex(['role']);
      }
    });
  }
};
