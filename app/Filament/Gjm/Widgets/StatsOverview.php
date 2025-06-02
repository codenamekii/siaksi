<?php

// Lokasi file: app/Filament/Gjm/Widgets/StatsOverview.php

namespace App\Filament\Gjm\Widgets;

use App\Models\ProgramStudi;
use App\Models\Dokumen;
use App\Models\Berita;
use App\Models\JadwalAMI;
use App\Models\User;
use App\Models\AkreditasiProdi;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
  protected static ?int $sort = 1;

  protected int | string | array $columnSpan = 'full';

  protected function getStats(): array
  {
    $fakultasId = Auth::user()->fakultas_id;

    // Program Studi Statistics
    $totalProdi = ProgramStudi::where('fakultas_id', $fakultasId)->count();
    $prodiAktif = ProgramStudi::where('fakultas_id', $fakultasId)
      ->where('is_active', true)
      ->count();
    $prodiTerakreditasi = ProgramStudi::where('fakultas_id', $fakultasId)
      ->whereHas('akreditasi', function ($q) {
        $q->where('is_active', true)
          ->where('tanggal_berakhir', '>', now());
      })
      ->count();

    // Dokumen Statistics - Using correct column names
    $totalDokumen = Dokumen::where(function ($q) use ($fakultasId) {
      // Dokumen level fakultas
      $q->where(function ($q2) use ($fakultasId) {
        $q2->where('level', 'fakultas')
          ->where('fakultas_id', $fakultasId);
      })
        // Atau dokumen level prodi dari fakultas ini
        ->orWhere(function ($q2) use ($fakultasId) {
          $q2->where('level', 'prodi')
            ->whereHas('programStudi', function ($q3) use ($fakultasId) {
              $q3->where('fakultas_id', $fakultasId);
            });
        });
    })->count();

    $dokumenBulanIni = Dokumen::where(function ($q) use ($fakultasId) {
      $q->where(function ($q2) use ($fakultasId) {
        $q2->where('level', 'fakultas')
          ->where('fakultas_id', $fakultasId);
      })
        ->orWhere(function ($q2) use ($fakultasId) {
          $q2->where('level', 'prodi')
            ->whereHas('programStudi', function ($q3) use ($fakultasId) {
              $q3->where('fakultas_id', $fakultasId);
            });
        });
    })
      ->whereMonth('created_at', now()->month)
      ->whereYear('created_at', now()->year)
      ->count();

    $dokumenVisibleAsesor = Dokumen::where(function ($q) use ($fakultasId) {
      $q->where(function ($q2) use ($fakultasId) {
        $q2->where('level', 'fakultas')
          ->where('fakultas_id', $fakultasId);
      })
        ->orWhere(function ($q2) use ($fakultasId) {
          $q2->where('level', 'prodi')
            ->whereHas('programStudi', function ($q3) use ($fakultasId) {
              $q3->where('fakultas_id', $fakultasId);
            });
        });
    })
      ->where('is_visible_to_asesor', true) // Fixed column name
      ->count();

    // Berita Statistics - Handling level-based berita
    $totalBerita = Berita::where(function ($q) use ($fakultasId) {
      // Berita level fakultas (tanpa program_studi_id)
      $q->where('level', 'fakultas')
        ->whereNull('program_studi_id')
        // Atau berita dari prodi dalam fakultas ini
        ->orWhereHas('programStudi', function ($q2) use ($fakultasId) {
          $q2->where('fakultas_id', $fakultasId);
        });
    })->count();

    $beritaPublished = Berita::where(function ($q) use ($fakultasId) {
      $q->where('level', 'fakultas')
        ->whereNull('program_studi_id')
        ->orWhereHas('programStudi', function ($q2) use ($fakultasId) {
          $q2->where('fakultas_id', $fakultasId);
        });
    })
      ->where('is_published', true)
      ->count();

    $beritaBulanIni = Berita::where(function ($q) use ($fakultasId) {
      $q->where('level', 'fakultas')
        ->whereNull('program_studi_id')
        ->orWhereHas('programStudi', function ($q2) use ($fakultasId) {
          $q2->where('fakultas_id', $fakultasId);
        });
    })
      ->whereMonth('created_at', now()->month)
      ->whereYear('created_at', now()->year)
      ->count();

    // AMI Statistics
    $totalAMI = JadwalAMI::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })->count();
    $amiUpcoming = JadwalAMI::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })->where('tanggal_mulai', '>', now())->count();
    $amiSelesai = JadwalAMI::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })->where('status', 'selesai')->count();

    // User Statistics
    $totalUJM = User::where('role', 'ujm')
      ->whereHas('programStudi', function ($q) use ($fakultasId) {
        $q->where('fakultas_id', $fakultasId);
      })
      ->count();
    $ujmAktif = User::where('role', 'ujm')
      ->whereHas('programStudi', function ($q) use ($fakultasId) {
        $q->where('fakultas_id', $fakultasId);
      })
      ->where('last_login_at', '>', now()->subDays(30))
      ->count();

    // Akreditasi Statistics
    $akreditasiExpiringSoon = AkreditasiProdi::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })
      ->where('is_active', true)
      ->whereBetween('tanggal_berakhir', [now(), now()->addMonths(6)])
      ->count();

    // SDM Statistics
    $totalDosen = Dosen::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })->where('status', 'aktif')->count();

    $dosenS3 = Dosen::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })
      ->where('status', 'aktif')
      ->where('pendidikan_terakhir', 'S3')
      ->count();

    $totalTendik = TenagaKependidikan::whereHas('programStudi', function ($q) use ($fakultasId) {
      $q->where('fakultas_id', $fakultasId);
    })->where('status', 'aktif')->count();

    return [
      // Row 1: Program Studi
      Stat::make('Total Program Studi', $totalProdi)
        ->description($prodiAktif . ' program studi aktif')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->chart($this->getProdiChart())
        ->color('primary'),

      Stat::make('Program Studi Terakreditasi', $prodiTerakreditasi)
        ->description(number_format(($prodiTerakreditasi / max($totalProdi, 1)) * 100, 1) . '% dari total')
        ->descriptionIcon('heroicon-m-shield-check')
        ->chart($this->getAkreditasiChart())
        ->color('success'),

      Stat::make('Akreditasi Akan Berakhir', $akreditasiExpiringSoon)
        ->description('Dalam 6 bulan ke depan')
        ->descriptionIcon('heroicon-m-exclamation-triangle')
        ->color($akreditasiExpiringSoon > 0 ? 'warning' : 'gray'),

      // Row 2: Dokumen
      Stat::make('Total Dokumen', $totalDokumen)
        ->description($dokumenBulanIni . ' dokumen bulan ini')
        ->descriptionIcon('heroicon-m-document-text')
        ->chart($this->getDokumenChart())
        ->color('info'),

      Stat::make('Dokumen Visible', $dokumenVisibleAsesor)
        ->description('Dapat dilihat asesor')
        ->descriptionIcon('heroicon-m-eye')
        ->color('success'),

      Stat::make('Tingkat Visibilitas', number_format(($dokumenVisibleAsesor / max($totalDokumen, 1)) * 100, 1) . '%')
        ->description('Dokumen yang dapat diakses asesor')
        ->descriptionIcon('heroicon-m-chart-pie')
        ->color('primary'),

      // Row 3: Berita & Pengumuman
      Stat::make('Total Berita', $totalBerita)
        ->description($beritaBulanIni . ' berita bulan ini')
        ->descriptionIcon('heroicon-m-newspaper')
        ->chart($this->getBeritaChart())
        ->color('warning'),

      Stat::make('Berita Terpublikasi', $beritaPublished)
        ->description(number_format(($beritaPublished / max($totalBerita, 1)) * 100, 1) . '% published')
        ->descriptionIcon('heroicon-m-globe-alt')
        ->color('success'),

      // Row 4: AMI
      Stat::make('Total Jadwal AMI', $totalAMI)
        ->description($amiUpcoming . ' jadwal mendatang')
        ->descriptionIcon('heroicon-m-calendar-days')
        ->color('purple'),

      Stat::make('AMI Selesai', $amiSelesai)
        ->description(number_format(($amiSelesai / max($totalAMI, 1)) * 100, 1) . '% completion rate')
        ->descriptionIcon('heroicon-m-check-circle')
        ->color('success'),

      // Row 5: Users & SDM
      Stat::make('Total UJM', $totalUJM)
        ->description($ujmAktif . ' aktif dalam 30 hari')
        ->descriptionIcon('heroicon-m-user-group')
        ->color('indigo'),

      Stat::make('SDM Fakultas', $totalDosen + $totalTendik)
        ->description($totalDosen . ' dosen, ' . $totalTendik . ' tendik')
        ->descriptionIcon('heroicon-m-users')
        ->chart($this->getSDMChart($totalDosen, $totalTendik))
        ->color('teal'),
    ];
  }

  protected function getProdiChart(): array
  {
    $data = ProgramStudi::where('fakultas_id', Auth::user()->fakultas_id)
      ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
      ->groupBy('month')
      ->orderBy('month')
      ->limit(7)
      ->pluck('count')
      ->toArray();

    return array_pad($data, 7, 0);
  }

  protected function getAkreditasiChart(): array
  {
    $data = [];
    $fakultasId = Auth::user()->fakultas_id;

    // Get akreditasi distribution
    $akreditasiData = DB::table('akreditasi_prodi')
      ->join('program_studi', 'akreditasi_prodi.program_studi_id', '=', 'program_studi.id')
      ->where('program_studi.fakultas_id', $fakultasId)
      ->where('akreditasi_prodi.is_active', true)
      ->selectRaw('akreditasi_prodi.status, COUNT(*) as count')
      ->groupBy('akreditasi_prodi.status')
      ->get();

    $statusOrder = ['Unggul', 'Baik Sekali', 'Baik', 'A', 'B', 'C'];

    foreach ($statusOrder as $status) {
      $found = $akreditasiData->where('status', $status)->first();
      $data[] = $found ? $found->count : 0;
    }

    return $data;
  }

  protected function getDokumenChart(): array
  {
    $data = [];
    $fakultasId = Auth::user()->fakultas_id;

    for ($i = 6; $i >= 0; $i--) {
      $count = Dokumen::where(function ($q) use ($fakultasId) {
        $q->where(function ($q2) use ($fakultasId) {
          $q2->where('level', 'fakultas')
            ->where('fakultas_id', $fakultasId);
        })
          ->orWhere(function ($q2) use ($fakultasId) {
            $q2->where('level', 'prodi')
              ->whereHas('programStudi', function ($q3) use ($fakultasId) {
                $q3->where('fakultas_id', $fakultasId);
              });
          });
      })
        ->whereMonth('created_at', now()->subMonths($i)->month)
        ->whereYear('created_at', now()->subMonths($i)->year)
        ->count();
      $data[] = $count;
    }

    return $data;
  }

  protected function getBeritaChart(): array
  {
    $data = [];
    $fakultasId = Auth::user()->fakultas_id;

    for ($i = 6; $i >= 0; $i--) {
      $count = Berita::where(function ($q) use ($fakultasId) {
        $q->where('level', 'fakultas')
          ->whereNull('program_studi_id')
          ->orWhereHas('programStudi', function ($q2) use ($fakultasId) {
            $q2->where('fakultas_id', $fakultasId);
          });
      })
        ->whereMonth('created_at', now()->subMonths($i)->month)
        ->whereYear('created_at', now()->subMonths($i)->year)
        ->count();
      $data[] = $count;
    }

    return $data;
  }

  protected function getSDMChart($dosen, $tendik): array
  {
    // Simple comparison chart
    $total = $dosen + $tendik;
    if ($total == 0) return [0, 0];

    return [
      round(($dosen / $total) * 100),
      round(($tendik / $total) * 100)
    ];
  }

  protected function getPollingInterval(): ?string
  {
    return '30s';
  }
}