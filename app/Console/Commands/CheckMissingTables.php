<?php

// Lokasi file: app/Console/Commands/CheckMissingTables.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckMissingTables extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'db:check-missing';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check for missing Laravel/Filament required tables';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info('Checking for missing required tables...');
    $this->newLine();

    $requiredTables = [
      // Laravel default tables
      'users' => 'User authentication',
      'password_reset_tokens' => 'Password reset functionality',
      'sessions' => 'Session management',
      'cache' => 'Cache storage',
      'jobs' => 'Queue jobs',
      'failed_jobs' => 'Failed queue jobs',
      'notifications' => 'Database notifications',
      'personal_access_tokens' => 'API tokens (Sanctum)',

      // SIAKSI specific tables
      'fakultas' => 'Fakultas data',
      'program_studi' => 'Program Studi data',
      'berita' => 'Berita/Pengumuman',
      'dokumen' => 'Document management',
      'akreditasi_prodi' => 'Akreditasi data',
      'jadwal_ami' => 'AMI schedules',
      'tim_gjm' => 'GJM team members',
      'tim_ujm' => 'UJM team members',
      'dosen' => 'Dosen data',
      'tenaga_kependidikan' => 'Staff data',
      'galeri_kegiatan' => 'Activity gallery',
      'struktur_organisasi' => 'Organization structure',
      'tautan_cepat' => 'Quick links',

      // Spatie Media Library
      'media' => 'Media files (Spatie)',

      // Spatie Permission (if used)
      'permissions' => 'Permissions',
      'roles' => 'Roles',
      'model_has_permissions' => 'User permissions',
      'model_has_roles' => 'User roles',
      'role_has_permissions' => 'Role permissions',
    ];

    $missingTables = [];
    $existingTables = [];

    foreach ($requiredTables as $table => $description) {
      if (Schema::hasTable($table)) {
        $existingTables[$table] = $description;
      } else {
        $missingTables[$table] = $description;
      }
    }

    // Display existing tables
    if (count($existingTables) > 0) {
      $this->info('✅ Existing Tables:');
      foreach ($existingTables as $table => $description) {
        $this->line("   - {$table}: {$description}");
      }
    }

    $this->newLine();

    // Display missing tables
    if (count($missingTables) > 0) {
      $this->error('❌ Missing Tables:');
      foreach ($missingTables as $table => $description) {
        $this->line("   - {$table}: {$description}");
      }

      $this->newLine();
      $this->warn('To create missing Laravel default tables, run:');

      if (isset($missingTables['notifications'])) {
        $this->line('   php artisan notifications:table');
      }
      if (isset($missingTables['cache'])) {
        $this->line('   php artisan cache:table');
      }
      if (isset($missingTables['jobs']) || isset($missingTables['failed_jobs'])) {
        $this->line('   php artisan queue:table');
        $this->line('   php artisan queue:failed-table');
      }
      if (isset($missingTables['personal_access_tokens'])) {
        $this->line('   php artisan vendor:publish --tag=sanctum-migrations');
      }

      $this->newLine();
      $this->info('Then run: php artisan migrate');
    } else {
      $this->info('✅ All required tables exist!');
    }

    return Command::SUCCESS;
  }
}

/**
 * CARA PENGGUNAAN:
 * 
 * 1. Simpan file ini di: app/Console/Commands/CheckMissingTables.php
 * 
 * 2. Jalankan command:
 *    php artisan db:check-missing
 * 
 * Command ini akan:
 * - Check semua tabel yang diperlukan
 * - Menampilkan tabel yang ada dan yang missing
 * - Memberikan command untuk create missing tables
 */
