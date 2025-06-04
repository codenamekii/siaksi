<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\ProgramStudi;
use App\Models\Fakultas;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use App\Models\AkreditasiProdi;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AsesorController extends Controller
{
  /**
   * Check if user is asesor
   */
  private function checkAsesorAccess()
  {
    if (!Auth::check()) {
      abort(401, 'Unauthenticated.');
    }

    if (Auth::user()->role !== 'asesor') {
      Log::warning('Non-asesor user trying to access asesor area', [
        'user_id' => Auth::id(),
        'user_email' => Auth::user()->email,
        'user_role' => Auth::user()->role,
      ]);
      abort(403, 'Access denied. You must be logged in as an Asesor.');
    }

    if (!Auth::user()->is_active) {
      Auth::logout();
      return redirect()->route('login')->with('error', 'Your account is inactive.');
    }
  }

  /**
   * Dashboard utama asesor
   */
  public function dashboard(Request $request)
  {
    // Check access
    $this->checkAsesorAccess();

    // Handle search if exists
    $search = $request->get('search');

    try {
      $data = [
        // Basic stats
        'totalFakultas' => Fakultas::count(),
        'totalProdi' => ProgramStudi::where('is_active', true)->count(),
        'totalDokumen' => $this->getSafeDokumenCount(),
        'dokumenVisible' => $this->getSafeDokumenCount(),

        // Akreditasi stats
        'prodiTerakreditasi' => ProgramStudi::whereHas('akreditasi')->count(),
        'akreditasiAktif' => AkreditasiProdi::where('tanggal_berakhir', '>', now())->count(),
        'akreditasiUnggul' => AkreditasiProdi::where('status_akreditasi', 'Unggul')->count(),
        'akreditasiBaikSekali' => AkreditasiProdi::where('status_akreditasi', 'Baik Sekali')->count(),

        // Recent documents
        'recentDocuments' => $this->getRecentDocuments($search),
      ];
    } catch (\Exception $e) {
      // Fallback data if there are errors
      $data = [
        'totalFakultas' => 0,
        'totalProdi' => 0,
        'totalDokumen' => 0,
        'dokumenVisible' => 0,
        'prodiTerakreditasi' => 0,
        'akreditasiAktif' => 0,
        'akreditasiUnggul' => 0,
        'akreditasiBaikSekali' => 0,
        'recentDocuments' => collect([]),
      ];

      Log::error('Asesor Dashboard Error: ' . $e->getMessage());
    }

    return view('asesor.dashboard', $data);
  }

  /**
   * Get dokumen count safely
   */
  private function getSafeDokumenCount()
  {
    try {
      if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
        return Dokumen::visibleToAsesor()->count();
      }

      // Fallback: check if column exists
      if (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
        return Dokumen::where('is_visible_to_asesor', true)->count();
      }

      // Default: return all dokumen
      return Dokumen::count();
    } catch (\Exception $e) {
      return 0;
    }
  }

  /**
   * Get recent documents safely
   */
  private function getRecentDocuments($search = null)
  {
    try {
      $query = Dokumen::query();

      // Apply visibility filter if method exists
      if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
        $query->visibleToAsesor();
      } elseif (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
        $query->where('is_visible_to_asesor', true);
      }

      // Apply search if provided
      if ($search) {
        $query->where(function ($q) use ($search) {
          $q->where('nama', 'like', "%{$search}%")
            ->orWhere('kategori', 'like', "%{$search}%");
        });
      }

      return $query->with(['fakultas', 'programStudi'])
        ->latest()
        ->take(10)
        ->get();
    } catch (\Exception $e) {
      return collect([]);
    }
  }

  /**
   * Halaman dokumen institusi/universitas
   */
  public function dokumenInstitusi()
  {
    // Check access
    $this->checkAsesorAccess();

    try {
      $query = Dokumen::where('level', 'universitas');

      // Apply visibility filter if method exists
      if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
        $query->visibleToAsesor();
      } elseif (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
        $query->where('is_visible_to_asesor', true);
      }

      $dokumen = $query->orderBy('kategori')
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('kategori');
    } catch (\Exception $e) {
      $dokumen = collect([]);
      Log::error('Dokumen Institusi Error: ' . $e->getMessage());
    }

    return view('asesor.dokumen-institusi', compact('dokumen'));
  }

  /**
   * Halaman dokumen fakultas
   */
  public function dokumenFakultas()
  {
    // Check access
    $this->checkAsesorAccess();

    try {
      $fakultas = Fakultas::with([
        'dokumen' => function ($query) {
          if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
            $query->visibleToAsesor();
          } elseif (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
            $query->where('is_visible_to_asesor', true);
          }
          $query->orderBy('kategori')->orderBy('created_at', 'desc');
        },
        'programStudi' => function ($query) {
          $query->where('is_active', true);
        }
      ])
        ->withCount([
          'dokumen' => function ($query) {
            if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
              $query->visibleToAsesor();
            } elseif (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
              $query->where('is_visible_to_asesor', true);
            }
          }
        ])
        ->orderBy('nama')
        ->get();
    } catch (\Exception $e) {
      $fakultas = collect([]);
      Log::error('Dokumen Fakultas Error: ' . $e->getMessage());
    }

    return view('asesor.dokumen-fakultas', compact('fakultas'));
  }

  /**
   * Halaman dokumen program studi
   */
  public function dokumenProdi()
  {
    // Check access
    $this->checkAsesorAccess();

    try {
      $programStudi = ProgramStudi::with([
        'dokumen' => function ($query) {
          if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
            $query->visibleToAsesor();
          } elseif (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
            $query->where('is_visible_to_asesor', true);
          }
          $query->orderBy('kategori')->orderBy('created_at', 'desc');
        },
        'akreditasiAktif',
        'fakultas'
      ])
        ->withCount([
          'dokumen' => function ($query) {
            if (method_exists(Dokumen::class, 'scopeVisibleToAsesor')) {
              $query->visibleToAsesor();
            } elseif (Schema::hasColumn('dokumen', 'is_visible_to_asesor')) {
              $query->where('is_visible_to_asesor', true);
            }
          }
        ])
        ->where('is_active', true)
        ->orderBy('fakultas_id')
        ->orderBy('nama')
        ->get();
    } catch (\Exception $e) {
      $programStudi = collect([]);
      Log::error('Dokumen Prodi Error: ' . $e->getMessage());
    }

    return view('asesor.dokumen-prodi', compact('programStudi'));
  }

  /**
   * Halaman informasi tambahan
   */
  public function informasiTambahan()
  {
    // Check access
    $this->checkAsesorAccess();

    $data = [
      'dosen' => Dosen::with(['programStudi', 'programStudi.fakultas'])
        ->where('is_active', true)
        ->orderBy('nama')
        ->get(),

      'tendik' => TenagaKependidikan::with(['programStudi', 'programStudi.fakultas'])
        ->where('is_active', true)
        ->orderBy('nama')
        ->get(),

      'prodi' => ProgramStudi::with(['fakultas', 'akreditasiAktif'])
        ->where('is_active', true)
        ->withCount(['dosen', 'tenagaKependidikan'])
        ->orderBy('fakultas_id')
        ->orderBy('nama')
        ->get(),

      // Statistics
      'totalDosen' => Dosen::where('is_active', true)->count(),
      'totalTendik' => TenagaKependidikan::where('is_active', true)->count(),
      'dosenByJabatan' => Dosen::where('is_active', true)
        ->select('jabatan_akademik', DB::raw('count(*) as total'))
        ->groupBy('jabatan_akademik')
        ->get(),
    ];

    return view('asesor.informasi-tambahan', $data);
  }

  /**
   * Halaman statistik (To be implemented)
   */
  public function statistik()
  {
    // Check access
    $this->checkAsesorAccess();

    // TODO: Implement statistik page
    return view('asesor.statistik');
  }

  /**
   * Halaman profile (To be implemented)
   */
  public function profile()
  {
    // Check access
    $this->checkAsesorAccess();

    // TODO: Implement profile page
    return view('asesor.profile');
  }

  /**
   * Search functionality (To be implemented)
   */
  public function search(Request $request)
  {
    // Check access
    $this->checkAsesorAccess();

    // TODO: Implement search functionality
    $query = $request->get('query');

    return redirect()->route('asesor.dashboard', ['search' => $query]);
  }
}