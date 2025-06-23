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
        // IMPORTANT: Don't change nullable status of path column
        // Only add 'url' to the enum options

        try {
            DB::statement("ALTER TABLE dokumen MODIFY COLUMN tipe ENUM('file', 'link', 'url') DEFAULT 'file'");
        } catch (\Exception $e) {
            // If enum already has 'url', continue
            if (!str_contains($e->getMessage(), 'Duplicate')) {
                throw $e;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update any 'url' values to 'link' before removing from enum
        DB::table('dokumen')
            ->where('tipe', 'url')
            ->update(['tipe' => 'link']);

        // Remove 'url' from enum
        DB::statement("ALTER TABLE dokumen MODIFY COLUMN tipe ENUM('file', 'link') DEFAULT 'file'");
    }
};
