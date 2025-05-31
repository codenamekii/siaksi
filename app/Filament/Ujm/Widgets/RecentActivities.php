<?php

namespace App\Filament\Ujm\Widgets;

use App\Models\Berita;
use App\Models\Dokumen;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class RecentActivities extends Widget
{
  protected static string $view = 'filament.ujm.widgets.recent-activities';

  protected static ?int $sort = 2;

  protected int | string | array $columnSpan = 'full';

  protected function getViewData(): array
  {
    $prodiId = Auth::user()->programStudi?->id;

    if (!$prodiId) {
      return ['activities' => collect([])];
    }

    // Gabungkan berita dan dokumen terbaru
    $berita = Berita::where('program_studi_id', $prodiId)
      ->latest()
      ->take(3)
      ->get()
      ->map(function ($item) {
        return [
          'type' => 'berita',
          'title' => $item->judul,
          'date' => $item->created_at,
          'icon' => 'heroicon-o-newspaper',
          'color' => 'primary',
        ];
      });

    $dokumen = Dokumen::where('program_studi_id', $prodiId)
      ->latest()
      ->take(3)
      ->get()
      ->map(function ($item) {
        return [
          'type' => 'dokumen',
          'title' => $item->nama,
          'date' => $item->created_at,
          'icon' => 'heroicon-o-document-text',
          'color' => 'success',
        ];
      });

    $activities = $berita->merge($dokumen)
      ->sortByDesc('date')
      ->take(5);

    return [
      'activities' => $activities
    ];
  }
}
