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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['file', 'url', 'image']);
            $table->string('path')->nullable(); // untuk file/image
            $table->text('url')->nullable(); // untuk URL
            $table->string('kriteria')->nullable();
            $table->string('sub_kriteria')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('kategori', ['kebijakan_mutu', 'standar_mutu', 'prosedur', 'instrumen', 'laporan_ami', 'laporan_survei', 'evaluasi_diri', 'lkps', 'sertifikat_akreditasi', 'kurikulum', 'data_pendukung', 'rencana_strategis', 'dokumentasi_kegiatan']);
            $table->enum('level', ['universitas', 'fakultas', 'prodi']);
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->onDelete('cascade');
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->onDelete('cascade');
            $table->boolean('is_visible_to_asesor')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
