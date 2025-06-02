<?php

// Lokasi file: app/Filament/Ujm/Widgets/StatsOverview.php

namespace App\Filament\Ujm\Widgets;

use App\Models\Dokumen;
use App\Models\Berita;
use App\Models\GaleriKegiatan;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use App\Models\AkreditasiProdi;
use App\Models\TimUJM;
use App\Filament\Ujm\Resources\LaporanResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
  protected static ?int $sort = 1;

  protected int | string | array $columnSpan = 'full';

  protected function getStats(): array
  {
    $user = Auth::user();

    // Check if user has program_studi_id column
    if (!Schema::hasColumn('users', 'program_studi_id')) {
      return [
        Stat::make('Peringatan', 'Database perlu diupdate')
          ->description('Jalankan migration untuk menambah relasi program studi')
          ->descriptionIcon('heroicon-m-exclamation-triangle')
          ->color('warning'),
      ];
    }

    $prodiId = $user->program_studi_id;

    if (!$prodiId) {
      return [
        Stat::make('Peringatan', 'Akun belum terhubung ke Program Studi')
          ->description('Hubungi Super Admin untuk pengaturan')
          ->descriptionIcon('heroicon-m-exclamation-triangle')
          ->color('warning'),
      ];
    }

    // Dokumen Statistics
    $totalDokumen = Dokumen::where('program_studi_id', $prodiId)->count();
    $dokumenBulanIni = Dokumen::where('program_studi_id', $prodiId)
      ->whereMonth('created_at', now()->month)
      ->whereYear('created_at', now()->year)
      ->count();
    $dokumenVisibleAsesor = Dokumen::where('program_studi_id', $prodiId)
      ->where('is_visible_to_asesor', true)
      ->count();

    // Kategori Dokumen Distribution
    $dokumenByKategori = Dokumen::where('program_studi_id', $prodiId)
      ->selectRaw('kategori, COUNT(*) as count')
      ->groupBy('kategori')
      ->pluck('count', 'kategori')
      ->toArray();

    // Berita & Pengumuman
    $totalBerita = Berita::where('program_studi_id', $prodiId)->count();
    $beritaPublished = Berita::where('program_studi_id', $prodiId)
      ->where('is_published', true)
      ->count();
    $beritaPending = Berita::where('program_studi_id', $prodiId)
      ->where('is_published', false)
      ->count();

    // Galeri Kegiatan
    $totalGaleri = GaleriKegiatan::where('program_studi_id', $prodiId)->count();
    $fotoCount = GaleriKegiatan::where('program_studi_id', $prodiId)
      ->where('tipe', 'foto')
      ->count();
    $videoCount = GaleriKegiatan::where('program_studi_id', $prodiId)
      ->where('tipe', 'video')
      ->count();

    // SDM Statistics
    $totalDosen = Dosen::where('program_studi_id', $prodiId)
      ->where('status', 'aktif')
      ->count();
    $dosenS3 = Dosen::where('program_studi_id', $prodiId)
      ->where('status', 'aktif')
      ->where('pendidikan_terakhir', 'S3')
      ->count();
    $profesor = Dosen::where('program_studi_id', $prodiId)
      ->where('status', 'aktif')
      ->where('jabatan_akademik', 'Guru Besar')
      ->count();

    $totalTendik = TenagaKependidikan::where('program_studi_id', $prodiId)
      ->where('status', 'aktif')
      ->count();
    $tendikPNS = TenagaKependidikan::where('program_studi_id', $prodiId)
      ->where('status', 'aktif')
      ->whereIn('status_kepegawaian', ['PNS', 'PPPK'])
      ->count();

    // Tim UJM
    $totalTimUJM = TimUJM::where('program_studi_id', $prodiId)->count();

    // Akreditasi Status
    $akreditasiAktif = AkreditasiProdi::where('program_studi_id', $prodiId)
      ->where('is_active', true)
      ->first();

    $statusAkreditasi = $akreditasiAktif ? $akreditasiAktif->status : 'Belum Terakreditasi';
    $sisaMasaBerlaku = $akreditasiAktif
      ? Carbon::parse($akreditasiAktif->tanggal_berakhir)->diffInDays(now())
      : 0;

    // Laporan Statistics - Query dari tabel dokumen dengan kategori laporan
    $totalLaporan = Dokumen::where('program_studi_id', $prodiId)
      ->whereIn('kategori', [
        'laporan_ami',
        'laporan_survei',
        'analisis_capaian',
        'rencana_tindak_lanjut',
        'laporan_kinerja'
      ])
      ->count();

    $laporanBulanIni = Dokumen::where('program_studi_id', $prodiId)
      ->whereIn('kategori', [
        'laporan_ami',
        'laporan_survei',
        'analisis_capaian',
        'rencana_tindak_lanjut',
        'laporan_kinerja'
      ])
      ->whereMonth('created_at', now()->month)
      ->whereYear('created_at', now()->year)
      ->count();

    return [
      // Row 1: Akreditasi Status
      Stat::make('Status Akreditasi', $statusAkreditasi)
        ->description($akreditasiAktif ? 'Berlaku hingga ' . Carbon::parse($akreditasiAktif->tanggal_berakhir)->format('d M Y') : 'Perlu diperbarui')
        ->descriptionIcon('heroicon-m-shield-check')
        ->color($this->getAkreditasiColor($statusAkreditasi)),

      Stat::make('Masa Berlaku', $sisaMasaBerlaku . ' hari')
        ->description($sisaMasaBerlaku < 180 ? 'Segera perpanjang!' : 'Masih aman')
        ->descriptionIcon('heroicon-m-clock')
        ->color($sisaMasaBerlaku < 180 ? 'warning' : 'success'),

      Stat::make('Nilai Akreditasi', $akreditasiAktif && $akreditasiAktif->nilai ? $akreditasiAktif->nilai : '-')
        ->description('Skala 0-400')
        ->descriptionIcon('heroicon-m-chart-bar')
        ->color('primary'),

      // Row 2: Dokumen
      Stat::make('Total Dokumen', $totalDokumen)
        ->description($dokumenBulanIni . ' dokumen bulan ini')
        ->descriptionIcon('heroicon-m-document-text')
        ->chart($this->getDokumenChart($prodiId))
        ->color('info'),

      Stat::make('Dokumen Visible', $dokumenVisibleAsesor)
        ->description(number_format(($dokumenVisibleAsesor / max($totalDokumen, 1)) * 100, 1) . '% dapat diakses asesor')
        ->descriptionIcon('heroicon-m-eye')
        ->color('success'),

      Stat::make('Kategori Terbanyak', $this->getTopKategori($dokumenByKategori))
        ->description(($dokumenByKategori[$this->getTopKategori($dokumenByKategori)] ?? 0) . ' dokumen')
        ->descriptionIcon('heroicon-m-folder')
        ->color('purple'),

      // Row 3: Berita & Galeri
      Stat::make('Total Berita', $totalBerita)
        ->description($beritaPublished . ' published, ' . $beritaPending . ' draft')
        ->descriptionIcon('heroicon-m-newspaper')
        ->chart($this->getBeritaChart($prodiId))
        ->color('warning'),

      Stat::make('Galeri Kegiatan', $totalGaleri)
        ->description($fotoCount . ' foto, ' . $videoCount . ' video')
        ->descriptionIcon('heroicon-m-photo')
        ->color('pink'),

      // Row 4: SDM
      Stat::make('Total Dosen', $totalDosen)
        ->description($dosenS3 . ' bergelar S3, ' . $profesor . ' Guru Besar')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->chart($this->getDosenChart($totalDosen, $dosenS3, $profesor))
        ->color('indigo'),

      Stat::make('Tenaga Kependidikan', $totalTendik)
        ->description($tendikPNS . ' PNS/PPPK')
        ->descriptionIcon('heroicon-m-user-group')
        ->color('teal'),

      // Row 5: Tim & Laporan
      Stat::make('Anggota Tim UJM', $totalTimUJM)
        ->description('Pengelola mutu prodi')
        ->descriptionIcon('heroicon-m-users')
        ->color('amber'),

      Stat::make('Total Laporan', $totalLaporan)
        ->description($laporanBulanIni . ' laporan bulan ini')
        ->descriptionIcon('heroicon-m-document-chart-bar')
        ->color('emerald'),
    ];
  }

  protected function getAkreditasiColor($status): string
  {
    return match ($status) {
      'Unggul' => 'success',
      'Baik Sekali' => 'success',
      'Baik' => 'info',
      'A' => 'success',
      'B' => 'info',
      'C' => 'warning',
      default => 'gray'
    };
  }

  protected function getTopKategori($kategoriData): string
  {
    if (empty($kategoriData)) return 'Belum ada';

    arsort($kategoriData);
    return array_key_first($kategoriData);
  }

  protected function getDokumenChart($prodiId): array
  {
    $data = [];

    for ($i = 6; $i >= 0; $i--) {
      $count = Dokumen::where('program_studi_id', $prodiId)
        ->whereMonth('created_at', now()->subMonths($i)->month)
        ->whereYear('created_at', now()->subMonths($i)->year)
        ->count();
      $data[] = $count;
    }

    return $data;
  }

  protected function getBeritaChart($prodiId): array
  {
    $data = [];

    for ($i = 6; $i >= 0; $i--) {
      $count = Berita::where('program_studi_id', $prodiId)
        ->whereMonth('created_at', now()->subMonths($i)->month)
        ->whereYear('created_at', now()->subMonths($i)->year)
        ->count();
      $data[] = $count;
    }

    return $data;
  }

  protected function getDosenChart($total, $s3, $profesor): array
  {
    if ($total == 0) return [0, 0, 0];

    $s2 = $total - $s3;

    return [
      round(($s2 / $total) * 100),
      round(($s3 / $total) * 100),
      round(($profesor / $total) * 100)
    ];
  }

  protected function getColumns(): int
  {
    return 3;
  }

  protected function getPollingInterval(): ?string
  {
    return '30s';
  }

  public static function canView(): bool
  {
    return Schema::hasColumn('users', 'program_studi_id')
      && Auth::user()->program_studi_id !== null;
  }
}