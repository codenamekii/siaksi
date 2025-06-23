<?php

namespace App\Filament\Ujm\Widgets;

use Filament\Widgets\Widget;
use App\Models\Dokumen;
use App\Models\Berita;
use App\Models\GaleriKegiatan;
use Illuminate\Support\Facades\Auth;

class RecentActivities extends Widget
{
  protected static string $view = 'filament.ujm.widgets.recent-activities';

  protected int | string | array $columnSpan = 'full';

  protected static ?int $sort = 2;

  public function getRecentActivities()
  {
    $prodiId = Auth::user()->program_studi_id;

    $activities = collect();

    // Recent documents
    $documents = Dokumen::where('program_studi_id', $prodiId)
      ->latest()
      ->take(3)
      ->get()
      ->map(function ($doc) {
        return [
          'type' => 'document',
          'title' => $doc->nama,
          'description' => 'Dokumen ' . $doc->kategori_label,
          'created_at' => $doc->created_at,
          'icon' => 'heroicon-o-document-text',
          'color' => 'blue',
        ];
      });

    // Recent news
    $news = Berita::where('program_studi_id', $prodiId)
      ->latest()
      ->take(3)
      ->get()
      ->map(function ($item) {
        return [
          'type' => 'news',
          'title' => $item->judul,
          'description' => 'Berita/Pengumuman',
          'created_at' => $item->created_at,
          'icon' => 'heroicon-o-newspaper',
          'color' => 'green',
        ];
      });

    // Recent gallery
    $gallery = GaleriKegiatan::where('program_studi_id', $prodiId)
      ->latest()
      ->take(2)
      ->get()
      ->map(function ($item) {
        return [
          'type' => 'gallery',
          'title' => $item->judul,
          'description' => 'Dokumentasi Kegiatan',
          'created_at' => $item->created_at,
          'icon' => 'heroicon-o-photo',
          'color' => 'purple',
        ];
      });

    return $activities
      ->merge($documents)
      ->merge($news)
      ->merge($gallery)
      ->sortByDesc('created_at')
      ->take(5);
  }
}
