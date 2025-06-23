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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('konten');
            $table->string('gambar')->nullable();
            $table->enum('kategori', ['berita', 'pengumuman', 'kegiatan', 'prestasi', 'agenda', 'lainnya'])->default('berita');
            $table->enum('level', ['universitas', 'fakultas', 'prodi'])->default('fakultas');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->boolean('is_published')->default(false);
            $table->foreignId('fakultas_id')->nullable()->constrained('fakultas')->onDelete('cascade');
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studi')->onDelete('cascade');

            // Perbaikan: Tambahkan nullable
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->datetime('tanggal_publikasi')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('kategori');
            $table->index('level');
            $table->index('status');
            $table->index('is_published');
            $table->index('fakultas_id');
            $table->index('program_studi_id');
            $table->index('created_by');
            $table->index('updated_by');
            $table->index('tanggal_publikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
