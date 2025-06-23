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
        Schema::create('tenaga_kependidikan', function (Blueprint $table) {
            $table->id();
            $table->string('nuptk', 50)->unique();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->string('pendidikan_terakhir');
            $table->enum('status_kepegawaian', ['Tetap', 'Kontrak']);
            $table->string('email')->unique();
            $table->foreignId('program_studi_id')->constrained('program_studi')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index('nuptk');
            $table->index('program_studi_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kependidikan');
    }
};
