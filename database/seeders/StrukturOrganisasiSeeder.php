<?php

namespace Database\Seeders;

use App\Models\StrukturOrganisasi;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
  public function run(): void
  {
    $fakultas = Fakultas::first();
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();
    $prodiTM = ProgramStudi::where('kode', 'TM')->first();

    // Struktur Organisasi Fakultas
    StrukturOrganisasi::create([
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'gambar' => 'struktur/fakultas/struktur-ft.png',
      'judul' => 'Struktur Organisasi Fakultas Teknik',
      'deskripsi' => 'Struktur organisasi Fakultas Teknik periode 2023-2027',
      'is_active' => true
    ]);

    // Struktur Organisasi Prodi
    StrukturOrganisasi::create([
      'level' => 'prodi',
      'program_studi_id' => $prodiTI->id,
      'gambar' => 'struktur/prodi/struktur-ti.png',
      'judul' => 'Struktur Organisasi Prodi TI',
      'deskripsi' => 'Struktur organisasi Program Studi Teknik Informatika',
      'is_active' => true
    ]);

    StrukturOrganisasi::create([
      'level' => 'prodi',
      'program_studi_id' => $prodiTF->id,
      'gambar' => 'struktur/prodi/struktur-si.png',
      'judul' => 'Struktur Organisasi Prodi SI',
      'deskripsi' => 'Struktur organisasi Program Studi Sistem Informasi',
      'is_active' => true
    ]);

    StrukturOrganisasi::create([
      'level' => 'prodi',
      'program_studi_id' => $prodiTM->id,
      'gambar' => 'struktur/prodi/struktur-if.png',
      'judul' => 'Struktur Organisasi Prodi IF',
      'deskripsi' => 'Struktur organisasi Program Studi Informatika',
      'is_active' => true
    ]);
  }
}
