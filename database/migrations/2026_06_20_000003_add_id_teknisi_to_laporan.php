<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan', 'id_teknisi')) {
                $table->unsignedInteger('id_teknisi')->nullable()->after('id_lokasi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan', 'id_teknisi')) {
                $table->dropColumn('id_teknisi');
            }
        });
    }
};
