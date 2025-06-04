<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProgramStudi;

class FixUjmProdiSeeder extends Seeder
{
  public function run()
  {
    $this->command->info('Fixing UJM users program_studi_id...');

    // Map of UJM emails to program studi names
    $ujmProdiMap = [
      'ujm.tf@fakultas.ac.id' => 'Teknik Fisika',
      'ujm.ti@fakultas.ac.id' => 'Teknik Informatika',
      'ujm.tm@fakultas.ac.id' => 'Teknik Mesin',
      'ujm.te@fakultas.ac.id' => 'Teknik Elektro',
      'ujm.ts@fakultas.ac.id' => 'Teknik Sipil',
    ];

    foreach ($ujmProdiMap as $email => $prodiName) {
      $user = User::where('email', $email)->first();

      if ($user && !$user->program_studi_id) {
        // Find program studi by name
        $prodi = ProgramStudi::where('nama', 'like', '%' . $prodiName . '%')->first();

        if ($prodi) {
          // Update user
          $user->update(['program_studi_id' => $prodi->id]);

          // Update program studi ujm_id
          $prodi->update(['ujm_id' => $user->id]);

          $this->command->info("✅ Fixed: {$user->name} -> {$prodi->nama}");
        } else {
          $this->command->warn("⚠️  Program Studi '{$prodiName}' not found for {$email}");
        }
      } elseif ($user && $user->program_studi_id) {
        $this->command->info("Already set: {$user->name} -> Program Studi ID: {$user->program_studi_id}");
      } else {
        $this->command->warn("User not found: {$email}");
      }
    }

    // Check for any remaining UJM users without program_studi_id
    $unassignedUjm = User::where('role', 'ujm')
      ->whereNull('program_studi_id')
      ->get();

    if ($unassignedUjm->count() > 0) {
      $this->command->newLine();
      $this->command->warn("Found {$unassignedUjm->count()} UJM users without program_studi_id:");

      foreach ($unassignedUjm as $user) {
        $this->command->line("- {$user->name} ({$user->email})");
      }

      // Assign to first available program studi
      $availableProdi = ProgramStudi::whereNull('ujm_id')
        ->where('is_active', true)
        ->first();

      if ($availableProdi && $this->command->confirm("Assign all to {$availableProdi->nama}?")) {
        foreach ($unassignedUjm as $user) {
          $user->update(['program_studi_id' => $availableProdi->id]);
          $this->command->info("✅ Assigned {$user->name} to {$availableProdi->nama}");
        }
      }
    } else {
      $this->command->info("✅ All UJM users have program_studi_id assigned!");
    }
  }
}