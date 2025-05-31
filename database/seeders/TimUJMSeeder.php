<?php

namespace Database\Seeders;

use App\Models\TimUJM;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class TimUJMSeeder extends Seeder
{
  public function run(): void
  {
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();
    $prodiTM = ProgramStudi::where('kode', 'TM')->first();
    $prodiTE = ProgramStudi::where('kode', 'TE')->first();
    $prodiTS = ProgramStudi::where('kode', 'TS')->first();

    // Tim UJM Prodi TI
    $timUJMTI = [
      [
        'nama' => 'Dr. Budi Santoso, M.T',
        'jabatan' => 'Ketua UJM',
        'nuptk' => '198001012005011001',
        'email' => 'budi.santoso@ti.fakultas.ac.id',
        'urutan' => 1
      ],
      [
        'nama' => 'Rina Wulandari, M.Kom',
        'jabatan' => 'Sekretaris UJM',
        'nuptk' => '198505052010012001',
        'email' => 'rina.wulandari@ti.fakultas.ac.id',
        'urutan' => 2
      ],
      [
        'nama' => 'Agus Prasetyo, M.T',
        'jabatan' => 'Anggota',
        'nuptk' => '198210102008011001',
        'email' => 'agus.prasetyo@ti.fakultas.ac.id',
        'urutan' => 3
      ]
    ];

    foreach ($timUJMTI as $anggota) {
      TimUJM::create(array_merge($anggota, [
        'program_studi_id' => $prodiTI->id,
        'is_active' => true
      ]));
    }

    // Tim UJM Prodi SI
    $timUJMTF = [
      [
        'nama' => 'Dr. Dewi Anggraini, M.Si',
        'jabatan' => 'Ketua UJM',
        'nuptk' => '198505052010012001',
        'email' => 'dewi.anggraini@si.fakultas.ac.id',
        'urutan' => 1
      ],
      [
        'nama' => 'Fahri Rahman, M.M',
        'jabatan' => 'Sekretaris UJM',
        'nuptk' => '198808082015031001',
        'email' => 'fahri.rahman@si.fakultas.ac.id',
        'urutan' => 2
      ]
    ];

    foreach ($timUJMTF as $anggota) {
      TimUJM::create(array_merge($anggota, [
        'program_studi_id' => $prodiTF->id,
        'is_active' => true
      ]));
    }

    // Tim UJM Prodi IF
    $timUJMTM = [
      [
        'nama' => 'Dr. Eko Prasetyo, M.Kom',
        'jabatan' => 'Ketua UJM',
        'nuptk' => '198210102008011001',
        'email' => 'eko.prasetyo@if.fakultas.ac.id',
        'urutan' => 1
      ],
      [
        'nama' => 'Sari Indah, M.T',
        'jabatan' => 'Sekretaris UJM',
        'nuptk' => '199001012015032001',
        'email' => 'sari.indah@if.fakultas.ac.id',
        'urutan' => 2
      ]
    ];

    foreach ($timUJMTM as $anggota) {
      TimUJM::create(array_merge($anggota, [
        'program_studi_id' => $prodiTM->id,
        'is_active' => true
      ]));
    }
  }
}
