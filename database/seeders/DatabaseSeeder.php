<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([UserSeeder::class, FakultasSeeder::class, ProgramStudiSeeder::class, AkreditasiProdiSeeder::class, BeritaSeeder::class, DokumenSeeder::class, JadwalAMISeeder::class, TimGJMSeeder::class, TimUJMSeeder::class, TautanCepatSeeder::class, StrukturOrganisasiSeeder::class, DosenSeeder::class, TenagaKependidikanSeeder::class]);
    }
}
