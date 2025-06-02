<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Dokumen;
use App\Models\Berita;
use App\Models\JadwalAMI;
use App\Models\AkreditasiProdi;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Filament\GJM\Widgets\StatsOverview;
use Illuminate\Support\Facades\Auth;

class GJMOverviewWidget extends BaseStatsWidget
{
  protected static ?int $sort = 1;

  protected static function getWidgetHeading(): ?string
  {
    return 'Overview Fakultas';
  }

  protected function getStats(): array
  {
    $user = Auth::user();
    $fakultasId = $user->fakultas_id;

    // Get program studi count
    $totalProdi = ProgramStudi::where('fakultas_id', $fakultasId)->count();
    $prodiAktif = ProgramStudi::where('fakultas_id', $fakultasId)
      ->where('status', 'aktif')
      ->count();

    // Get UJM count  
    $totalUjm = User::where('fakultas_id', $fakultasId)
      ->where('role', 'ujm')
      ->count();
    $ujmAktif = User::where('fakultas_id', $fakultasId)
      ->where('role', 'ujm')
      ->where('is_active', true)
      ->count();

    // Get dokumen count
    $totalDokumen = Dokumen::whereHas('user', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->count();

    // Get berita count
    $beritaPublished = Berita::whereHas('user', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->where('status', 'published')->count();

    return [
      $this->createStat(
        label: 'Program Studi',
        value: $this->formatNumber($totalProdi),
        description: "{$prodiAktif} aktif dari {$totalProdi} total",
        descriptionIcon: 'heroicon-m-academic-cap',
        color: $this->getPercentageColor($this->calculatePercentage($prodiAktif, $totalProdi)),
        icon: 'heroicon-o-building-library',
        chart: $this->getMonthlyChart(ProgramStudi::class)
      ),

      $this->createStat(
        label: 'Unit Jaminan Mutu',
        value: $this->formatNumber($totalUjm),
        description: "{$ujmAktif} aktif dari {$totalUjm} total",
        descriptionIcon: 'heroicon-m-user-group',
        color: $this->getPercentageColor($this->calculatePercentage($ujmAktif, $totalUjm)),
        icon: 'heroicon-o-users',
        chart: $this->getMonthlyChart(User::class)
      ),

      $this->createStat(
        label: 'Dokumen SPMI',
        value: $this->formatNumber($totalDokumen),
        description: $this->getRecentActivityDescription(Dokumen::class),
        descriptionIcon: $this->getTrendIcon(1),
        color: 'primary',
        icon: 'heroicon-o-document-text',
        chart: $this->getMonthlyChart(Dokumen::class)
      ),

      $this->createStat(
        label: 'Berita & Pengumuman',
        value: $this->formatNumber($beritaPublished),
        description: $this->getRecentActivityDescription(Berita::class),
        descriptionIcon: $this->getTrendIcon(1),
        color: 'success',
        icon: 'heroicon-o-newspaper',
        chart: $this->getMonthlyChart(Berita::class)
      ),
    ];
  }
}

class GJMAkreditasiWidget extends BaseStatsWidget
{
  protected static ?int $sort = 2;

  protected static function getWidgetHeading(): ?string
  {
    return 'Status Akreditasi Program Studi';
  }

  protected function getStats(): array
  {
    $user = Auth::user();
    $fakultasId = $user->fakultas_id;

    // Get akreditasi statistics
    $totalProdi = ProgramStudi::where('fakultas_id', $fakultasId)->count();

    $akreditasiUnggul = AkreditasiProdi::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->where('peringkat', 'Unggul')->where('is_active', true)->count();

    $akreditasiBaik = AkreditasiProdi::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->where('peringkat', 'Baik')->where('is_active', true)->count();

    $akreditasiC = AkreditasiProdi::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->where('peringkat', 'C')->where('is_active', true)->count();

    $belumAkreditasi = $totalProdi - ($akreditasiUnggul + $akreditasiBaik + $akreditasiC);

    // Get expiring soon (within 6 months)
    $expiringSoon = AkreditasiProdi::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })
      ->where('is_active', true)
      ->where('tanggal_berakhir', '<=', now()->addMonths(6))
      ->where('tanggal_berakhir', '>=', now())
      ->count();

    return [
      $this->createStat(
        label: 'Unggul',
        value: $this->formatNumber($akreditasiUnggul),
        description: $this->calculatePercentage($akreditasiUnggul, $totalProdi) . '% dari total prodi',
        descriptionIcon: 'heroicon-m-star',
        color: 'success',
        icon: 'heroicon-o-trophy'
      ),

      $this->createStat(
        label: 'Baik',
        value: $this->formatNumber($akreditasiBaik),
        description: $this->calculatePercentage($akreditasiBaik, $totalProdi) . '% dari total prodi',
        descriptionIcon: 'heroicon-m-check-circle',
        color: 'warning',
        icon: 'heroicon-o-check-badge'
      ),

      $this->createStat(
        label: 'Peringkat C',
        value: $this->formatNumber($akreditasiC),
        description: $this->calculatePercentage($akreditasiC, $totalProdi) . '% dari total prodi',
        descriptionIcon: 'heroicon-m-exclamation-circle',
        color: 'danger',
        icon: 'heroicon-o-exclamation-triangle'
      ),

      $this->createStat(
        label: 'Segera Berakhir',
        value: $this->formatNumber($expiringSoon),
        description: 'Berakhir dalam 6 bulan',
        descriptionIcon: 'heroicon-m-clock',
        color: $expiringSoon > 0 ? 'warning' : 'success',
        icon: 'heroicon-o-calendar-days'
      ),
    ];
  }
}

