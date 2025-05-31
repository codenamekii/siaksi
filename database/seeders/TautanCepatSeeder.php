<?php

namespace Database\Seeders;

use App\Models\TautanCepat;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class TautanCepatSeeder extends Seeder
{
  public function run(): void
  {
    $fakultas = Fakultas::first();
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTE = ProgramStudi::where('kode', 'TE')->first();

    // Tautan Cepat Fakultas
    TautanCepat::create([
      'nama' => 'Kebijakan Mutu Fakultas',
      'url' => 'https://ft.universitas.ac.id/kebijakan-mutu',
      'icon' => 'document',
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'urutan' => 1,
      'is_active' => true
    ]);

    TautanCepat::create([
      'nama' => 'Jadwal AMI Fakultas',
      'url' => 'https://ft.universitas.ac.id/jadwal-ami',
      'icon' => 'calendar',
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'urutan' => 2,
      'is_active' => true
    ]);

    TautanCepat::create([
      'nama' => 'Kontak GJM',
      'url' => 'https://ft.universitas.ac.id/kontak-gjm',
      'icon' => 'phone',
      'level' => 'fakultas',
      'fakultas_id' => $fakultas->id,
      'urutan' => 3,
      'is_active' => true
    ]);

    // Tautan Cepat Prodi TI
    TautanCepat::create([
      'nama' => 'Kebijakan Mutu Prodi TI',
      'url' => 'https://ti.ft.universitas.ac.id/kebijakan-mutu',
      'icon' => 'document',
      'level' => 'prodi',
      'program_studi_id' => $prodiTI->id,
      'urutan' => 1,
      'is_active' => true
    ]);

    TautanCepat::create([
      'nama' => 'Kontak UJM TI',
      'url' => 'https://ti.ft.universitas.ac.id/kontak-ujm',
      'icon' => 'phone',
      'level' => 'prodi',
      'program_studi_id' => $prodiTI->id,
      'urutan' => 2,
      'is_active' => true
    ]);

    // Tautan Cepat Prodi SI
    TautanCepat::create([
      'nama' => 'Kebijakan Mutu Prodi SI',
      'url' => 'https://si.ft.universitas.ac.id/kebijakan-mutu',
      'icon' => 'document',
      'level' => 'prodi',
      'program_studi_id' => $prodiTE->id,
      'urutan' => 1,
      'is_active' => true
    ]);
  }
}
