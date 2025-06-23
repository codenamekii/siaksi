<?php

namespace App\Http\Controllers\Asesor;

use App\Http\Controllers\Controller;
use App\Models\GaleriKegiatan;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Display a listing of galeri.
     */
    public function index(Request $request)
    {
        $query = GaleriKegiatan::query()
            ->where('is_active', true)
            ->with(['programStudi', 'fakultas', 'creator']);

        // Filter by category if provided
        if ($request->has('kategori') && $request->kategori != 'all') {
            $query->where('kategori', $request->kategori);
        }

        // Filter by level if provided
        if ($request->has('level') && $request->level != 'all') {
            $query->where('level', $request->level);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $galeri = $query->orderBy('tanggal_kegiatan', 'desc')->orderBy('urutan', 'asc')->paginate(12);

        $categories = [
            'all' => 'Semua',
            'kegiatan' => 'Kegiatan',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'lainnya' => 'Lainnya',
        ];

        $levels = [
            'all' => 'Semua Level',
            'universitas' => 'Universitas',
            'fakultas' => 'Fakultas',
            'prodi' => 'Program Studi',
        ];

        return view('asesor.galeri.index', compact('galeri', 'categories', 'levels'));
    }

    /**
     * Display the specified galeri item.
     */
    public function show($id)
    {
        $galeri = GaleriKegiatan::where('is_active', true)
            ->with(['programStudi', 'fakultas', 'creator'])
            ->findOrFail($id);

        // Get related galeri
        $relatedGaleri = GaleriKegiatan::where('is_active', true)
            ->where('id', '!=', $galeri->id)
            ->where(function ($query) use ($galeri) {
                $query->where('kategori', $galeri->kategori)->orWhere('program_studi_id', $galeri->program_studi_id)->orWhere('fakultas_id', $galeri->fakultas_id);
            })
            ->orderBy('tanggal_kegiatan', 'desc')
            ->limit(6)
            ->get();

        return view('asesor.galeri.show', compact('galeri', 'relatedGaleri'));
    }
}
