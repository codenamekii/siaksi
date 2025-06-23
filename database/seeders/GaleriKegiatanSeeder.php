<?php

namespace Database\Seeders;

use App\Models\GaleriKegiatan;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Database\Seeder;

class GaleriKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $prodiTI = ProgramStudi::where('kode', 'TI')->first();
        $ujm = User::where('role', 'ujm')->first();

        if ($prodiTI && $ujm) {
            $galeriData = [
                [
                    'judul' => 'Workshop Penjaminan Mutu Internal',
                    'deskripsi' => 'Kegiatan workshop PMI untuk meningkatkan pemahaman tentang standar mutu',
                    'gambar' => 'galeri/workshop-pmi.jpg',
                    'kategori' => 'kegiatan',
                    'tanggal_kegiatan' => now()->subDays(7),
                    'is_featured' => true,
                ],
                [
                    'judul' => 'Sosialisasi Akreditasi Program Studi',
                    'deskripsi' => 'Sosialisasi persiapan akreditasi untuk seluruh civitas akademika',
                    'gambar' => 'galeri/sosialisasi-akreditasi.jpg',
                    'kategori' => 'kegiatan',
                    'tanggal_kegiatan' => now()->subDays(14),
                ],
                [
                    'judul' => 'Audit Mutu Internal Semester Ganjil',
                    'deskripsi' => 'Pelaksanaan AMI untuk evaluasi capaian standar mutu',
                    'gambar' => 'galeri/ami-ganjil.jpg',
                    'kategori' => 'kegiatan',
                    'tanggal_kegiatan' => now()->subDays(30),
                ],
            ];

            foreach ($galeriData as $index => $data) {
                GaleriKegiatan::create(
                    array_merge($data, [
                        'level' => 'prodi',
                        'program_studi_id' => $prodiTI->id,
                        'created_by' => $ujm->id,
                        'urutan' => $index + 1,
                        'is_active' => true,
                    ]),
                );
            }
        }
    }
}
