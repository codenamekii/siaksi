<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_ami', function (Blueprint $table) {
            // Drop the single program_studi_id column if it exists
            if (Schema::hasColumn('jadwal_ami', 'program_studi_id')) {
                $table->dropForeign(['program_studi_id']);
                $table->dropColumn('program_studi_id');
            }

            // Also drop target_prodi_ids if it exists (we use pivot table now)
            if (Schema::hasColumn('jadwal_ami', 'target_prodi_ids')) {
                $table->dropColumn('target_prodi_ids');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ami', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_ami', 'program_studi_id')) {
                $table->foreignId('program_studi_id')->nullable()->constrained()->onDelete('set null');
            }
        });
    }
};
