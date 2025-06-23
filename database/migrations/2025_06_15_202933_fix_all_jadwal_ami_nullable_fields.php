<?php
// OPTION 1: Make all non-essential fields nullable in one migration

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all columns that don't have default values and make them nullable
        Schema::table('jadwal_ami', function (Blueprint $table) {
            // Make these fields nullable if they exist and are not nullable
            $nullableFields = ['tempat', 'fakultas_id', 'jenis_ami', 'ketua_auditor', 'anggota_auditor', 'target_fakultas_id', 'target_prodi_ids', 'dokumen_panduan', 'dokumen_instrumen'];

            foreach ($nullableFields as $field) {
                if (Schema::hasColumn('jadwal_ami', $field)) {
                    // Use raw SQL to modify column to nullable
                    $columnType = DB::select('SHOW COLUMNS FROM jadwal_ami WHERE Field = ?', [$field])[0]->Type;
                    DB::statement("ALTER TABLE jadwal_ami MODIFY `{$field}` {$columnType} NULL");
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't reverse this as it's safer to keep fields nullable
    }
};
