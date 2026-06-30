<?php

namespace App\Http\Controllers;

use App\Models\KategoriFasilitas;
use App\Models\Laporan;
use App\Models\LokasiFasilitas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman status laporan.
     */
    public function status()
    {
        $user  = Auth::user();
        // Cast username ke integer agar cocok dengan tipe kolom Nim (bigInteger)
        $mhs   = Mahasiswa::where('Nim', (string) $user->username)->first();

        $laporan = Laporan::with(['kategori', 'subkategori', 'lokasi'])
                     ->where('user_id', $user->id_user)
                     ->latest()
                     ->get();

        return view('laporan.status', compact('user', 'mhs', 'laporan'));
    }

    /**
     * Tampilkan halaman pantau laporan (monitoring detail per laporan).
     */
    public function pantau()
    {
        $user = Auth::user();
        // Cast username ke integer agar cocok dengan tipe kolom Nim (bigInteger)
        $mhs  = Mahasiswa::where('Nim', (string) $user->username)->first();

        $laporan = Laporan::with(['kategori', 'subkategori', 'lokasi'])
                     ->where('user_id', $user->id_user)
                     ->latest()
                     ->get();

        return view('mahasiswa.pantau_laporan', compact('user', 'mhs', 'laporan'));
    }

    /**
     * Tampilkan form buat laporan.
     */
    public function create()
    {
        $user      = Auth::user();
        // Cast username ke integer agar cocok dengan tipe kolom Nim (bigInteger)
        $mhs       = Mahasiswa::where('Nim', (string) $user->username)->first();
        $kategori  = KategoriFasilitas::all();
        $lokasi    = LokasiFasilitas::all();
        $subKategoriJson = \App\Models\SubKategoriFasilitas::all()->groupBy('id_kategori')->toJson();

        return view('laporan.create', compact('user', 'mhs', 'kategori', 'lokasi', 'subKategoriJson'));
    }

    /**
     * Simpan laporan baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Cast username ke integer agar cocok dengan tipe kolom Nim (bigInteger)
        $mhs  = Mahasiswa::where('Nim', (string) $user->username)->first();

        // Dosen & Mahasiswa diizinkan membuat laporan menggunakan user_id

        $request->validate([
            'id_kategori'      => 'required|integer',
            'id_sub_kategori'  => 'nullable|integer',
            'id_lokasi'        => 'required|integer',
            'deskripsi'        => 'required|string|min:10|max:1000',
            'Tingkat_Kerusakan'=> 'required|in:Rendah,Sedang,Parah',
            'foto'             => 'nullable|image|max:3072',
        ], [
            'id_kategori.required'      => 'Kategori fasilitas wajib dipilih.',
            'id_lokasi.required'        => 'Lokasi wajib dipilih.',
            'deskripsi.required'        => 'Deskripsi kerusakan wajib diisi.',
            'deskripsi.min'             => 'Deskripsi minimal 10 karakter.',
            'Tingkat_Kerusakan.required'=> 'Tingkat kerusakan wajib dipilih.',
            'foto.image'                => 'File harus berupa gambar.',
            'foto.max'                  => 'Ukuran foto maksimal 3 MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
        }

        Laporan::create([
            'user_id'          => $user->id_user,
            'id_kategori'      => $request->id_kategori,
            'id_sub_kategori'  => $request->id_sub_kategori,
            'id_lokasi'        => $request->id_lokasi,
            'deskripsi'        => $request->deskripsi,
            'Tingkat_Kerusakan'=> $request->Tingkat_Kerusakan,
            'Status_terkini'   => 'Menunggu Verifikasi',
            'foto'             => $fotoPath,
        ]);

        return redirect()->route('laporan.pantau')
                         ->with('success', 'Laporan berhasil dikirim! Tim kami akan segera menindaklanjuti.');
    }
}
