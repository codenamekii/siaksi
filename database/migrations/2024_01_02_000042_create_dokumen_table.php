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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['file', 'link'])->default('file');
            $table->string('path');
            $table->string('url')->nullable(); // Added url column here
            $table->string('kategori');
            $table->enum('level', ['universitas', 'fakultas', 'prodi']);
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->onDelete('cascade');
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->onDelete('cascade');
            $table->string('kriteria')->nullable();
            $table->string('sub_kriteria')->nullable();
            $table->text('catatan')->nullable(); // Changed from string to text
            $table->boolean('is_visible_to_asesor')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('kategori');
            $table->index('level');
            $table->index('fakultas_id');
            $table->index('program_studi_id');
            $table->index('is_active');
            $table->index('is_visible_to_asesor');
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
