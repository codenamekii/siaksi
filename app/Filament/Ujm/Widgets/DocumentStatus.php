<?php

namespace App\Filament\Ujm\Widgets;

use App\Models\Dokumen;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class DocumentStatus extends ChartWidget
{
  protected static ?string $heading = 'Status Dokumen';

  protected static ?int $sort = 3;

  protected function getData(): array
  {
    $prodiId = Auth::user()->programStudi?->id;

    if (!$prodiId) {
      return [
        'datasets' => [
          [
            'label' => 'Dokumen',
            'data' => [0, 0],
          ],
        ],
        'labels' => ['Terlihat Asesor', 'Tidak Terlihat'],
      ];
    }

    $visibleToAsesor = Dokumen::where('program_studi_id', $prodiId)
      ->where('is_visible_to_asesor', true)
      ->count();

    $notVisible = Dokumen::where('program_studi_id', $prodiId)
      ->where('is_visible_to_asesor', false)
      ->count();

    return [
      'datasets' => [
        [
          'label' => 'Dokumen',
          'data' => [$visibleToAsesor, $notVisible],
          'backgroundColor' => [
            '#10b981', // Green for visible
            '#ef4444', // Red for not visible
          ],
        ],
      ],
      'labels' => ['Terlihat Asesor', 'Tidak Terlihat'],
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
