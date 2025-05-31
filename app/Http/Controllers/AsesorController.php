<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\ProgramStudi;
use App\Models\Fakultas;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    public function dashboard()
    {
        $data = [
            'total_fakultas' => Fakultas::count(),
            'total_prodi' => ProgramStudi::where('is_active', true)->count(),
            'total_dokumen' => Dokumen::visibleToAsesor()->count(),
            'dokumen_terbaru' => Dokumen::visibleToAsesor()->latest()->take(5)->get(),
        ];

        return view('asesor.dashboard', $data);
    }

    public function dokumenInstitusi()
    {
        $dokumen = Dokumen::where('level', 'universitas')->visibleToAsesor()->get()->groupBy('kategori');

        return view('asesor.dokumen-institusi', compact('dokumen'));
    }

    public function dokumenFakultas()
    {
        $fakultas = Fakultas::with([
            'dokumen' => function ($query) {
                $query->visibleToAsesor();
            },
        ])->get();

        return view('asesor.dokumen-fakultas', compact('fakultas'));
    }

    public function dokumenProdi()
    {
        $programStudi = ProgramStudi::with([
            'dokumen' => function ($query) {
                $query->visibleToAsesor();
            },
            'akreditasiAktif',
        ])
            ->where('is_active', true)
            ->get();

        return view('asesor.dokumen-prodi', compact('programStudi'));
    }

    public function informasiTambahan()
    {
        $data = [
            'dosen' => Dosen::with('programStudi')->where('is_active', true)->get(),
            'tendik' => TenagaKependidikan::with('programStudi')->where('is_active', true)->get(),
            'prodi' => ProgramStudi::where('is_active', true)->get(),
        ];

        return view('asesor.informasi-tambahan', $data);
    }
}
