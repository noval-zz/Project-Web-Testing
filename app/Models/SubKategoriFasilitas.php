<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKategoriFasilitas extends Model
{
    protected $table = 'sub_kategori_fasilitas';
    protected $primaryKey = 'id_sub_kategori';

    protected $fillable = ['id_kategori', 'nama_sub_kategori', 'deskripsi'];

    public function kategori()
    {
        return $this->belongsTo(KategoriFasilitas::class, 'id_kategori', 'id_kategori');
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'id_sub_kategori', 'id_sub_kategori');
    }
}
