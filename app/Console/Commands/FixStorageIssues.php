<?php

// Lokasi file: app/Console/Commands/FixStorageIssues.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StrukturOrganisasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FixStorageIssues extends Command
{
  protected $signature = 'storage:fix-all {--force : Force fix without confirmation}';
  protected $description = 'Fix all storage related issues for struktur organisasi';

  public function handle()
  {
    $this->info('🔧 SIAKSI Storage Fix Tool');
    $this->info('==========================');
    $this->newLine();

    // Step 1: Check and create storage link
    $this->fixStorageLink();

    // Step 2: Check and create directories
    $this->fixDirectories();

    // Step 3: Fix database paths
    $this->fixDatabasePaths();

    // Step 4: Verify configuration
    $this->verifyConfiguration();

    // Step 5: Test results
    $this->testResults();

    $this->newLine();
    $this->info('✅ All fixes completed!');

    return Command::SUCCESS;
  }

  private function fixStorageLink()
  {
    $this->info('1️⃣ Checking storage link...');

    $publicPath = public_path('storage');
    $targetPath = storage_path('app/public');

    if (File::exists($publicPath)) {
      if (is_link($publicPath)) {
        $this->line('   ✅ Storage link exists');
      } else {
        $this->error('   ❌ Path exists but is not a symlink!');
        if ($this->confirm('   Remove and recreate?', true)) {
          File::deleteDirectory($publicPath);
          $this->createStorageLink($publicPath, $targetPath);
        }
      }
    } else {
      $this->warn('   ⚠️ Storage link missing');
      $this->createStorageLink($publicPath, $targetPath);
    }

    $this->newLine();
  }

  private function createStorageLink($publicPath, $targetPath)
  {
    try {
      File::link($targetPath, $publicPath);
      $this->info('   ✅ Storage link created successfully');
    } catch (\Exception $e) {
      $this->error('   ❌ Failed to create storage link: ' . $e->getMessage());
      $this->warn('   Run manually: php artisan storage:link');
    }
  }

  private function fixDirectories()
  {
    $this->info('2️⃣ Checking directories...');

    $directories = [
      'struktur',
      'struktur/prodi',
      'struktur/fakultas',
      'struktur/universitas',
    ];

    foreach ($directories as $dir) {
      if (!Storage::disk('public')->exists($dir)) {
        Storage::disk('public')->makeDirectory($dir);
        $this->info('   ✅ Created directory: ' . $dir);
      } else {
        $this->line('   ✅ Directory exists: ' . $dir);
      }
    }

    // Set permissions
    $basePath = storage_path('app/public/struktur');
    if (File::exists($basePath)) {
      File::chmod($basePath, 0775);
      $this->info('   ✅ Set permissions for struktur directory');
    }

    $this->newLine();
  }

  private function fixDatabasePaths()
  {
    $this->info('3️⃣ Fixing database paths...');

    $structures = StrukturOrganisasi::whereNotNull('gambar')->get();
    $fixed = 0;
    $notFound = 0;

    if ($structures->isEmpty()) {
      $this->line('   No records found');
      return;
    }

    foreach ($structures as $struktur) {
      $original = $struktur->gambar;
      $clean = $this->cleanPath($original);

      if ($clean !== $original) {
        $this->line("   📝 {$struktur->judul}");
        $this->line("      Old: {$original}");
        $this->line("      New: {$clean}");

        // Check if file exists with clean path
        if (Storage::disk('public')->exists($clean)) {
          $struktur->gambar = $clean;
          $struktur->save();
          $this->info("      ✅ Fixed and saved");
          $fixed++;
        } else {
          // Try to find file
          $found = $this->findFile($struktur, $clean);
          if ($found) {
            $this->info("      ✅ Found and fixed");
            $fixed++;
          } else {
            $this->error("      ❌ File not found!");
            $notFound++;
          }
        }
      } else {
        // Path is clean, check if file exists
        if (!Storage::disk('public')->exists($clean)) {
          $this->warn("   ⚠️ {$struktur->judul} - File missing: {$clean}");
          $notFound++;
        }
      }
    }

    $this->newLine();
    $this->info("   Summary: Fixed {$fixed} paths, {$notFound} files not found");
    $this->newLine();
  }

  private function cleanPath($path)
  {
    $path = ltrim($path, '/');
    $path = preg_replace('#^(public/|storage/|/storage/)#', '', $path);
    return $path;
  }

  private function findFile($struktur, $cleanPath)
  {
    $filename = basename($cleanPath);
    $searchPaths = [
      "struktur/prodi/{$filename}",
      "struktur/fakultas/{$filename}",
      "struktur/{$filename}",
      $filename,
    ];

    foreach ($searchPaths as $searchPath) {
      if (Storage::disk('public')->exists($searchPath)) {
        $struktur->gambar = $searchPath;
        $struktur->save();
        $this->line("      Found at: {$searchPath}");
        return true;
      }
    }

    return false;
  }

  private function verifyConfiguration()
  {
    $this->info('4️⃣ Verifying configuration...');

    $this->line('   APP_URL: ' . config('app.url'));
    $this->line('   Filesystem disk: ' . config('filesystems.default'));
    $this->line('   Public disk URL: ' . config('filesystems.disks.public.url'));

    if (empty(config('app.url')) || config('app.url') === 'http://localhost') {
      $this->warn('   ⚠️ APP_URL might need to be updated in .env');
    } else {
      $this->info('   ✅ Configuration looks good');
    }

    $this->newLine();
  }

  private function testResults()
  {
    $this->info('5️⃣ Testing results...');

    $struktur = StrukturOrganisasi::whereNotNull('gambar')->first();

    if (!$struktur) {
      $this->line('   No images to test');
      return;
    }

    $this->line('   Test image: ' . $struktur->judul);
    $this->line('   Path: ' . $struktur->gambar);

    if (Storage::disk('public')->exists($struktur->gambar)) {
      $this->info('   ✅ File exists');
      $url = asset('storage/' . $struktur->gambar);
      $this->line('   URL: ' . $url);

      // Test if URL is accessible
      $fullUrl = url($url);
      $this->line('   Full URL: ' . $fullUrl);
      $this->newLine();
      $this->info('   📌 Test this URL in your browser to verify images are working');
    } else {
      $this->error('   ❌ File not found!');
    }
  }
}

/**
 * CARA PENGGUNAAN:
 * 
 * php artisan storage:fix-all
 * 
 * Atau force tanpa konfirmasi:
 * php artisan storage:fix-all --force
 * 
 * Command ini akan:
 * 1. Check dan create storage link
 * 2. Create missing directories
 * 3. Fix semua path di database
 * 4. Verify configuration
 * 5. Test hasilnya
 */
