<?php

namespace Database\Seeders;

use App\Models\StrukturOrganisasi;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        $fakultas = Fakultas::first();
        $prodiTI = ProgramStudi::where('kode', 'TI')->first();
        $prodiTF = ProgramStudi::where('kode', 'TF')->first();
        $prodiTM = ProgramStudi::where('kode', 'TM')->first();

        // Struktur Organisasi Fakultas
        StrukturOrganisasi::create([
            'nama' => 'Struktur Organisasi Fakultas Teknik',
            'deskripsi' => 'Deskripsi struktur fakultas',
            'level' => 'fakultas',
            'fakultas_id' => 1,
            'file_path' => 'struktur/fakultas_teknik.png', // harus disesuaikan
            'tipe' => 'image',
            'is_active' => true,
        ]);

        // Struktur Organisasi Prodi TI
        StrukturOrganisasi::create([
            'level' => 'prodi',
            'program_studi_id' => $prodiTI->id,
            'file_path' => 'struktur/prodi/struktur-ti.png',
            'nama' => 'Struktur Organisasi Prodi TI',
            'tipe' => 'image',
            'deskripsi' => 'Struktur organisasi Program Studi Teknik Industri',
            'is_active' => true,
        ]);

        // Struktur Organisasi Prodi TF
        StrukturOrganisasi::create([
            'level' => 'prodi',
            'program_studi_id' => $prodiTF->id,
            'file_path' => 'struktur/prodi/struktur-tf.png',
            'nama' => 'Struktur Organisasi Prodi TF',
            'tipe' => 'image',
            'deskripsi' => 'Struktur organisasi Program Studi Teknik Informatika',
            'is_active' => true,
        ]);

        // Struktur Organisasi Prodi TM
        StrukturOrganisasi::create([
            'level' => 'prodi',
            'program_studi_id' => $prodiTM->id,
            'file_path' => 'struktur/prodi/struktur-tm.png',
            'nama' => 'Struktur Organisasi Prodi TM',
            'tipe' => 'image',
            'deskripsi' => 'Struktur organisasi Program Studi Teknik Mesin',
            'is_active' => true,
        ]);
    }
}
