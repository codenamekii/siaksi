<?php

namespace Database\Seeders;

use App\Models\TenagaKependidikan;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class TenagaKependidikanSeeder extends Seeder
{
  public function run(): void
  {
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();
    $prodiTS = ProgramStudi::where('kode', 'TS')->first();

    // Tendik Prodi TI
    TenagaKependidikan::create([
      'program_studi_id' => $prodiTI->id,
      'nuptk' => '199201012018011001',
      'nama' => 'Ahmad Yusuf',
      'jabatan' => 'Staf Administrasi',
      'unit_kerja' => 'Program Studi TI',
      'pendidikan_terakhir' => 'S1 Administrasi',
      'email' => 'ahmad.yusuf@ti.fakultas.ac.id',
      'is_active' => true
    ]);

    TenagaKependidikan::create([
      'program_studi_id' => $prodiTI->id,
      'nuptk' => '199505052019032001',
      'nama' => 'Rina Susanti',
      'jabatan' => 'Laboran',
      'unit_kerja' => 'Laboratorium TI',
      'pendidikan_terakhir' => 'S1 Teknik Informatika',
      'email' => 'rina.susanti@ti.fakultas.ac.id',
      'is_active' => true
    ]);

    // Tendik Prodi SI
    TenagaKependidikan::create([
      'program_studi_id' => $prodiTS->id,
      'nuptk' => '199303032018031001',
      'nama' => 'Budi Hartono',
      'jabatan' => 'Staf Administrasi',
      'unit_kerja' => 'Program Studi SI',
      'pendidikan_terakhir' => 'S1 Manajemen',
      'email' => 'budi.hartono@si.fakultas.ac.id',
      'is_active' => true
    ]);

    // Tendik Prodi IF
    TenagaKependidikan::create([
      'program_studi_id' => $prodiTF->id,
      'nuptk' => '199404042019011001',
      'nama' => 'Deni Firmansyah',
      'jabatan' => 'Teknisi Laboratorium',
      'unit_kerja' => 'Laboratorium IF',
      'pendidikan_terakhir' => 'D3 Teknik Komputer',
      'email' => 'deni.firmansyah@if.fakultas.ac.id',
      'is_active' => true
    ]);
  }
}
