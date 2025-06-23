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
        Schema::table('tim_ujm', function (Blueprint $table) {
            if (!Schema::hasColumn('tim_ujm', 'foto')) {
                $table->string('foto')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tim_ujm', function (Blueprint $table) {
            if (Schema::hasColumn('tim_ujm', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }
};
