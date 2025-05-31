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
        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['fakultas', 'prodi']);
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->onDelete('cascade');
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->onDelete('cascade');
            $table->string('gambar');
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasi');
    }
};
