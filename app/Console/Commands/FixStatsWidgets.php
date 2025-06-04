<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixStatsWidgets extends Command
{
  protected $signature = 'fix:stats-widgets';
  protected $description = 'Fix stats overview widgets that have wrong method names';

  public function handle()
  {
    $this->info('Checking stats widgets...');

    // List of widget files to check
    $widgets = [
      'app/Filament/Gjm/Widgets/StatsOverview.php',
      'app/Filament/Gjm/Widgets/ProgramStudiStatus.php',
      'app/Filament/Ujm/Widgets/StatsOverview.php',
      'app/Filament/Ujm/Widgets/DocumentStatus.php',
    ];

    foreach ($widgets as $widgetPath) {
      if (File::exists(base_path($widgetPath))) {
        $content = File::get(base_path($widgetPath));

        // Check if it extends StatsOverviewWidget
        if (strpos($content, 'extends BaseWidget') !== false || strpos($content, 'StatsOverviewWidget') !== false) {
          $this->info("✅ {$widgetPath} - Uses StatsOverviewWidget");

          // Check if it has getStats method
          if (strpos($content, 'function getStats()') === false) {
            $this->error("❌ Missing getStats() method in {$widgetPath}");
            $this->line("   Please ensure it has: protected function getStats(): array");
          }

          // Check if it uses Stat::make
          if (strpos($content, 'Stat::make') === false) {
            $this->warn("⚠️  Not using Stat::make in {$widgetPath}");
            $this->line("   Should use: Stat::make('Label', value)");
          }
        } else {
          $this->info("ℹ️  {$widgetPath} - Not a stats widget");
        }
      } else {
        $this->error("❌ File not found: {$widgetPath}");
      }
    }

    $this->newLine();
    $this->info('Widget check completed!');
    $this->info('If there are still errors, make sure:');
    $this->info('1. All stats widgets extend StatsOverviewWidget');
    $this->info('2. They have getStats() method, not getCards()');
    $this->info('3. They return array of Stat::make() objects');

    $this->newLine();
    $this->info('Clear cache after fixing:');
    $this->line('php artisan optimize:clear');
  }
}
