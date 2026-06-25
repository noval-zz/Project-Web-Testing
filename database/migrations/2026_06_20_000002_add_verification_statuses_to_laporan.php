<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
 
return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        // Ubah enum kolom Status_terkini agar menambahkan status baru dan jadikan default
        DB::statement("
            ALTER TABLE laporan
            MODIFY COLUMN Status_terkini
            ENUM('Menunggu Verifikasi', 'Sedang Diperbaiki', 'Dalam Pengerjaan', 'Selesai', 'Ditolak')
            NOT NULL
            DEFAULT 'Menunggu Verifikasi'
        ");
    }
 
    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        // Kembalikan ke enum sebelumnya (sedang diperbaiki, dalam pengerjaan, selesai)
        DB::statement("
            ALTER TABLE laporan
            MODIFY COLUMN Status_terkini
            ENUM('Sedang Diperbaiki', 'Dalam Pengerjaan', 'Selesai')
            NOT NULL
            DEFAULT 'Sedang Diperbaiki'
        ");
    }
};
