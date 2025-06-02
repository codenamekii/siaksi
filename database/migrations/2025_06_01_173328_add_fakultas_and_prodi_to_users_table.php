<?php

// Lokasi file: database/migrations/2025_06_02_000001_add_fakultas_and_prodi_to_users_table.php

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
    Schema::table('users', function (Blueprint $table) {
      // Add fakultas_id column
      $table->foreignId('fakultas_id')
        ->nullable()
        ->after('role')
        ->constrained('fakultas')
        ->onDelete('set null');

      // Add program_studi_id column
      $table->foreignId('program_studi_id')
        ->nullable()
        ->after('fakultas_id')
        ->constrained('program_studi')
        ->onDelete('set null');

      // Add last_login_at column if not exists
      if (!Schema::hasColumn('users', 'last_login_at')) {
        $table->timestamp('last_login_at')->nullable()->after('is_active');
      }

      // Add avatar_url column if not exists (rename from avatar)
      if (Schema::hasColumn('users', 'avatar') && !Schema::hasColumn('users', 'avatar_url')) {
        $table->renameColumn('avatar', 'avatar_url');
      } elseif (!Schema::hasColumn('users', 'avatar_url')) {
        $table->string('avatar_url')->nullable()->after('phone');
      }

      // Add indexes for better performance
      $table->index('fakultas_id');
      $table->index('program_studi_id');
      $table->index('role');
    });

    // Update existing users with appropriate fakultas/prodi
    $this->updateExistingUsers();
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      // Drop indexes first
      $table->dropIndex(['fakultas_id']);
      $table->dropIndex(['program_studi_id']);
      $table->dropIndex(['role']);

      // Drop foreign keys
      $table->dropForeign(['fakultas_id']);
      $table->dropForeign(['program_studi_id']);

      // Drop columns
      $table->dropColumn(['fakultas_id', 'program_studi_id']);

      if (Schema::hasColumn('users', 'last_login_at')) {
        $table->dropColumn('last_login_at');
      }

      // Rename avatar_url back to avatar if needed
      if (Schema::hasColumn('users', 'avatar_url')) {
        $table->renameColumn('avatar_url', 'avatar');
      }
    });
  }

  /**
   * Update existing users with fakultas/prodi relationships
   */
  private function updateExistingUsers(): void
  {
    // Get first fakultas for GJM users
    $fakultas = \App\Models\Fakultas::first();
    if ($fakultas) {
      \App\Models\User::where('role', 'gjm')
        ->whereNull('fakultas_id')
        ->update(['fakultas_id' => $fakultas->id]);
    }

    // Assign UJM users to program studi based on their email
    $prodiMapping = [
      'ujm.tf@fakultas.ac.id' => 'Teknik Fisika',
      'ujm.ti@fakultas.ac.id' => 'Teknik Informatika',
      'ujm.tm@fakultas.ac.id' => 'Teknik Mesin',
      'ujm.te@fakultas.ac.id' => 'Teknik Elektro',
      'ujm.ts@fakultas.ac.id' => 'Teknik Sipil',
    ];

    foreach ($prodiMapping as $email => $prodiName) {
      $user = \App\Models\User::where('email', $email)->first();
      $prodi = \App\Models\ProgramStudi::where('nama', 'like', '%' . $prodiName . '%')->first();

      if ($user && $prodi) {
        $user->update([
          'program_studi_id' => $prodi->id,
          'fakultas_id' => $prodi->fakultas_id
        ]);
      }
    }
  }
};