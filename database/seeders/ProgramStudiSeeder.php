<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
  public function run(): void
  {
    $fakultas = \App\Models\Fakultas::first();
    $ujmTF = User::where('email', 'ujm.tf@fakultas.ac.id')->first();
    $ujmTM = User::where('email', 'ujm.tm@fakultas.ac.id')->first();
    $ujmTI = User::where('email', 'ujm.ti@fakultas.ac.id')->first();
    $ujmTE = User::where('email', 'ujm.te@fakultas.ac.id')->first();
    $ujmTS = User::where('email', 'ujm.ts@fakultas.ac.id')->first();

    if (!$fakultas || !$ujmTF || !$ujmTM || !$ujmTE || !$ujmTS || !$ujmTI) {
      throw new \Exception('Fakultas atau salah satu UJM tidak ditemukan.');
    }

    ProgramStudi::create([
      'fakultas_id' => $fakultas->id,
      'ujm_id' => $ujmTF->id,
      'kode' => 'TF',
      'nama' => 'Teknik Informatika',
      'jenjang' => 'S1',
      'visi' => 'Menjadi program studi teknik informatika yang unggul dalam pengembangan teknologi informasi yang inovatif dan berkarakter.',
      'misi' => 'Menyelenggarakan pendidikan berkualitas dalam bidang informatika. Melakukan penelitian yang berkontribusi pada perkembangan TI. Mengembangkan kerjasama dengan industri.',
      'tujuan' => 'Menghasilkan lulusan yang kompeten di bidang TI. Menghasilkan karya penelitian yang bermanfaat. Meningkatkan kemitraan dengan stakeholder.',
      'kaprodi' => 'Dr. Andi Wijaya, M.T',
      'email' => 'ti@fakultas.ac.id',
      'telepon' => '(021) 1234568',
      'is_active' => true
    ]);

    ProgramStudi::create([
      'fakultas_id' => $fakultas->id,
      'ujm_id' => $ujmTM->id,
      'kode' => 'TM',
      'nama' => 'Teknik Mesin',
      'jenjang' => 'S1',
      'visi' => 'Menjadi program studi teknik mesin yang unggul dalam pengembangan teknologi rekayasa dan menghasilkan lulusan berdaya saing tinggi.',
      'misi' => 'Menyelenggarakan pendidikan teknik mesin yang aplikatif. Melakukan penelitian di bidang teknologi rekayasa. Menjalin kemitraan dengan industri dan lembaga riset.',
      'tujuan' => 'Menghasilkan lulusan yang kompeten di bidang teknik mesin. Mengembangkan inovasi teknologi untuk mendukung pembangunan. Memberikan kontribusi nyata bagi masyarakat.',
      'kaprodi' => 'Ir. Budi Santosa, M.T',
      'email' => 'tm@fakultas.ac.id',
      'telepon' => '(021) 1234570',
      'is_active' => true
    ]);


    ProgramStudi::create([
      'fakultas_id' => $fakultas->id,
      'ujm_id' => $ujmTI->id,
      'kode' => 'TI',
      'nama' => 'Teknik Industri',
      'jenjang' => 'S1',
      'visi' => 'Menjadi program studi informatika yang unggul dalam pengembangan ilmu komputer dan aplikasinya.',
      'misi' => 'Menyelenggarakan pendidikan informatika yang inovatif. Mengembangkan penelitian di bidang komputer. Menerapkan ilmu informatika untuk masyarakat.',
      'tujuan' => 'Menghasilkan lulusan yang menguasai ilmu komputer. Menghasilkan inovasi di bidang informatika. Berkontribusi pada pembangunan digital.',
      'kaprodi' => 'Dr. Fahmi Rahman, M.Kom',
      'email' => 'if@fakultas.ac.id',
      'telepon' => '(021) 1234570',
      'is_active' => true
    ]);


    ProgramStudi::create([
      'fakultas_id' => $fakultas->id,
      'ujm_id' => $ujmTE->id,
      'kode' => 'TE',
      'nama' => 'Teknik Elektro',
      'jenjang' => 'S1',
      'visi' => 'Menjadi program studi unggulan dalam pengembangan teknologi elektro yang berkelanjutan dan inovatif.',
      'misi' => 'Menyediakan pendidikan berkualitas di bidang teknik elektro. Melakukan riset terapan. Membangun jejaring kemitraan dengan industri dan lembaga nasional.',
      'tujuan' => 'Melahirkan sarjana elektro yang handal dan profesional. Mendorong penerapan teknologi elektro untuk kesejahteraan masyarakat.',
      'kaprodi' => 'Dr. Suryo Nugroho, M.Eng',
      'email' => 'te@fakultas.ac.id',
      'telepon' => '(021) 1234571',
      'is_active' => true
    ]);

    ProgramStudi::create([
      'fakultas_id' => $fakultas->id,
      'ujm_id' => $ujmTS->id,
      'kode' => 'TS',
      'nama' => 'Teknik Sipil',
      'jenjang' => 'S1',
      'visi' => 'Menjadi program studi teknik sipil terdepan dalam pembangunan infrastruktur berkelanjutan.',
      'misi' => 'Menyelenggarakan pendidikan teknik sipil yang relevan dengan kebutuhan zaman. Melakukan penelitian dan pengabdian masyarakat. Berkolaborasi dengan sektor konstruksi.',
      'tujuan' => 'Menghasilkan lulusan teknik sipil yang siap kerja. Memberikan kontribusi dalam pembangunan nasional melalui teknologi konstruksi.',
      'kaprodi' => 'Ir. Ratna Dewi, M.T',
      'email' => 'ts@fakultas.ac.id',
      'telepon' => '(021) 1234572',
      'is_active' => true
    ]);
  }
}