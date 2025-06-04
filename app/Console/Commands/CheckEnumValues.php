<?php

// Lokasi file: app/Console/Commands/CheckEnumValues.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckEnumValues extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'db:check-enum {table} {column}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Check ENUM values for a specific column';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $table = $this->argument('table');
    $column = $this->argument('column');

    if (!Schema::hasTable($table)) {
      $this->error("Table '{$table}' does not exist!");
      return Command::FAILURE;
    }

    if (!Schema::hasColumn($table, $column)) {
      $this->error("Column '{$column}' does not exist in table '{$table}'!");
      return Command::FAILURE;
    }

    $this->info("Checking ENUM values for {$table}.{$column}");
    $this->newLine();

    try {
      // Get column information
      $result = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'");

      if (empty($result)) {
        $this->error("Could not get column information");
        return Command::FAILURE;
      }

      $columnInfo = $result[0];
      $type = $columnInfo->Type;

      // Check if it's an ENUM
      if (!str_starts_with($type, 'enum')) {
        $this->warn("Column '{$column}' is not an ENUM type. Type: {$type}");
        return Command::SUCCESS;
      }

      // Extract ENUM values
      preg_match('/enum\((.*)\)/', $type, $matches);

      if (isset($matches[1])) {
        $enumValues = str_getcsv($matches[1], ',', "'");

        $this->info("Current ENUM values (" . count($enumValues) . " total):");
        foreach ($enumValues as $index => $value) {
          $this->line(sprintf("  %2d. %s", $index + 1, $value));
        }

        // Check for laporan-specific values
        if ($table === 'dokumen' && $column === 'kategori') {
          $this->newLine();
          $this->info("Checking for laporan categories:");

          $requiredLaporanCategories = [
            'laporan_ami',
            'laporan_survei',
            'analisis_capaian',
            'rencana_tindak_lanjut',
            'laporan_kinerja'
          ];

          $missing = array_diff($requiredLaporanCategories, $enumValues);

          if (!empty($missing)) {
            $this->warn("Missing laporan categories:");
            foreach ($missing as $category) {
              $this->line("  ❌ {$category}");
            }

            $this->newLine();
            $this->info("To fix, run the SQL below:");
            $this->line($this->generateAlterStatement($enumValues, $missing));
          } else {
            $this->info("✅ All laporan categories are present!");
          }
        }
      }
    } catch (\Exception $e) {
      $this->error("Error: " . $e->getMessage());
      return Command::FAILURE;
    }

    return Command::SUCCESS;
  }

  private function generateAlterStatement($currentValues, $missingValues)
  {
    $allValues = array_unique(array_merge($currentValues, $missingValues));
    sort($allValues);

    $enumList = implode(",\n    ", array_map(fn($v) => "'{$v}'", $allValues));

    return "ALTER TABLE dokumen MODIFY COLUMN kategori ENUM(\n    {$enumList}\n);";
  }
}

/**
 * CARA PENGGUNAAN:
 * 
 * php artisan db:check-enum dokumen kategori
 * 
 * Command ini akan:
 * - Show current ENUM values
 * - Check for missing laporan categories
 * - Generate SQL to fix if needed
 */
