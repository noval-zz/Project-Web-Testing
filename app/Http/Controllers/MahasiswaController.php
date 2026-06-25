<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    /**
     * Dashboard mahasiswa.
     */
    public function dashboard()
    {
        $user = Auth::user();
        // Cari data mahasiswa berdasarkan NIM = username (cast ke int agar cocok tipe bigInteger)
        $mhsModel = Mahasiswa::where('Nim', (string) $user->username)->first();
        $mhs = $mhsModel ?? (object)[
            'Nama_mahasiswa'  => $user->username,
            'Nim'             => $user->username,
            'id_mahasiswa'    => 0,
            'prodi'           => null,
            'foto_profil'     => null,
        ];

        $nama        = $mhs->Nama_mahasiswa;
        $nim         = $mhs->Nim;
        $prodi       = $mhs->prodi;
        $foto_profil = $mhs->foto_profil;

        // ── Statistik Laporan ──────────────────────────────────
        $statsQuery = $mhsModel
            ? \App\Models\Laporan::where('user_id', $user->id_user)
            : \App\Models\Laporan::whereNull('user_id')->where('user_id', -1); // empty

        $totalLaporan    = (clone $statsQuery)->count();
        $menunggu        = (clone $statsQuery)->where('Status_terkini', 'Menunggu Verifikasi')->count();
        $selesai         = (clone $statsQuery)->where('Status_terkini', 'Selesai')->count();
        $dalamProses     = (clone $statsQuery)->whereIn('Status_terkini', ['Sedang Diperbaiki', 'Dalam Pengerjaan'])->count();
        $ditolak         = (clone $statsQuery)->where('Status_terkini', 'Ditolak')->count();

        // ── Laporan Terbaru (maks 5) ───────────────────────────
        $laporanTerbaru = $mhsModel
            ? \App\Models\Laporan::with(['kategori', 'subkategori', 'lokasi'])
                ->where('user_id', $user->id_user)
                ->latest()
                ->take(5)
                ->get()
            : collect();

        // ── Laporan Aktif (untuk progress tracker) ────────────
        $laporanAktif = $mhsModel
            ? \App\Models\Laporan::with(['kategori', 'subkategori', 'lokasi'])
                ->where('user_id', $user->id_user)
                ->where('Status_terkini', 'Sedang Diperbaiki')
                ->latest()
                ->first()
            : null;

        // ── Pengumuman Sarpras (aktif, maks 5 terbaru) ─────────────
        $pengumuman = Pengumuman::aktif()
            ->orderByDesc('tanggal_publish')
            ->take(5)
            ->get();
            
        $now = Carbon::now();
        $hour = $now->format('H');
        $greeting = ($hour >= 5 && $hour < 12) ? 'Selamat Pagi' : (($hour >= 12 && $hour < 15) ? 'Selamat Siang' : (($hour >= 15 && $hour < 18) ? 'Selamat Sore' : 'Selamat Malam'));

        return view('mahasiswa.dashboard', compact(
            'user', 'mhs', 'nama', 'nim', 'prodi', 'foto_profil',
            'totalLaporan', 'menunggu', 'selesai', 'dalamProses', 'ditolak',
            'laporanTerbaru', 'laporanAktif', 'pengumuman',
            'now', 'greeting'
        ));
    }

    /**
     * Tampilkan form edit biodata.
     */
    public function biodata($id)
    {
        $user = Auth::user();
        $mhs = Mahasiswa::findOrFail($id);
        $ukm_array = $mhs->ukm ? explode(', ', $mhs->ukm) : [];
        return view('mahasiswa.biodata', compact('user', 'mhs', 'ukm_array'));
    }

    /**
     * Update biodata mahasiswa.
     */
    public function updateBiodata(Request $request, $id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        $request->validate([
            'Nama_mahasiswa' => 'required|string|max:50',
            'Nim'            => 'required|integer|unique:mahasiswa,Nim,' . $mhs->id_mahasiswa . ',id_mahasiswa|unique:user,username,' . Auth::user()->id_user . ',id_user',
            'jenis_Kelamin'  => 'required|in:L,P',
            'Kontak'         => 'nullable|numeric',
            'foto_profil'    => 'nullable|image|max:2048',
        ]);

        if ((string)$mhs->Nim !== (string)$request->Nim) {
            \App\Models\User::where('id_user', Auth::user()->id_user)->update(['username' => (string)$request->Nim]);
        }

        $data = [
            'Nama_mahasiswa' => $request->Nama_mahasiswa,
            'Nim'            => $request->Nim,
            'jenis_kelamin'  => $request->jenis_Kelamin,
            'agama'          => $request->agama,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'prodi'          => $request->prodi,
            'Kontak'         => $request->Kontak,
            'ukm'            => $request->ukm ? implode(', ', $request->ukm) : null,
        ];

        // Handle upload foto
        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($mhs->foto_profil && Storage::disk('public')->exists($mhs->foto_profil)) {
                Storage::disk('public')->delete($mhs->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        $mhs->update($data);

        return redirect()->route('mahasiswa.dashboard')
                         ->with('success', 'Biodata berhasil diperbarui!');
    }

    /**
     * Tampilkan form ganti password.
     */
    public function showGantiPassword()
    {
        $user = Auth::user();
        $mhs  = Mahasiswa::where('Nim', (string) $user->username)->first();
        return view('mahasiswa.ganti-password', compact('user', 'mhs'));
    }

    /**
     * Proses ganti password mahasiswa.
     */
    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama'             => 'required|string',
            'password_baru'             => 'required|string|min:6|confirmed',
            'password_baru_confirmation'=> 'required|string',
        ], [
            'password_lama.required'    => 'Password lama wajib diisi.',
            'password_baru.required'    => 'Password baru wajib diisi.',
            'password_baru.min'         => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'   => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        // Verifikasi password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama yang Anda masukkan salah.',
            ]);
        }

        // Cek jika password baru sama dengan lama
        if (Hash::check($request->password_baru, $user->password)) {
            return back()->withErrors([
                'password_baru' => 'Password baru tidak boleh sama dengan password lama.',
            ]);
        }

        // Update password di tabel user
        $userModel = User::find($user->id_user);
        $userModel->password = Hash::make($request->password_baru);
        $userModel->save();

        // Sync ke tabel mahasiswa
        Mahasiswa::where('Nim', (string) $user->username)->update(['Sandi' => $userModel->password]);

        return redirect()->route('mahasiswa.dashboard')
                         ->with('success', 'Password berhasil diubah! Silakan login ulang jika diperlukan.');
    }
}
