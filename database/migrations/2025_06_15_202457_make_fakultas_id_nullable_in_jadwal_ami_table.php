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
        Schema::table('jadwal_ami', function (Blueprint $table) {
            // Make fakultas_id nullable
            $table->unsignedBigInteger('fakultas_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ami', function (Blueprint $table) {
            // Make it non-nullable again (set default value first)
            DB::table('jadwal_ami')
                ->whereNull('fakultas_id')
                ->update(['fakultas_id' => 1]);
            $table->unsignedBigInteger('fakultas_id')->nullable(false)->change();
        });
    }
};
