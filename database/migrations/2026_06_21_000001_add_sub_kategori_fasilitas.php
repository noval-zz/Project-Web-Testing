<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create sub_kategori_fasilitas table
        if (!Schema::hasTable('sub_kategori_fasilitas')) {
            Schema::create('sub_kategori_fasilitas', function (Blueprint $table) {
                $table->increments('id_sub_kategori');
                $table->unsignedInteger('id_kategori');
                $table->string('nama_sub_kategori', 100);
                $table->text('deskripsi')->nullable();
                $table->timestamps();

                // Kita tidak paksa FK ke kategori_fasilitas jika FK sebelumnya belum rapi,
                // tapi best practice kita tambahkan foreign key.
                // $table->foreign('id_kategori')->references('id_kategori')->on('kategori_fasilitas')->onDelete('cascade');
            });
        }

        // 2. Add id_sub_kategori to laporan table
        Schema::table('laporan', function (Blueprint $table) {
            if (!Schema::hasColumn('laporan', 'id_sub_kategori')) {
                $table->unsignedInteger('id_sub_kategori')->nullable()->after('id_kategori');
            }
        });

        // 3. Data Migration (Mapping old categories to new ones)
        
        // Backup old laporan categories into memory (using join to get string name)
        $laporans = DB::table('laporan')
            ->join('kategori_fasilitas', 'laporan.id_kategori', '=', 'kategori_fasilitas.id_kategori')
            ->select('laporan.id_laporan', 'kategori_fasilitas.nama_kategori')
            ->get();

        // Kosongkan tabel kategori lama
        DB::table('kategori_fasilitas')->delete();

        // Insert new Parent Categories
        $parents = [
            'Elektronik',
            'Kelistrikan',
            'Furniture',
            'Bangunan',
            'Jaringan & Internet',
            'Sanitasi',
            'Keamanan',
            'Lingkungan',
            'Lainnya'
        ];

        $parentMap = []; // id => name map
        foreach ($parents as $parent) {
            $id = DB::table('kategori_fasilitas')->insertGetId([
                'nama_kategori' => $parent,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $parentMap[$parent] = $id;
        }

        // Insert Sub Categories
        $subCategories = [
            'Elektronik' => ['Komputer', 'Printer', 'Proyektor', 'AC', 'Speaker'],
            'Kelistrikan' => ['Lampu', 'Stop Kontak', 'Saklar', 'Kabel Listrik'],
            'Furniture' => ['Meja', 'Kursi', 'Lemari', 'Papan Tulis'],
            'Bangunan' => ['Dinding', 'Atap', 'Lantai', 'Jendela', 'Pintu'],
            'Jaringan & Internet' => ['WiFi', 'Router', 'Switch', 'Kabel LAN'],
            'Sanitasi' => ['Toilet', 'Wastafel', 'Keran', 'Saluran Air'],
            'Keamanan' => ['CCTV', 'Alarm', 'Pagar'],
            'Lingkungan' => ['Taman', 'Tempat Sampah', 'Area Parkir'],
            'Lainnya' => [] // kosong
        ];

        $subMap = []; // parentName_subName => id
        foreach ($subCategories as $parentName => $subs) {
            $parentId = $parentMap[$parentName];
            foreach ($subs as $sub) {
                $subId = DB::table('sub_kategori_fasilitas')->insertGetId([
                    'id_kategori' => $parentId,
                    'nama_sub_kategori' => $sub,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $subMap[$parentName . '_' . strtolower($sub)] = $subId;
            }
        }

        // Update laporan lama
        foreach ($laporans as $lap) {
            $oldName = strtolower($lap->nama_kategori);
            
            $newParentId = null;
            $newSubId = null;

            switch ($oldName) {
                case 'meja':
                    $newParentId = $parentMap['Furniture'];
                    $newSubId = $subMap['Furniture_meja'];
                    break;
                case 'kursi':
                    $newParentId = $parentMap['Furniture'];
                    $newSubId = $subMap['Furniture_kursi'];
                    break;
                case 'ac':
                    $newParentId = $parentMap['Elektronik'];
                    $newSubId = $subMap['Elektronik_ac'];
                    break;
                case 'tv':
                    $newParentId = $parentMap['Elektronik'];
                    // TV is not in new subcategories, just leave sub null
                    break;
                case 'dinding':
                    $newParentId = $parentMap['Bangunan'];
                    $newSubId = $subMap['Bangunan_dinding'];
                    break;
                case 'lantai':
                    $newParentId = $parentMap['Bangunan'];
                    $newSubId = $subMap['Bangunan_lantai'];
                    break;
                case 'atap':
                    $newParentId = $parentMap['Bangunan'];
                    $newSubId = $subMap['Bangunan_atap'];
                    break;
                case 'alat':
                default:
                    $newParentId = $parentMap['Lainnya'];
                    break;
            }

            if ($newParentId) {
                DB::table('laporan')
                    ->where('id_laporan', $lap->id_laporan)
                    ->update([
                        'id_kategori' => $newParentId,
                        'id_sub_kategori' => $newSubId
                    ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            if (Schema::hasColumn('laporan', 'id_sub_kategori')) {
                $table->dropColumn('id_sub_kategori');
            }
        });

        Schema::dropIfExists('sub_kategori_fasilitas');
    }
};
