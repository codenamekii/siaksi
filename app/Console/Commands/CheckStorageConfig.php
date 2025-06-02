<?php

// Lokasi file: app/Console/Commands/CheckStorageConfig.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\StrukturOrganisasi;

class CheckStorageConfig extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'storage:check-config {--fix : Attempt to fix issues}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check storage configuration and image paths';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info('Checking storage configuration...');
    $this->newLine();

    // Check storage link
    $this->checkStorageLink();

    // Check disk configuration
    $this->checkDiskConfig();

    // Check struktur organisasi images
    $this->checkStrukturOrganisasiImages();

    // Fix option
    if ($this->option('fix')) {
      $this->fixIssues();
    }

    return Command::SUCCESS;
  }

  private function checkStorageLink()
  {
    $this->info('1. Checking storage link...');

    $publicPath = public_path('storage');
    $storagePath = storage_path('app/public');

    if (is_link($publicPath)) {
      $this->line('   ✅ Storage link exists');
      $linkTarget = readlink($publicPath);
      $this->line('   Link: ' . $publicPath . ' -> ' . $linkTarget);
    } else {
      $this->error('   ❌ Storage link does not exist!');
      $this->warn('   Run: php artisan storage:link');
    }

    $this->newLine();
  }

  private function checkDiskConfig()
  {
    $this->info('2. Checking disk configuration...');

    $publicDisk = config('filesystems.disks.public');

    $this->line('   Driver: ' . $publicDisk['driver']);
    $this->line('   Root: ' . $publicDisk['root']);
    $this->line('   URL: ' . $publicDisk['url']);
    $this->line('   Visibility: ' . $publicDisk['visibility']);

    // Check if directories exist
    $strukturDir = Storage::disk('public')->path('struktur');
    if (is_dir($strukturDir)) {
      $this->line('   ✅ Struktur directory exists: ' . $strukturDir);
    } else {
      $this->warn('   ⚠️ Struktur directory does not exist: ' . $strukturDir);
    }

    $this->newLine();
  }

  private function checkStrukturOrganisasiImages()
  {
    $this->info('3. Checking struktur organisasi images...');

    $structures = StrukturOrganisasi::all();

    if ($structures->isEmpty()) {
      $this->line('   No struktur organisasi records found');
      return;
    }

    foreach ($structures as $struktur) {
      $this->line('   Record ID: ' . $struktur->id);
      $this->line('   Title: ' . $struktur->judul);
      $this->line('   Path in DB: ' . $struktur->gambar);

      if ($struktur->gambar) {
        // Check if file exists
        $exists = Storage::disk('public')->exists($struktur->gambar);

        if ($exists) {
          $this->line('   ✅ File exists in storage');
          $this->line('   URL: ' . asset('storage/' . $struktur->gambar));
        } else {
          $this->error('   ❌ File NOT found in storage!');

          // Check alternative paths
          $alternativePaths = [
            'struktur/prodi/' . basename($struktur->gambar),
            basename($struktur->gambar),
          ];

          foreach ($alternativePaths as $altPath) {
            if (Storage::disk('public')->exists($altPath)) {
              $this->warn('   Found at alternative path: ' . $altPath);
              break;
            }
          }
        }

        // Check actual file path
        $fullPath = Storage::disk('public')->path($struktur->gambar);
        $this->line('   Full path: ' . $fullPath);
        $this->line('   File exists on disk: ' . (file_exists($fullPath) ? 'Yes' : 'No'));
      } else {
        $this->warn('   No image path in database');
      }

      $this->line('   ---');
    }

    $this->newLine();
  }

  private function fixIssues()
  {
    $this->info('Attempting to fix issues...');
    $this->newLine();

    // Create storage link if missing
    if (!is_link(public_path('storage'))) {
      $this->call('storage:link');
    }

    // Create directories
    $directories = [
      'struktur',
      'struktur/prodi',
      'struktur/fakultas',
    ];

    foreach ($directories as $dir) {
      if (!Storage::disk('public')->exists($dir)) {
        Storage::disk('public')->makeDirectory($dir);
        $this->info('Created directory: ' . $dir);
      }
    }

    // Set permissions
    $storagePath = storage_path('app/public');
    if (is_dir($storagePath)) {
      chmod($storagePath, 0775);
      $this->info('Set permissions for: ' . $storagePath);
    }

    $this->newLine();
    $this->info('Fix attempts completed. Re-run without --fix to check status.');
  }
}

/**
 * CARA PENGGUNAAN:
 * 
 * 1. Check configuration:
 *    php artisan storage:check-config
 * 
 * 2. Check and attempt fixes:
 *    php artisan storage:check-config --fix
 * 
 * Command ini akan:
 * - Check storage link
 * - Check disk configuration
 * - Check semua file gambar struktur organisasi
 * - Attempt fixes jika menggunakan --fix option
 */
