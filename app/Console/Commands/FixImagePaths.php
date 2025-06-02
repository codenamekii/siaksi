<?php

// Lokasi file: app/Console/Commands/FixImagePaths.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;

class FixImagePaths extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'fix:image-paths {--dry-run : Show what would be changed without making changes}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fix image paths in struktur_organisasi table';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $dryRun = $this->option('dry-run');

    $this->info('Fixing image paths in struktur_organisasi table...');
    if ($dryRun) {
      $this->warn('DRY RUN MODE - No changes will be made');
    }
    $this->newLine();

    $structures = StrukturOrganisasi::whereNotNull('gambar')->get();
    $fixed = 0;
    $notFound = 0;

    foreach ($structures as $struktur) {
      $this->line('Processing ID: ' . $struktur->id . ' - ' . $struktur->judul);
      $this->line('Current path: ' . $struktur->gambar);

      $needsFix = false;
      $newPath = $struktur->gambar;

      // Remove /storage/ prefix if exists
      if (str_starts_with($newPath, '/storage/')) {
        $newPath = str_replace('/storage/', '', $newPath);
        $needsFix = true;
        $this->warn('  - Removing /storage/ prefix');
      }

      // Remove storage/ prefix if exists
      if (str_starts_with($newPath, 'storage/')) {
        $newPath = str_replace('storage/', '', $newPath);
        $needsFix = true;
        $this->warn('  - Removing storage/ prefix');
      }

      // Check if file exists with current path
      if (!Storage::disk('public')->exists($newPath)) {
        $this->error('  - File not found at: ' . $newPath);

        // Try to find the file
        $filename = basename($newPath);
        $possiblePaths = [
          'struktur/prodi/' . $filename,
          'struktur/' . $filename,
          $filename,
        ];

        $found = false;
        foreach ($possiblePaths as $path) {
          if (Storage::disk('public')->exists($path)) {
            $this->info('  - Found at: ' . $path);
            $newPath = $path;
            $needsFix = true;
            $found = true;
            break;
          }
        }

        if (!$found) {
          $notFound++;
          $this->error('  - File not found in any location!');

          // List files in struktur directory for debugging
          $files = Storage::disk('public')->files('struktur', true);
          if (!empty($files)) {
            $this->info('  - Files in struktur directory:');
            foreach ($files as $file) {
              if (str_contains($file, $filename)) {
                $this->line('    * ' . $file);
              }
            }
          }
        }
      } else {
        $this->info('  - File exists at current path');
      }

      if ($needsFix) {
        if (!$dryRun) {
          $struktur->gambar = $newPath;
          $struktur->save();
          $this->info('  ✅ Updated to: ' . $newPath);
        } else {
          $this->info('  Would update to: ' . $newPath);
        }
        $fixed++;
      } else {
        $this->info('  ✅ Path is correct');
      }

      $this->line('  ---');
    }

    $this->newLine();
    $this->info('Summary:');
    $this->line('Total records: ' . $structures->count());
    $this->line('Fixed: ' . $fixed);
    $this->line('Not found: ' . $notFound);

    if ($dryRun && $fixed > 0) {
      $this->newLine();
      $this->warn('Run without --dry-run to apply changes');
    }

    return Command::SUCCESS;
  }
}

/**
 * CARA PENGGUNAAN:
 * 
 * 1. Dry run (lihat apa yang akan diubah):
 *    php artisan fix:image-paths --dry-run
 * 
 * 2. Fix paths:
 *    php artisan fix:image-paths
 * 
 * Command ini akan:
 * - Remove /storage/ prefix dari path
 * - Cari file jika path salah
 * - Update path di database
 * - Report files yang tidak ditemukan
 */
