<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table      = 'pengumuman';
    protected $primaryKey = 'id_pengumuman';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal_publish',
        'status',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
    ];

    /**
     * Relasi ke user (admin) yang membuat pengumuman.
     */
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'id_user');
    }

    /**
     * Scope: hanya pengumuman yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
