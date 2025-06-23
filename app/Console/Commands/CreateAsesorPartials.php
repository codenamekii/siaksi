<?php
// Lokasi file: app/Console/Commands/CreateAsesorPartials.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateAsesorPartials extends Command
{
  protected $signature = 'asesor:create-partials';
  protected $description = 'Create partials directory for asesor views';

  public function handle()
  {
    $this->info('Creating Asesor partials directory...');

    // Create partials directory
    $partialsPath = resource_path('views/asesor/partials');

    if (!File::exists($partialsPath)) {
      File::makeDirectory($partialsPath, 0755, true);
      $this->info('✓ Created directory: ' . $partialsPath);
    } else {
      $this->warn('Directory already exists: ' . $partialsPath);
    }

    // Create components/asesor directory
    $componentsPath = resource_path('views/components/asesor');

    if (!File::exists($componentsPath)) {
      File::makeDirectory($componentsPath, 0755, true);
      $this->info('✓ Created directory: ' . $componentsPath);
    } else {
      $this->warn('Directory already exists: ' . $componentsPath);
    }

    $this->info('');
    $this->info('Asesor partials directories created successfully!');
    $this->info('');
    $this->info('Next steps:');
    $this->info('1. Create the partial view files in resources/views/asesor/partials/');
    $this->info('   - fakultas-section.blade.php');
    $this->info('   - program-studi-section.blade.php');
    $this->info('   - akreditasi-section.blade.php');
    $this->info('');
    $this->info('2. Create the component files in resources/views/components/asesor/');
    $this->info('   - hero-section.blade.php');
    $this->info('   - navbar.blade.php');
    $this->info('   - footer.blade.php');
    $this->info('');
    $this->info('3. Clear caches:');
    $this->info('   php artisan view:clear');
    $this->info('   php artisan config:clear');
    $this->info('   php artisan cache:clear');
  }
}