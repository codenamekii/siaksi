<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramStudi;
use App\Models\AkreditasiProdi;
use App\Models\Dokumen;
use App\Models\Fakultas;

class CheckAsesorDashboard extends Command
{
  protected $signature = 'check:asesor-dashboard';
  protected $description = 'Check and fix issues for asesor dashboard';

  public function handle()
  {
    $this->info('Checking Asesor Dashboard Requirements...');
    $this->newLine();

    // 1. Check akreditasi_prodi table structure
    $this->checkAkreditasiTable();

    // 2. Check ProgramStudi relationships
    $this->checkProgramStudiRelationships();

    // 3. Check if data exists
    $this->checkDataExists();

    // 4. Fix common issues
    $this->fixCommonIssues();

    $this->newLine();
    $this->info('✅ Check completed!');
  }

  private function checkAkreditasiTable()
  {
    $this->info('1. Checking akreditasi_prodi table...');

    if (!Schema::hasTable('akreditasi_prodi')) {
      $this->error('   ❌ Table akreditasi_prodi not found!');
      $this->line('   Run: php artisan migrate');
      return;
    }

    $columns = Schema::getColumnListing('akreditasi_prodi');
    $this->info('   ✅ Table exists with columns: ' . implode(', ', $columns));

    // Check if we have peringkat or status_akreditasi
    if (!in_array('peringkat', $columns) && in_array('status_akreditasi', $columns)) {
      $this->warn('   ⚠️  Using "status_akreditasi" column instead of "peringkat"');
    }
  }

  private function checkProgramStudiRelationships()
  {
    $this->info('2. Checking ProgramStudi relationships...');

    try {
      $prodi = ProgramStudi::first();
      if ($prodi) {
        // Check if akreditasi relationship exists
        if (method_exists($prodi, 'akreditasi')) {
          $this->info('   ✅ akreditasi() relationship exists');
        } else {
          $this->error('   ❌ akreditasi() relationship missing!');
          $this->line('   Add this to ProgramStudi model:');
          $this->line('   public function akreditasi() { return $this->hasMany(AkreditasiProdi::class); }');
        }

        // Check if akreditasiAktif relationship exists
        if (method_exists($prodi, 'akreditasiAktif')) {
          $this->info('   ✅ akreditasiAktif() relationship exists');
        } else {
          $this->warn('   ⚠️  akreditasiAktif() relationship missing');
          $this->line('   Add this to ProgramStudi model:');
          $this->line('   public function akreditasiAktif() { return $this->hasOne(AkreditasiProdi::class)->where("is_active", true)->latest("tanggal_akreditasi"); }');
        }
      }
    } catch (\Exception $e) {
      $this->error('   ❌ Error checking relationships: ' . $e->getMessage());
    }
  }

  private function checkDataExists()
  {
    $this->info('3. Checking data existence...');

    $fakultasCount = Fakultas::count();
    $prodiCount = ProgramStudi::count();
    $dokumenCount = Dokumen::count();
    $akreditasiCount = AkreditasiProdi::count();

    $this->info("   Fakultas: {$fakultasCount}");
    $this->info("   Program Studi: {$prodiCount}");
    $this->info("   Dokumen: {$dokumenCount}");
    $this->info("   Akreditasi: {$akreditasiCount}");

    if ($fakultasCount == 0) {
      $this->warn('   ⚠️  No fakultas data. Run: php artisan db:seed --class=FakultasSeeder');
    }
    if ($prodiCount == 0) {
      $this->warn('   ⚠️  No program studi data. Run: php artisan db:seed --class=ProgramStudiSeeder');
    }
    if ($dokumenCount == 0) {
      $this->warn('   ⚠️  No dokumen data. Run: php artisan db:seed --class=DokumenSeeder');
    }
    if ($akreditasiCount == 0) {
      $this->warn('   ⚠️  No akreditasi data. Run: php artisan db:seed --class=AkreditasiProdiSeeder');
    }
  }

  private function fixCommonIssues()
  {
    $this->info('4. Fixing common issues...');

    // Ensure some documents are visible to asesor
    $visibleCount = Dokumen::where('is_visible_to_asesor', true)->count();
    if ($visibleCount == 0 && Dokumen::count() > 0) {
      $this->warn('   ⚠️  No documents visible to asesor. Making some visible...');
      Dokumen::limit(10)->update(['is_visible_to_asesor' => true]);
      $this->info('   ✅ Made 10 documents visible to asesor');
    }

    // Ensure fakultas_id exists in dokumen for fakultas level documents
    $fakultasDocs = Dokumen::where('level', 'fakultas')
      ->whereNull('fakultas_id')
      ->count();

    if ($fakultasDocs > 0) {
      $this->warn("   ⚠️  Found {$fakultasDocs} fakultas documents without fakultas_id");
      $fakultas = Fakultas::first();
      if ($fakultas) {
        Dokumen::where('level', 'fakultas')
          ->whereNull('fakultas_id')
          ->update(['fakultas_id' => $fakultas->id]);
        $this->info('   ✅ Fixed fakultas_id for fakultas documents');
      }
    }

    // Ensure program_studi_id exists in dokumen for prodi level documents
    $prodiDocs = Dokumen::where('level', 'prodi')
      ->whereNull('program_studi_id')
      ->count();

    if ($prodiDocs > 0) {
      $this->warn("   ⚠️  Found {$prodiDocs} prodi documents without program_studi_id");
      $prodi = ProgramStudi::first();
      if ($prodi) {
        Dokumen::where('level', 'prodi')
          ->whereNull('program_studi_id')
          ->update(['program_studi_id' => $prodi->id]);
        $this->info('   ✅ Fixed program_studi_id for prodi documents');
      }
    }
  }
}