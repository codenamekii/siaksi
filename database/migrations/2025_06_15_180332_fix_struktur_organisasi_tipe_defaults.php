<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing records that have null tipe
        DB::table('struktur_organisasi')
            ->whereNull('tipe')
            ->update(['tipe' => 'image']);

        // Also update any records that might have old 'gambar' field references
        // Check if records have file_path that ends with pdf
        DB::table('struktur_organisasi')
            ->where('file_path', 'like', '%.pdf')
            ->update(['tipe' => 'pdf']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to reverse
    }
};
