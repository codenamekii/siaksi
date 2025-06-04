<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ProgramStudi;

class CheckUjmProdi extends Command
{
  protected $signature = 'check:ujm-prodi {email?}';
  protected $description = 'Check UJM user program studi assignment';

  public function handle()
  {
    $email = $this->argument('email');

    if ($email) {
      $user = User::where('email', $email)->first();

      if (!$user) {
        $this->error("User with email {$email} not found.");
        return;
      }

      $this->checkUser($user);
    } else {
      // Check all UJM users
      $ujmUsers = User::where('role', 'ujm')->get();

      $this->info("Checking all UJM users...\n");

      foreach ($ujmUsers as $user) {
        $this->checkUser($user);
        $this->newLine();
      }
    }
  }

  private function checkUser($user)
  {
    $this->info("User: {$user->name} ({$user->email})");
    $this->line("Role: {$user->role}");
    $this->line("Program Studi ID: " . ($user->program_studi_id ?? 'NULL'));

    if ($user->program_studi_id) {
      $prodi = ProgramStudi::find($user->program_studi_id);
      if ($prodi) {
        $this->info("✅ Program Studi: {$prodi->nama} (ID: {$prodi->id})");
      } else {
        $this->error("❌ Program Studi ID {$user->program_studi_id} not found in database!");
      }
    } else {
      $this->error("❌ No Program Studi assigned!");

      // Suggest available program studi
      $availableProdi = ProgramStudi::where('is_active', true)
        ->whereNull('ujm_id')
        ->orWhere('ujm_id', $user->id)
        ->get();

      if ($availableProdi->count() > 0) {
        $this->info("Available Program Studi:");
        foreach ($availableProdi as $prodi) {
          $this->line("  - {$prodi->nama} (ID: {$prodi->id})");
        }

        if ($this->confirm("Do you want to assign a program studi to this user?")) {
          $prodiId = $this->ask("Enter Program Studi ID");

          $selectedProdi = ProgramStudi::find($prodiId);
          if ($selectedProdi) {
            $user->update(['program_studi_id' => $prodiId]);
            $selectedProdi->update(['ujm_id' => $user->id]);
            $this->info("✅ Program Studi assigned successfully!");
          } else {
            $this->error("Invalid Program Studi ID!");
          }
        }
      }
    }
  }
}