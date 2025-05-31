<?php

namespace Database\Seeders;

use App\Models\AkreditasiProdi;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class AkreditasiProdiSeeder extends Seeder
{
  public function run(): void
  {
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();
    $prodiTM = ProgramStudi::where('kode', 'TM')->first();
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTE = ProgramStudi::where('kode', 'TE')->first();
    $prodiTS = ProgramStudi::where('kode', 'TS')->first();

    if (!$prodiTF || !$prodiTM || !$prodiTI || !$prodiTE || !$prodiTS) {
      throw new \Exception('Salah satu program studi tidak ditemukan.');
    }

    $data = [
      [
        'program_studi_id' => $prodiTI->id,
        'lembaga_akreditasi' => 'BAN-PT',
        'status_akreditasi' => 'Unggul',
        'tanggal_akreditasi' => '2023-05-15',
        'tanggal_berakhir' => '2028-05-14',
        'nomor_sk' => '123/SK/BAN-PT/Ak/S/V/2023',
      ],
      [
        'program_studi_id' => $prodiTF->id,
        'lembaga_akreditasi' => 'LAM-Infokom',
        'status_akreditasi' => 'Baik Sekali',
        'tanggal_akreditasi' => '2022-08-20',
        'tanggal_berakhir' => '2027-08-19',
        'nomor_sk' => '456/SK/LAM-Infokom/Ak/S/VIII/2022',
      ],
      [
        'program_studi_id' => $prodiTM->id,
        'lembaga_akreditasi' => 'LAM-Teknik',
        'status_akreditasi' => 'Unggul',
        'tanggal_akreditasi' => '2024-03-10',
        'tanggal_berakhir' => '2029-03-09',
        'nomor_sk' => '789/SK/LAM-Teknik/Ak/S/III/2024',
      ],
      [
        'program_studi_id' => $prodiTE->id,
        'lembaga_akreditasi' => 'LAM-Teknik',
        'status_akreditasi' => 'Baik Sekali',
        'tanggal_akreditasi' => '2023-11-05',
        'tanggal_berakhir' => '2028-11-04',
        'nomor_sk' => '101/SK/LAM-Teknik/Ak/S/XI/2023',
      ],
      [
        'program_studi_id' => $prodiTS->id,
        'lembaga_akreditasi' => 'LAM-Teknik',
        'status_akreditasi' => 'Unggul',
        'tanggal_akreditasi' => '2022-01-15',
        'tanggal_berakhir' => '2027-01-14',
        'nomor_sk' => '055/SK/LAM-Teknik/Ak/S/I/2022',
      ],
    ];

    foreach ($data as $item) {
      AkreditasiProdi::create([
        ...$item,
        'sertifikat' => null,
        'is_active' => true,
      ]);
    }
  }
}
