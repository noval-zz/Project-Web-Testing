<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan', 'catatan_selesai')) {
                $table->text('catatan_selesai')->nullable()->after('Status_terkini');
            }
            if (!Schema::hasColumn('laporan', 'foto_selesai')) {
                $table->string('foto_selesai', 255)->nullable()->after('catatan_selesai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['catatan_selesai', 'foto_selesai']);
        });
    }
};
