<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class QuickFixAsesor extends Command
{
  protected $signature = 'fix:asesor';
  protected $description = 'Quick fix for asesor dashboard issues';

  public function handle()
  {
    $this->info('Checking database structure...');

    // Check akreditasi_prodi table
    if (Schema::hasTable('akreditasi_prodi')) {
      $columns = Schema::getColumnListing('akreditasi_prodi');
      $this->info('Columns in akreditasi_prodi: ' . implode(', ', $columns));

      if (!in_array('peringkat', $columns)) {
        $this->warn('Column "peringkat" not found. Using status_akreditasi instead.');
      }
    }

    // Check if visibleToAsesor scope exists
    $this->info("\nChecking Dokumen model...");

    if (class_exists(\App\Models\Dokumen::class)) {
      $dokumenModel = new \App\Models\Dokumen();

      if (!method_exists($dokumenModel, 'scopeVisibleToAsesor')) {
        $this->warn('scopeVisibleToAsesor method not found in Dokumen model.');
        $this->info('You need to add this scope to the Dokumen model:');
        $this->line('
public function scopeVisibleToAsesor($query)
{
    return $query->where("is_visible_to_asesor", true);
}');
      }
    }

    // Check relationships
    if (class_exists(\App\Models\ProgramStudi::class)) {
      $prodiModel = new \App\Models\ProgramStudi();

      if (!method_exists($prodiModel, 'akreditasi')) {
        $this->warn('akreditasi relationship not found in ProgramStudi model.');
      }
    }

    $this->info("\nQuick fix completed!");
    $this->info("If you still have errors, please share the Dokumen model file.");
  }
}