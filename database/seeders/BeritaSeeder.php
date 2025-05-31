<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
  public function run(): void
  {
    $gjm = User::where('role', 'gjm')->first();
    $ujmTF = User::where('email', 'ujm.tf@fakultas.ac.id')->first();
    $ujmTM = User::where('email', 'ujm.tm@fakultas.ac.id')->first();
    $prodiTM = ProgramStudi::where('kode', 'TM')->first();
    $prodiTF = ProgramStudi::where('kode', 'TF')->first();

    // Berita Fakultas
    Berita::create([
      'user_id' => $gjm->id,
      'judul' => 'Workshop Penyusunan Borang Akreditasi Program Studi',
      'konten' => 'Fakultas Teknik menyelenggarakan workshop penyusunan borang akreditasi untuk seluruh program studi. Kegiatan ini bertujuan untuk meningkatkan kualitas dokumen akreditasi dan mempersiapkan visitasi asesor.',
      'kategori' => 'berita',
      'level' => 'fakultas',
      'is_published' => true,
      'published_at' => now()->subDays(5)
    ]);

    Berita::create([
      'user_id' => $gjm->id,
      'judul' => 'Pengumuman Jadwal Audit Mutu Internal Semester Genap',
      'konten' => 'Audit Mutu Internal (AMI) semester genap akan dilaksanakan pada tanggal 15-30 Juni 2024. Seluruh program studi dimohon untuk mempersiapkan dokumen-dokumen yang diperlukan.',
      'kategori' => 'pengumuman',
      'level' => 'fakultas',
      'is_published' => true,
      'published_at' => now()->subDays(3)
    ]);

    // Berita Prodi TI
    Berita::create([
      'user_id' => $ujmTM->id,
      'judul' => 'Lokakarya Peningkatan Mutu Pembelajaran Daring',
      'konten' => 'Program Studi Teknik Informatika mengadakan lokakarya untuk meningkatkan kualitas pembelajaran daring. Kegiatan ini diikuti oleh seluruh dosen dan tenaga kependidikan.',
      'kategori' => 'berita',
      'level' => 'prodi',
      'program_studi_id' => $prodiTM->id,
      'is_published' => true,
      'published_at' => now()->subDays(7)
    ]);

    Berita::create([
      'user_id' => $ujmTF->id,
      'judul' => 'Survey Kepuasan Mahasiswa Semester Genap 2023/2024',
      'konten' => 'Mahasiswa diminta untuk mengisi survey kepuasan terhadap layanan akademik dan pembelajaran. Link survey dapat diakses melalui sistem informasi akademik.',
      'kategori' => 'pengumuman',
      'level' => 'prodi',
      'program_studi_id' => $prodiTF->id,
      'is_published' => true,
      'published_at' => now()->subDays(1)
    ]);

    // Berita Prodi SI
    Berita::create([
      'user_id' => $ujmTF->id,
      'judul' => 'Rapat Evaluasi Capaian Pembelajaran Semester Ganjil',
      'konten' => 'Program Studi Sistem Informasi telah melaksanakan rapat evaluasi capaian pembelajaran semester ganjil. Hasil evaluasi menunjukkan peningkatan kualitas pembelajaran.',
      'kategori' => 'berita',
      'level' => 'prodi',
      'program_studi_id' => $prodiTF->id,
      'is_published' => true,
      'published_at' => now()->subDays(10)
    ]);
  }
}
