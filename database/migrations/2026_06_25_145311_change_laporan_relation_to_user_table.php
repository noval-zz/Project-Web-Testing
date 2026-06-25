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
            $table->unsignedInteger('user_id')->nullable()->after('id_laporan');
        });

        // Migrate data: Laporan -> Mahasiswa -> User
        \DB::statement("
            UPDATE laporan l
            JOIN mahasiswa m ON l.id_mahasiswa = m.id_mahasiswa
            JOIN user u ON CAST(m.Nim AS CHAR) = u.username
            SET l.user_id = u.id_user
        ");

        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn('id_mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->unsignedInteger('id_mahasiswa')->nullable()->after('id_laporan');
        });

        \DB::statement("
            UPDATE laporan l
            JOIN user u ON l.user_id = u.id_user
            JOIN mahasiswa m ON u.username = CAST(m.Nim AS CHAR)
            SET l.id_mahasiswa = m.id_mahasiswa
        ");

        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