class GJMSDMWidget extends BaseStatsWidget
{
  protected static ?int $sort = 3;

  protected static function getWidgetHeading(): ?string
  {
    return 'Sumber Daya Manusia';
  }

  protected function getStats(): array
  {
    $user = Auth::user();
    $fakultasId = $user->fakultas_id;

    // Get dosen statistics
    $totalDosen = Dosen::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->count();

    $dosenS3 = Dosen::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->where('pendidikan_terakhir', 'S3')->count();

    $dosenProfesor = Dosen::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->where('jabatan_akademik', 'Profesor')->count();

    // Get tendik statistics  
    $totalTendik = TenagaKependidikan::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->count();

    $tendikPNS = TenagaKependidikan::whereHas('programStudi', function ($query) use ($fakultasId) {
      $query->where('fakultas_id', $fakultasId);
    })->whereIn('status_kepegawaian', ['PNS', 'PPPK'])->count();

    return [
      $this->createStat(
        label: 'Total Dosen',
        value: $this->formatNumber($totalDosen),
        description: $this->getRecentActivityDescription(Dosen::class),
        descriptionIcon: 'heroicon-m-user-plus',
        color: 'primary',
        icon: 'heroicon-o-academic-cap',
        chart: $this->getMonthlyChart(Dosen::class)
      ),

      $this->createStat(
        label: 'Dosen S3',
        value: $this->formatNumber($dosenS3),
        description: $this->calculatePercentage($dosenS3, $totalDosen) . '% dari total dosen',
        descriptionIcon: 'heroicon-m-academic-cap',
        color: $this->getPercentageColor($this->calculatePercentage($dosenS3, $totalDosen)),
        icon: 'heroicon-o-book-open'
      ),

      $this->createStat(
        label: 'Profesor',
        value: $this->formatNumber($dosenProfesor),
        description: $this->calculatePercentage($dosenProfesor, $totalDosen) . '% dari total dosen',
        descriptionIcon: 'heroicon-m-star',
        color: $this->getPercentageColor($this->calculatePercentage($dosenProfesor, $totalDosen)),
        icon: 'heroicon-o-trophy'
      ),

      $this->createStat(
        label: 'Tenaga Kependidikan',
        value: $this->formatNumber($totalTendik),
        description: "{$tendikPNS} PNS/PPPK dari {$totalTendik} total",
        descriptionIcon: 'heroicon-m-users',
        color: $this->getPercentageColor($this->calculatePercentage($tendikPNS, $totalTendik)),
        icon: 'heroicon-o-building-office',
        chart: $this->getMonthlyChart(TenagaKependidikan::class)
      ),
    ];
  }
}

class GJMAMIWidget extends BaseStatsWidget
{
  protected static ?int $sort = 4;

  protected static function getWidgetHeading(): ?string
  {
    return 'Audit Mutu Internal (AMI)';
  }

  protected function getStats(): array
  {
    $user = Auth::user();
    $fakultasId = $user->fakultas_id;

    // Get jadwal AMI
    $jadwalBulanIni = JadwalAMI::where('fakultas_id', $fakultasId)
      ->whereYear('tanggal_pelaksanaan', now()->year)
      ->whereMonth('tanggal_pelaksanaan', now()->month)
      ->count();

    $jadwalSelesai = JadwalAMI::where('fakultas_id', $fakultasId)
      ->where('status', 'selesai')
      ->whereYear('tanggal_pelaksanaan', now()->year)
      ->count();

    $jadwalBerlangsung = JadwalAMI::where('fakultas_id', $fakultasId)
      ->where('status', 'berlangsung')
      ->count();

    // Get next upcoming AMI
    $nextAMI = JadwalAMI::where('fakultas_id', $fakultasId)
      ->where('tanggal_pelaksanaan', '>', now())
      ->orderBy('tanggal_pelaksanaan')
      ->first();

    $nextAMIDays = $nextAMI ? $this->getDaysUntilDeadline(new \DateTime($nextAMI->tanggal_pelaksanaan)) : null;
    $nextDescription = $nextAMI ? $this->formatDeadlineDescription($nextAMIDays) : ['text' => 'Belum ada jadwal', 'color' => 'gray', 'icon' => 'heroicon-m-calendar'];

    return [
      $this->createStat(
        label: 'AMI Bulan Ini',
        value: $this->formatNumber($jadwalBulanIni),
        description: $this->getRecentActivityDescription(JadwalAMI::class, 'tanggal_pelaksanaan'),
        descriptionIcon: 'heroicon-m-calendar',
        color: 'primary',
        icon: 'heroicon-o-calendar-days',
        chart: $this->getMonthlyChart(JadwalAMI::class, 'tanggal_pelaksanaan')
      ),

      $this->createStat(
        label: 'AMI Selesai',
        value: $this->formatNumber($jadwalSelesai),
        description: 'Tahun ' . now()->year,
        descriptionIcon: 'heroicon-m-check-circle',
        color: 'success',
        icon: 'heroicon-o-check-circle'
      ),

      $this->createStat(
        label: 'AMI Berlangsung',
        value: $this->formatNumber($jadwalBerlangsung),
        description: 'Sedang dalam proses',
        descriptionIcon: 'heroicon-m-clock',
        color: $jadwalBerlangsung > 0 ? 'warning' : 'gray',
        icon: 'heroicon-o-clock'
      ),

      $this->createStat(
        label: 'AMI Mendatang',
        value: $nextAMI ? $nextAMIDays . ' hari' : '-',
        description: $nextDescription['text'],
        descriptionIcon: $nextDescription['icon'],
        color: $nextDescription['color'],
        icon: 'heroicon-o-calendar'
      ),
    ];
  }
}