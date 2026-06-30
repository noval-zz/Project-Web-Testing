<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan nilai 'Dalam Pengerjaan' ke ENUM Status_terkini di tabel laporan.
     * Urutan baru: Sedang Diperbaiki → Dalam Pengerjaan → Selesai
     */
    public function up(): void
    {
        // Gunakan DB::statement karena Laravel tidak mendukung alter ENUM secara native
        DB::statement("
            ALTER TABLE laporan
            MODIFY COLUMN Status_terkini
            ENUM('Sedang Diperbaiki', 'Dalam Pengerjaan', 'Selesai')
            NOT NULL
            DEFAULT 'Sedang Diperbaiki'
        ");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM asal (2 nilai)
        // Data dengan status 'Dalam Pengerjaan' akan hilang — hati-hati!
        DB::statement("
            ALTER TABLE laporan
            MODIFY COLUMN Status_terkini
            ENUM('Sedang Diperbaiki', 'Selesai')
            NOT NULL
        ");
    }
};
