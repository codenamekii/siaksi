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
use App\Models\GaleriKegiatan;

class AsesorController extends Controller
{
    /**
     * Check if user is asesor or has temporary access
     */
    private function checkAsesorAccess()
    {
        if (!Auth::check()) {
            abort(401, 'Unauthenticated.');
        }

        $user = Auth::user();

        // Allow if user is asesor
        if ($user->role === 'asesor') {
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is inactive.');
            }
            return;
        }

        // Allow if user is GJM (super admin)
        if ($user->role === 'gjm') {
            // Set session flag to indicate GJM is viewing
            session(['viewing_as_gjm' => true]);
            return;
        }

        // Allow if UJM is accessing as asesor (check session)
        if ($user->role === 'ujm' && session('ujm_original_user')) {
            return;
        }

        // Otherwise deny access
        Log::warning('Unauthorized access attempt to asesor area', [
            'user_id' => Auth::id(),
            'user_email' => $user->email,
            'user_role' => $user->role,
        ]);
        abort(403, 'Access denied. You must be logged in as an Asesor.');
    }

    public function debugSession()
    {
        return response()->json([
            'current_user' => Auth::user(),
            'gjm_original_user' => session('gjm_original_user'),
            'ujm_original_user' => session('ujm_original_user'),
            'all_session' => session()->all(),
            'has_gjm_session' => session()->has('gjm_original_user'),
            'has_ujm_session' => session()->has('ujm_original_user'),
        ]);
    }

    public function dashboard(Request $request)
    {
        // Check access first
        $this->checkAsesorAccess();

        $user = Auth::user();

        $fakultas = Fakultas::first();

        $debugSession = [
            'gjm_original_user' => session('gjm_original_user'),
            'ujm_original_user' => session('ujm_original_user'),
            'viewing_as_gjm' => session('viewing_as_gjm'),
            'has_return_button' => $user->role === 'gjm' || session('gjm_original_user') || session('ujm_original_user'),
            'current_role' => $user->role,
        ];

        try {
            $data = [
                'totalFakultas' => Fakultas::count(),
                'totalProdi' => ProgramStudi::where('is_active', true)->count(),
                'totalDokumen' => $this->getSafeDokumenCount(),
                'dokumenVisible' => $this->getSafeDokumenCount(),
                'prodiTerakreditasi' => ProgramStudi::whereHas('akreditasi')->count(),
                'akreditasiAktif' => AkreditasiProdi::where('tanggal_berakhir', '>', now())->count(),
                'akreditasiUnggul' => AkreditasiProdi::where('status_akreditasi', 'Unggul')->where('tanggal_berakhir', '>', now())->count(),
                'akreditasiBaikSekali' => AkreditasiProdi::where('status_akreditasi', 'Baik Sekali')->where('tanggal_berakhir', '>', now())->count(),
                'recentDocuments' => $this->getRecentDocuments($request->get('search')),
            ];
        } catch (\Exception $e) {
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

        $data['user'] = $user;
        $data['debugSession'] = $debugSession;

        return view('asesor.dashboard', $data);
    }

    /**
     * Get dokumen count safely
     */
    private function getSafeDokumenCount()
    {
        try {
            if (method_exists(Dokumen::class, 'scopeAccessibleByAsesor')) {
                return Dokumen::accessibleByAsesor()->count();
            }

            // Fallback: just count active documents
            return Dokumen::where('is_active', true)->count();
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

            // Apply accessibility filter
            if (method_exists(Dokumen::class, 'scopeAccessibleByAsesor')) {
                $query->accessibleByAsesor();
            } else {
                $query->where('is_active', true);
            }

            // Apply search if provided
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")->orWhere('kategori', 'like', "%{$search}%");
                });
            }

            return $query
                ->with(['fakultas', 'programStudi'])
                ->latest()
                ->take(10)
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Display galeri listing
     */
    public function galeriIndex(Request $request)
    {
        $query = GaleriKegiatan::query()
            ->where('is_active', true)
            ->with(['programStudi', 'fakultas', 'creator']);

        // Filter by category
        if ($request->has('kategori') && $request->kategori != 'all') {
            $query->where('kategori', $request->kategori);
        }

        $galeri = $query->orderBy('tanggal_kegiatan', 'desc')->orderBy('urutan', 'asc')->paginate(12);

        $categories = [
            'all' => 'Semua',
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya',
        ];

        return view('asesor.galeri.index', compact('galeri', 'categories'));
    }

    /**
     * Display galeri detail
     */
    public function galeriDetail($id)
    {
        $galeri = GaleriKegiatan::where('is_active', true)
            ->with(['programStudi', 'fakultas', 'creator'])
            ->findOrFail($id);

        $relatedGaleri = GaleriKegiatan::where('is_active', true)->where('id', '!=', $galeri->id)->where('kategori', $galeri->kategori)->orderBy('tanggal_kegiatan', 'desc')->limit(6)->get();

        return view('asesor.galeri.show', compact('galeri', 'relatedGaleri'));
    }

    /**
     * Halaman dokumen institusi/universitas
     */
    public function dokumenInstitusi()
    {
        // Check access
        $this->checkAsesorAccess();

        try {
            // Debug query
            Log::info('Dokumen Institusi Query Debug', [
                'total_universitas_docs' => Dokumen::where('level', 'universitas')->count(),
                'active_universitas_docs' => Dokumen::where('level', 'universitas')->where('is_active', true)->count(),
                'visible_universitas_docs' => Dokumen::where('level', 'universitas')->where('is_visible_to_asesor', true)->count(),
            ]);

            $query = Dokumen::where('level', 'universitas')->where('is_active', true);

            // If user is GJM, show all active documents
            $user = Auth::user();
            if ($user && $user->role !== 'gjm' && $user->role !== 'super_admin') {
                // For regular asesor, check visibility
                $query->where('is_visible_to_asesor', true);
            }

            $dokumen = $query->orderBy('kategori')->orderBy('created_at', 'desc')->get()->groupBy('kategori');

            // Debug result
            Log::info('Dokumen Institusi Result', [
                'categories' => $dokumen->keys()->toArray(),
                'total_docs' => $dokumen->flatten()->count(),
            ]);
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
            // Get all fakultas with their documents
            $fakultas = Fakultas::with([
                'dokumen' => function ($query) {
                    // Filter only fakultas level documents
                    $query->where('level', 'fakultas')->where('is_active', true);

                    // Check user role for visibility
                    $user = Auth::user();
                    if ($user && $user->role !== 'gjm' && $user->role !== 'super_admin') {
                        $query->where('is_visible_to_asesor', true);
                    }

                    $query->orderBy('kategori')->orderBy('created_at', 'desc');
                },
                'programStudi' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
                ->withCount([
                    'dokumen' => function ($query) {
                        $query->where('level', 'fakultas')->where('is_active', true);

                        $user = Auth::user();
                        if ($user && $user->role !== 'gjm' && $user->role !== 'super_admin') {
                            $query->where('is_visible_to_asesor', true);
                        }
                    },
                ])
                ->orderBy('nama')
                ->get();

            // Debug log
            Log::info('Dokumen Fakultas Debug', [
                'fakultas_count' => $fakultas->count(),
                'total_fakultas_docs' => Dokumen::where('level', 'fakultas')->count(),
                'active_fakultas_docs' => Dokumen::where('level', 'fakultas')->where('is_active', true)->count(),
            ]);
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
                    // Filter only prodi level documents
                    $query->where('level', 'prodi')->where('is_active', true);

                    // Check user role for visibility
                    $user = Auth::user();
                    if ($user && $user->role !== 'gjm' && $user->role !== 'super_admin') {
                        $query->where('is_visible_to_asesor', true);
                    }

                    $query->orderBy('kategori')->orderBy('created_at', 'desc');
                },
                'akreditasiAktif',
                'fakultas',
            ])
                ->withCount([
                    'dokumen' => function ($query) {
                        $query->where('level', 'prodi')->where('is_active', true);

                        $user = Auth::user();
                        if ($user && $user->role !== 'gjm' && $user->role !== 'super_admin') {
                            $query->where('is_visible_to_asesor', true);
                        }
                    },
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

    public function dokumenProdiDetail(ProgramStudi $programStudi)
    {
        // Check if program study is active
        if (!$programStudi->is_active) {
            abort(404, 'Program studi tidak ditemukan.');
        }

        // Load related data
        $programStudi->load(['fakultas', 'akreditasiAktif']);

        // Get documents that are public
        $dokumen = $programStudi->dokumen()->orderBy('kategori')->orderBy('nama')->get();

        return view('asesor.dokumen-prodi-detail', compact('programStudi', 'dokumen'));
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
            'dosenByJabatan' => Dosen::where('is_active', true)->select('jabatan_akademik', DB::raw('count(*) as total'))->groupBy('jabatan_akademik')->get(),
        ];

        return view('asesor.informasi-tambahan', $data);
    }

    //  * Halaman index berita dan pengumuman
    public function beritaIndex(Request $request)
    {
        // Check access
        $this->checkAsesorAccess();

        $kategori = $request->get('kategori', 'semua');
        $search = $request->get('search');

        $query = Berita::with(['user', 'programStudi.fakultas'])
            ->published()
            ->latest('tanggal_publikasi');

        // Filter by kategori
        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        // Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")->orWhere('konten', 'like', "%{$search}%");
            });
        }

        $berita = $query->paginate(12);

        return view('asesor.berita.index', compact('berita', 'kategori', 'search'));
    }

    /**
     * Halaman detail berita/pengumuman
     */
    public function beritaDetail($slug)
    {
        // Check access
        $this->checkAsesorAccess();

        $berita = Berita::with(['user', 'programStudi.fakultas'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related news
        $relatedBerita = Berita::with(['user', 'programStudi.fakultas'])
            ->published()
            ->where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->latest('tanggal_publikasi')
            ->take(3)
            ->get();

        return view('asesor.berita.detail', compact('berita', 'relatedBerita'));
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
