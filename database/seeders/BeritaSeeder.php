<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
        Berita::updateOrCreate(
            [
                'slug' => Str::slug('Lokakarya Peningkatan Mutu Pembelajaran Daring'),
            ],
            [
                'created_by' => $ujmTM->id,
                'updated_by' => $ujmTM->id,
                'judul' => 'Lokakarya Peningkatan Mutu Pembelajaran Daring',
                'konten' => 'Program Studi Teknik Informatika mengadakan lokakarya untuk meningkatkan kualitas pembelajaran daring. Kegiatan ini diikuti oleh seluruh dosen dan tenaga kependidikan.',
                'kategori' => 'berita',
                'status' => 'published',
                'program_studi_id' => $prodiTM->id,
                'tanggal_publikasi' => now()->subDays(7),
            ],
        );

        Berita::updateOrCreate(
            [
                'slug' => Str::slug('Pengumuman Jadwal Audit Mutu Internal Semester Genap'),
            ],
            [
                'created_by' => $gjm->id,
                'updated_by' => $gjm->id,
                'judul' => 'Pengumuman Jadwal Audit Mutu Internal Semester Genap',
                'konten' => 'Audit Mutu Internal (AMI) semester genap akan dilaksanakan pada tanggal 15-30 Juni 2024. Seluruh program studi dimohon untuk mempersiapkan dokumen-dokumen yang diperlukan.',
                'kategori' => 'pengumuman',
                'status' => 'published',
                'tanggal_publikasi' => now()->subDays(3),
            ],
        );

        // Berita Prodi TM
        Berita::updateOrCreate(
            [
                'slug' => Str::slug('Lokakarya Peningkatan Mutu Pembelajaran Daring'),
            ],
            [
                'created_by' => $ujmTM->id,
                'updated_by' => $ujmTM->id,
                'judul' => 'Lokakarya Peningkatan Mutu Pembelajaran Daring',
                'konten' => 'Program Studi Teknik Informatika mengadakan lokakarya untuk meningkatkan kualitas pembelajaran daring. Kegiatan ini diikuti oleh seluruh dosen dan tenaga kependidikan.',
                'kategori' => 'berita',
                'status' => 'published',
                'program_studi_id' => $prodiTM->id,
                'tanggal_publikasi' => now()->subDays(7),
            ],
        );

        Berita::updateOrCreate(
            [
                'slug' => Str::slug('Survey Kepuasan Mahasiswa Semester Genap 2023/2024'),
            ],
            [
                'created_by' => $ujmTF->id,
                'updated_by' => $ujmTF->id,
                'judul' => 'Survey Kepuasan Mahasiswa Semester Genap 2023/2024',
                'konten' => 'Mahasiswa diminta untuk mengisi survey kepuasan terhadap layanan akademik dan pembelajaran. Link survey dapat diakses melalui sistem informasi akademik.',
                'kategori' => 'pengumuman',
                'status' => 'published',
                'program_studi_id' => $prodiTF->id,
                'tanggal_publikasi' => now()->subDays(1),
            ],
        );

        Berita::updateOrCreate(
            [
                'slug' => Str::slug('Rapat Evaluasi Capaian Pembelajaran Semester Ganjil'),
            ],
            [
                'created_by' => $ujmTF->id,
                'updated_by' => $ujmTF->id,
                'judul' => 'Rapat Evaluasi Capaian Pembelajaran Semester Ganjil',
                'konten' => 'Program Studi Sistem Informasi telah melaksanakan rapat evaluasi capaian pembelajaran semester ganjil. Hasil evaluasi menunjukkan peningkatan kualitas pembelajaran.',
                'kategori' => 'berita',
                'status' => 'published',
                'program_studi_id' => $prodiTF->id,
                'tanggal_publikasi' => now()->subDays(10),
            ],
        );
    }
}
