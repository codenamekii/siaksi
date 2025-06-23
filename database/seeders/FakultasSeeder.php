<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    public function run(): void
    {
        Fakultas::updateOrCreate(
            ['kode' => 'FT'], // kunci unik
            [
                'nama' => 'Fakultas Teknik',
                'visi' => 'Menjadi fakultas teknik yang unggul dalam pengembangan ilmu pengetahuan dan teknologi yang berwawasan lingkungan dan berkarakter pada tahun 2030.',
                'misi' => 'Menyelenggarakan pendidikan tinggi yang berkualitas dalam bidang teknik. Melaksanakan penelitian yang inovatif dan bermanfaat bagi masyarakat. Melaksanakan pengabdian kepada masyarakat berbasis teknologi tepat guna.',
                'tujuan' => 'Menghasilkan lulusan yang kompeten dan berkarakter. Menghasilkan penelitian yang berkontribusi pada pengembangan IPTEK. Meningkatkan peran serta dalam pembangunan masyarakat.',
                'dekan' => 'Dr. Ir. Saripuddin M., ST., MT',
                'alamat' => 'Jl. Kampus No. 1, Kota Universitas',
                'telepon' => '(021) 1234567',
                'email' => 'ft@universitas.ac.id',
                'website' => 'https://ft.universitas.ac.id',
            ],
        );
    }
}
