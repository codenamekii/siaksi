<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\User;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class DokumenSeeder extends Seeder
{
  public function run(): void
  {
    $gjm = User::where('role', 'gjm')->first();
    $ujmTI = User::where('email', 'ujm.ti@fakultas.ac.id')->first();
    $ujmTF = User::where('email', 'ujm.tf@fakultas.ac.id')->first();
    $fakultas = Fakultas::first();
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();

    // Dokumen Universitas
    Dokumen::create([
      'user_id' => $gjm->id,
      'nama' => 'Kebijakan SPMI Universitas',
      'deskripsi' => 'Dokumen kebijakan Sistem Penjaminan Mutu Internal tingkat universitas',
      'tipe' => 'file',
      'path' => 'dokumen/universitas/kebijakan-spmi-universitas.pdf',
      'kategori' => 'kebijakan_mutu',
      'level' => 'universitas',
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    // Dokumen Fakultas
    Dokumen::create([
      'user_id' => $gjm->id,
      'nama' => 'Kebijakan Mutu Fakultas Teknik',
      'deskripsi' => 'Dokumen kebijakan mutu Fakultas Teknik tahun 2024',
      'tipe' => 'file',
      'path' => 'dokumen/fakultas/kebijakan-mutu-ft-2024.pdf',
      'kategori' => 'kebijakan_mutu',
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    Dokumen::create([
      'user_id' => $gjm->id,
      'nama' => 'Standar Mutu Fakultas Teknik',
      'deskripsi' => 'Standar mutu pendidikan, penelitian, dan pengabdian',
      'tipe' => 'file',
      'path' => 'dokumen/fakultas/standar-mutu-ft.pdf',
      'kategori' => 'standar_mutu',
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    Dokumen::create([
      'user_id' => $gjm->id,
      'nama' => 'Prosedur AMI Fakultas',
      'deskripsi' => 'Prosedur pelaksanaan Audit Mutu Internal',
      'tipe' => 'file',
      'path' => 'dokumen/fakultas/prosedur-ami.pdf',
      'kategori' => 'prosedur',
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'kriteria' => 'Tata Kelola',
      'sub_kriteria' => 'Sistem Penjaminan Mutu',
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    // Dokumen Prodi TI
    Dokumen::create([
      'user_id' => $ujmTI->id,
      'nama' => 'Laporan Kinerja Program Studi TI 2023',
      'deskripsi' => 'LKPS Teknik Informatika tahun 2023',
      'tipe' => 'file',
      'path' => 'dokumen/prodi/ti/lkps-ti-2023.pdf',
      'kategori' => 'lkps',
      'level' => 'prodi',
      'program_studi_id' => $prodiTI->id,
      'kriteria' => 'Kinerja',
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    Dokumen::create([
      'user_id' => $ujmTI->id,
      'nama' => 'Evaluasi Diri Program Studi TI',
      'deskripsi' => 'LED Teknik Informatika 2024',
      'tipe' => 'file',
      'path' => 'dokumen/prodi/ti/led-ti-2024.pdf',
      'kategori' => 'evaluasi_diri',
      'level' => 'prodi',
      'program_studi_id' => $prodiTI->id,
      'kriteria' => 'Evaluasi',
      'sub_kriteria' => 'Analisis SWOT',
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    // Dokumen Prodi SI
    Dokumen::create([
      'user_id' => $ujmTF->id,
      'nama' => 'Kurikulum Program Studi SI',
      'deskripsi' => 'Struktur kurikulum dan mata kuliah',
      'tipe' => 'file',
      'path' => 'dokumen/prodi/si/kurikulum-si.pdf',
      'kategori' => 'kurikulum',
      'level' => 'prodi',
      'program_studi_id' => $prodiTF->id,
      'kriteria' => 'Pendidikan',
      'sub_kriteria' => 'Kurikulum',
      'is_visible_to_asesor' => true,
      'is_active' => true
    ]);

    Dokumen::create([
      'user_id' => $ujmTF->id,
      'nama' => 'Laporan Hasil AMI Prodi SI',
      'deskripsi' => 'Hasil audit mutu internal 2023',
      'tipe' => 'file',
      'path' => 'dokumen/prodi/si/hasil-ami-2023.pdf',
      'kategori' => 'laporan_ami',
      'level' => 'prodi',
      'program_studi_id' => $prodiTF->id,
      'is_visible_to_asesor' => false,
      'is_active' => true
    ]);
  }
}
