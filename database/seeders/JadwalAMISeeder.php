<?php

namespace Database\Seeders;

use App\Models\JadwalAMI;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class JadwalAMISeeder extends Seeder
{
  public function run(): void
  {
    $fakultas = Fakultas::first();
    $prodiTI = ProgramStudi::where('kode', 'TI')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();

    // Jadwal AMI Fakultas
    JadwalAMI::create([
      'fakultas_id' => $fakultas->id,
      'nama_kegiatan' => 'Audit Mutu Internal Fakultas Teknik',
      'deskripsi' => 'AMI untuk evaluasi implementasi SPMI di tingkat fakultas',
      'tanggal_mulai' => '2024-06-15',
      'tanggal_selesai' => '2024-06-17',
      'tempat' => 'Ruang Rapat Dekanat',
      'status' => 'scheduled'
    ]);

    // Jadwal AMI Prodi
    JadwalAMI::create([
      'fakultas_id' => $fakultas->id,
      // 'program_studi_id' => $prodiTF->id,
      'nama_kegiatan' => 'AMI Program Studi Teknik Informatika',
      'deskripsi' => 'Audit mutu internal prodi TF',
      'tanggal_mulai' => '2024-06-20',
      'tanggal_selesai' => '2024-06-21',
      'tempat' => 'Ruang Prodi TF',
      'status' => 'scheduled'
    ]);

    JadwalAMI::create([
      'fakultas_id' => $fakultas->id,
      // 'program_studi_id' => $prodiTI->id,
      'nama_kegiatan' => 'AMI Program Studi Teknik Industri',
      'deskripsi' => 'Audit mutu internal prodi TI',
      'tanggal_mulai' => '2024-06-22',
      'tanggal_selesai' => '2024-06-23',
      'tempat' => 'Ruang Prodi TI',
      'status' => 'scheduled'
    ]);

    JadwalAMI::create([
      'fakultas_id' => $fakultas->id,
      // 'program_studi_id' => $prodiTF->id,
      'nama_kegiatan' => 'AMI Program Studi Teknik Informatika',
      'deskripsi' => 'Audit mutu internal prodi TF',
      'tanggal_mulai' => '2024-06-24',
      'tanggal_selesai' => '2024-06-25',
      'tempat' => 'Ruang Prodi TF',
      'status' => 'scheduled'
    ]);
  }
}
