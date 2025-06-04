<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Dokumen;
use App\Models\AkreditasiProdi;
use App\Models\User;

class QuickAsesorDataSeeder extends Seeder
{
  public function run()
  {
    $this->command->info('Creating quick data for Asesor dashboard...');

    // 1. Ensure we have at least one fakultas
    $fakultas = Fakultas::first();
    if (!$fakultas) {
      $fakultas = Fakultas::create([
        'nama' => 'Fakultas Teknologi Informasi',
        'kode' => 'FTI',
        'deskripsi' => 'Fakultas yang mengelola program studi di bidang teknologi informasi'
      ]);
      $this->command->info('✅ Created fakultas');
    }

    // 2. Ensure we have at least one program studi
    $prodi = ProgramStudi::first();
    if (!$prodi) {
      $prodi = ProgramStudi::create([
        'fakultas_id' => $fakultas->id,
        'nama' => 'Teknik Informatika',
        'kode' => 'TI',
        'jenjang' => 'S1',
        'is_active' => true
      ]);
      $this->command->info('✅ Created program studi');
    }

    // 3. Create some akreditasi data
    $akreditasiCount = AkreditasiProdi::count();
    if ($akreditasiCount == 0) {
      AkreditasiProdi::create([
        'program_studi_id' => $prodi->id,
        'lembaga_akreditasi' => 'BAN-PT',
        'status_akreditasi' => 'Unggul',
        'nilai_akreditasi' => 361,
        'tanggal_akreditasi' => now()->subYear(),
        'tanggal_berakhir' => now()->addYears(4),
        'nomor_sk' => 'SK/123/BAN-PT/2024',
        'is_active' => true
      ]);

      // Create one more with different status
      if (ProgramStudi::count() > 1) {
        $prodi2 = ProgramStudi::skip(1)->first();
        AkreditasiProdi::create([
          'program_studi_id' => $prodi2->id,
          'lembaga_akreditasi' => 'BAN-PT',
          'status_akreditasi' => 'Baik Sekali',
          'nilai_akreditasi' => 340,
          'tanggal_akreditasi' => now()->subMonths(6),
          'tanggal_berakhir' => now()->addYears(4)->addMonths(6),
          'nomor_sk' => 'SK/456/BAN-PT/2024',
          'is_active' => true
        ]);
      }
      $this->command->info('✅ Created akreditasi data');
    }

    // 4. Create some visible documents
    $visibleDocs = Dokumen::where('is_visible_to_asesor', true)->count();
    if ($visibleDocs == 0) {
      // Get a user (preferably GJM)
      $user = User::where('role', 'gjm')->first() ?? User::first();

      // Universitas level documents
      Dokumen::create([
        'user_id' => $user->id,
        'nama' => 'Kebijakan SPMI Universitas',
        'deskripsi' => 'Dokumen kebijakan sistem penjaminan mutu internal universitas',
        'tipe' => 'file',
        'kategori' => 'kebijakan_mutu',
        'level' => 'universitas',
        'is_visible_to_asesor' => true,
        'is_active' => true
      ]);

      Dokumen::create([
        'user_id' => $user->id,
        'nama' => 'Standar Mutu Pendidikan',
        'deskripsi' => 'Standar mutu untuk proses pendidikan di universitas',
        'tipe' => 'file',
        'kategori' => 'standar_mutu',
        'level' => 'universitas',
        'is_visible_to_asesor' => true,
        'is_active' => true
      ]);

      // Fakultas level documents
      Dokumen::create([
        'user_id' => $user->id,
        'nama' => 'Laporan AMI Fakultas 2024',
        'deskripsi' => 'Laporan hasil audit mutu internal fakultas',
        'tipe' => 'file',
        'kategori' => 'laporan_ami',
        'level' => 'fakultas',
        'fakultas_id' => $fakultas->id,
        'periode' => 'genap',
        'tahun' => 2024,
        'is_visible_to_asesor' => true,
        'is_active' => true
      ]);

      // Prodi level documents
      Dokumen::create([
        'user_id' => $user->id,
        'nama' => 'LKPS Teknik Informatika 2024',
        'deskripsi' => 'Laporan Kinerja Program Studi Teknik Informatika',
        'tipe' => 'file',
        'kategori' => 'lkps',
        'level' => 'prodi',
        'program_studi_id' => $prodi->id,
        'tahun' => 2024,
        'is_visible_to_asesor' => true,
        'is_active' => true
      ]);

      Dokumen::create([
        'user_id' => $user->id,
        'nama' => 'LED Teknik Informatika 2024',
        'deskripsi' => 'Laporan Evaluasi Diri Program Studi',
        'tipe' => 'file',
        'kategori' => 'evaluasi_diri',
        'level' => 'prodi',
        'program_studi_id' => $prodi->id,
        'tahun' => 2024,
        'is_visible_to_asesor' => true,
        'is_active' => true
      ]);

      $this->command->info('✅ Created visible documents for asesor');
    }

    // 5. Make some existing documents visible if none are visible
    if ($visibleDocs == 0 && Dokumen::count() > 5) {
      Dokumen::inRandomOrder()
        ->limit(10)
        ->update(['is_visible_to_asesor' => true]);
      $this->command->info('✅ Made 10 random documents visible to asesor');
    }

    $this->command->info('✅ Quick data seeding completed!');
  }
}