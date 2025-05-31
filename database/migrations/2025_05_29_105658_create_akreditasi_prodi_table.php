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
        Schema::create('akreditasi_prodi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_studi_id')->constrained('program_studi')->onDelete('cascade');
            $table->string('lembaga_akreditasi'); // BAN-PT, LAMEMBA, dll
            $table->string('status_akreditasi'); // Unggul, Baik Sekali, Baik, A, B, C
            $table->date('tanggal_akreditasi');
            $table->date('tanggal_berakhir');
            $table->string('nomor_sk')->nullable();
            $table->string('sertifikat')->nullable(); // path file PDF
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akreditasi_prodi');
    }
};
