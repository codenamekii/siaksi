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
        Schema::table('akreditasi_prodi', function (Blueprint $table) {
            $table->integer('nilai_akreditasi')->nullable()->after('status_akreditasi');
            $table->text('catatan')->nullable()->after('sertifikat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('akreditasi_prodi', function (Blueprint $table) {
            //
        });
    }
};
