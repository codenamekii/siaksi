<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
  public function run(): void
  {
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();
    $prodiTE = ProgramStudi::where('kode', 'TE')->first();

    // Dosen Prodi TI
    $dosenTI = [
      [
        'nuptk' => '197001011995031001',
        'nidn' => '0001017001',
        'nama' => 'Prof. Dr. Ir. Sutrisno, M.T',
        'jabatan_akademik' => 'Profesor',
        'pendidikan_terakhir' => 'S3 Teknik Informatika'
      ],
      [
        'nuptk' => '197505151999032001',
        'nidn' => '0015057501',
        'nama' => 'Dr. Siti Aminah, M.Sc',
        'jabatan_akademik' => 'Lektor Kepala',
        'pendidikan_terakhir' => 'S3 Ilmu Komputer'
      ],
      [
        'nuptk' => '198001012005011001',
        'nidn' => '0001018001',
        'nama' => 'Dr. Budi Santoso, M.T',
        'jabatan_akademik' => 'Lektor',
        'pendidikan_terakhir' => 'S3 Teknik Informatika'
      ]
    ];

    foreach ($dosenTI as $dosen) {
      Dosen::create(array_merge($dosen, [
        'program_studi_id' => $prodiTI->id,
        'email' => strtolower(str_replace([' ', '.', ','], '', $dosen['nama'])) . '@ti.fakultas.ac.id',
        'is_active' => true
      ]));
    }

    // Dosen Prodi SI
    $dosenTF = [
      [
        'nuptk' => '198505052010012001',
        'nidn' => '0005058501',
        'nama' => 'Dr. Dewi Anggraini, M.Si',
        'jabatan_akademik' => 'Lektor',
        'pendidikan_terakhir' => 'S3 Sistem Informasi'
      ],
      [
        'nuptk' => '198808082015031001',
        'nidn' => '0008088801',
        'nama' => 'Fahri Rahman, M.M',
        'jabatan_akademik' => 'Asisten Ahli',
        'pendidikan_terakhir' => 'S2 Manajemen'
      ]
    ];

    foreach ($dosenTF as $dosen) {
      Dosen::create(array_merge($dosen, [
        'program_studi_id' => $prodiTF->id,
        'email' => strtolower(str_replace([' ', '.', ','], '', $dosen['nama'])) . '@si.fakultas.ac.id',
        'is_active' => true
      ]));
    }

    // Dosen Prodi IF
    $dosenTE = [
      [
        'nuptk' => '198210102008011001',
        'nidn' => '0010108201',
        'nama' => 'Dr. Eko Prasetyo, M.Kom',
        'jabatan_akademik' => 'Lektor',
        'pendidikan_terakhir' => 'S3 Ilmu Komputer'
      ],
      [
        'nuptk' => '199001012015032001',
        'nidn' => '0001019001',
        'nama' => 'Sari Indah, M.T',
        'jabatan_akademik' => 'Asisten Ahli',
        'pendidikan_terakhir' => 'S2 Teknik Informatika'
      ]
    ];

    foreach ($dosenTE as $dosen) {
      Dosen::create(array_merge($dosen, [
        'program_studi_id' => $prodiTE->id,
        'email' => strtolower(str_replace([' ', '.', ','], '', $dosen['nama'])) . '@if.fakultas.ac.id',
        'is_active' => true
      ]));
    }
  }
}
