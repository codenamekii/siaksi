<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // Call seeders in order of dependencies
    $this->call([
      // Basic data
      UserSeeder::class,
      FakultasSeeder::class,
      ProgramStudiSeeder::class,

      // Academic data
      AkreditasiProdiSeeder::class,
      DosenSeeder::class,
      TenagaKependidikanSeeder::class,

      // Document and content
      DokumenSeeder::class,
      BeritaSeeder::class,

      // Organization and schedule
      TimGJMSeeder::class,
      TimUJMSeeder::class,
      JadwalAMISeeder::class,
      StrukturOrganisasiSeeder::class,

      // Others
      TautanCepatSeeder::class,

      // Quick fix for asesor
    ]);
  }
}
