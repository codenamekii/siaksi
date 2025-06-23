<?php

namespace Database\Seeders;

use App\Models\TimGJM;
use App\Models\Fakultas;
use Illuminate\Database\Seeder;

class TimGJMSeeder extends Seeder
{
  public function run(): void
  {
    $fakultas = Fakultas::first();

    $timGJM = [
      [
        'nama' => 'Ir. Musrawati, S.T., M.Si',
        'jabatan' => 'Ketua GJM',
        'nuptk' => '197001011995031001',
        'email' => 'ahmad.fauzi@fakultas.ac.id',
        'telepon' => '081234567890',
        'urutan' => 1
      ],
      [
        'nama' => 'Dr. Siti Aminah, M.Sc',
        'jabatan' => 'Sekretaris GJM',
        'nuptk' => '197505151999032001',
        'email' => 'siti.aminah@fakultas.ac.id',
        'telepon' => '081234567891',
        'urutan' => 2
      ],
      [
        'nama' => 'Ir. Bambang Sutrisno, M.T',
        'jabatan' => 'Koordinator Bidang Akademik',
        'nuptk' => '196808081993031001',
        'email' => 'bambang.sutrisno@fakultas.ac.id',
        'telepon' => '081234567892',
        'urutan' => 3
      ],
      [
        'nama' => 'Dr. Ratna Dewi, M.M',
        'jabatan' => 'Koordinator Bidang Kemahasiswaan',
        'nuptk' => '197212121997032001',
        'email' => 'ratna.dewi@fakultas.ac.id',
        'telepon' => '081234567893',
        'urutan' => 4
      ],
      [
        'nama' => 'Dr. Hendra Gunawan, M.Si',
        'jabatan' => 'Koordinator Bidang Penelitian',
        'nuptk' => '197606162000031001',
        'email' => 'hendra.gunawan@fakultas.ac.id',
        'telepon' => '081234567894',
        'urutan' => 5
      ]
    ];

    foreach ($timGJM as $anggota) {
      TimGJM::create(array_merge($anggota, [
        'fakultas_id' => $fakultas->id,
        'is_active' => true
      ]));
    }
  }
}
