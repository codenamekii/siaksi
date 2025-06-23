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
            $table->string('lembaga_akreditasi');
            $table->enum('status_akreditasi', ['Unggul', 'Baik Sekali', 'Baik', 'A', 'B', 'C']);
            $table->enum('peringkat', ['Unggul', 'Baik Sekali', 'Baik', 'A', 'B', 'C']); // Alias untuk status_akreditasi
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif'); // Status aktif/tidak aktif
            $table->date('tanggal_akreditasi');
            $table->date('tanggal_berakhir');
            $table->string('nomor_sk');
            $table->string('sertifikat')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('program_studi_id');
            $table->index('status_akreditasi');
            $table->index('peringkat');
            $table->index('status');
            $table->index('is_active');
            $table->index(['tanggal_akreditasi', 'tanggal_berakhir']);
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
