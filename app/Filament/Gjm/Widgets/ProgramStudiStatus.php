<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\ProgramStudi;
use Filament\Widgets\ChartWidget;

class ProgramStudiStatus extends ChartWidget
{
  protected static ?string $heading = 'Status Akreditasi Program Studi';

  protected static ?int $sort = 4;

  protected function getData(): array
  {
    $statusCounts = ProgramStudi::with('akreditasiAktif')
      ->where('is_active', true)
      ->get()
      ->groupBy(function ($prodi) {
        return $prodi->akreditasiAktif?->status_akreditasi ?? 'Belum Terakreditasi';
      })
      ->map(fn($group) => $group->count());

    return [
      'datasets' => [
        [
          'label' => 'Program Studi',
          'data' => $statusCounts->values(),
          'backgroundColor' => [
            '#10b981', // Unggul - Green
            '#3b82f6', // Baik Sekali - Blue
            '#f59e0b', // Baik - Amber
            '#ef4444', // Belum - Red
          ],
        ],
      ],
      'labels' => $statusCounts->keys(),
    ];
  }

  protected function getType(): string
  {
    return 'doughnut';
  }

  protected function getOptions(): array
  {
    return [
      'plugins' => [
        'legend' => [
          'display' => true,
          'position' => 'bottom',
        ],
      ],
    ];
  }
}
