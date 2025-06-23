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
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nuptk', 50)->unique();
            $table->string('nidn', 20)->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telepon', 20)->nullable();
            $table->enum('jabatan_akademik', ['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Profesor']);
            $table->string('pendidikan_terakhir');
            $table->string('bidang_keahlian')->nullable();
            $table->foreignId('program_studi_id')->constrained('program_studi')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('nuptk');
            $table->index('nidn');
            $table->index('program_studi_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
