<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateWidgetFolders extends Command
{
  protected $signature = 'make:widget-folders';
  protected $description = 'Create necessary folders for Filament widgets';

  public function handle()
  {
    $this->info('Creating widget folders...');

    // Create folders
    $folders = [
      resource_path('views/filament/gjm/widgets'),
      resource_path('views/filament/ujm/widgets'),
      resource_path('views/components'),
    ];

    foreach ($folders as $folder) {
      if (!File::exists($folder)) {
        File::makeDirectory($folder, 0755, true);
        $this->info("✅ Created: {$folder}");
      } else {
        $this->info("Already exists: {$folder}");
      }
    }

    $this->info("\n✅ All folders created successfully!");
    $this->info("\nNext steps:");
    $this->info("1. Clear cache: php artisan optimize:clear");
    $this->info("2. Login as GJM to see the new widgets");
    $this->info("3. Click on UJM dashboard buttons to access UJM panels");
    $this->info("4. Click on Asesor dashboard button to access Asesor panel");
  }
}