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
        // Make path nullable
        Schema::table('dokumen', function (Blueprint $table) {
            $table->string('path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update any NULL paths before making it non-nullable
        DB::table('dokumen')
            ->whereNull('path')
            ->update(['path' => '']);

        Schema::table('dokumen', function (Blueprint $table) {
            $table->string('path')->nullable(false)->change();
        });
    }
};
