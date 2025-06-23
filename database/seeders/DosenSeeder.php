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


    $bidangKeahlian = [
      'Rekayasa Perangkat Lunak',
      'Jaringan Komputer',
      'Kecerdasan Buatan',
      'Pencitraan Digital',
      'Multimedia',
      'Sistem Cerdas',
      'Data Mining',
      'Mobile Computing',
      'cybersecurity',
    ];

    $dosens = Dosen::all();
    foreach ($dosens as $index => $dosen) {
      $dosen->update([
        'bidang_keahlian' => $bidangKeahlian[$index % count($bidangKeahlian)]
      ]);
    }
    // Dosen Prodi TI
    $dosenTI = [
      [
        'nuptk' => '197001011995031001',
        'nidn' => '0001017001',
        'nama' => 'Prof. Dr. Ir. Sutrisno, M.T',
        'jabatan_akademik' => 'Profesor',
        'pendidikan_terakhir' => 'S3 Teknik Industri'
      ],
      [
        'nuptk' => '197505151999032001',
        'nidn' => '0015057501',
        'nama' => 'Dr. Siti Aminah, M.Sc',
        'jabatan_akademik' => 'Lektor Kepala',
        'pendidikan_terakhir' => 'S3 Teknik Industri'
      ],
      [
        'nuptk' => '198001012005011001',
        'nidn' => '0001018001',
        'nama' => 'Dr. Budi Santoso, M.T',
        'jabatan_akademik' => 'Lektor',
        'pendidikan_terakhir' => 'S3 Teknik Industri'
      ]
    ];

    foreach ($dosenTI as $dosen) {
      Dosen::updateOrCreate(
        ['nuptk' => $dosen['nuptk']],
        array_merge($dosen, [
          'program_studi_id' => $prodiTI->id,
          'email' => strtolower(str_replace([' ', '.', ','], '', $dosen['nama'])) . '@ti.fakultas.ac.id',
          'is_active' => true
        ])
      );
    }

    // Dosen Prodi SI
    $dosenTF = [
      [
        'nuptk' => '198505052010012001',
        'nidn' => '0005058501',
        'nama' => 'Dr. Dewi Anggraini, M.Si',
        'jabatan_akademik' => 'Lektor',
        'pendidikan_terakhir' => 'S3 Teknik Informatika'
      ],
      [
        'nuptk' => '198808082015031001',
        'nidn' => '0008088801',
        'nama' => 'Fahri Rahman, M.M',
        'jabatan_akademik' => 'Asisten Ahli',
        'pendidikan_terakhir' => 'S2 Informatika'
      ]
    ];

    foreach ($dosenTF as $dosen) {
      Dosen::updateOrCreate(
        ['nuptk' => $dosen['nuptk']],
        array_merge($dosen, [
          'program_studi_id' => $prodiTF->id,
          'email' => strtolower(str_replace([' ', '.', ','], '', $dosen['nama'])) . '@tf.fakultas.ac.id',
          'is_active' => true
        ])
      );
    }

    // Dosen Prodi Elektro
    $dosenTE = [
      [
          'nuptk' => '198210102008011001',
          'nidn' => '0010108201',
          'nama' => 'Dr. Eko Prasetyo, M.T',
          'jabatan_akademik' => 'Lektor',
          'pendidikan_terakhir' => 'S3 Teknik Elektro',
        ],
        [
          'nuptk' => '199001012015032001',
          'nidn' => '0001019001',
          'nama' => 'Sari Indah, M.T',
          'jabatan_akademik' => 'Asisten Ahli',
          'pendidikan_terakhir' => 'S2 Teknik Elektro',
        ]
    ];

    foreach ($dosenTE as $dosen) {
      Dosen::updateOrCreate(
        ['nuptk' => $dosen['nuptk']],
        array_merge($dosen, [
          'program_studi_id' => $prodiTE->id,
          'email' => strtolower(str_replace([' ', '.', ','], '', $dosen['nama'])) . '@te.fakultas.ac.id',
          'is_active' => true
        ])
      );
    }
  }
}