<?php
// Lokasi file: database/seeders/UpdateDokumenVisibilitySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokumen;

class UpdateDokumenVisibilitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Update all existing documents to be visible to asesor
    Dokumen::query()->update([
      'is_visible_to_asesor' => true
    ]);

    $this->command->info('Updated all documents to be visible to asesor.');
  }
}
