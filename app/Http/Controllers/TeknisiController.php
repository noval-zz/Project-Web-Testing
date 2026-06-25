<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeknisiController extends Controller
{
    /* ─────────────────────────────────────────────────────────────────
     |  DASHBOARD — ringkasan statistik tugas teknisi
     | ──────────────────────────────────────────────────────────────── */
    public function dashboard()
    {
        $user = Auth::user();

        // Statistik
        $totalTugas      = Laporan::where('Status_terkini', 'Sedang Diperbaiki')
                                  ->orWhere(function($q) use ($user) {
                                      $q->whereIn('Status_terkini', ['Dalam Pengerjaan', 'Selesai'])
                                        ->where('id_teknisi', $user->id_user);
                                  })->count();
        $tugasBaru       = Laporan::where('Status_terkini', 'Sedang Diperbaiki')->count();
        $dalamPengerjaan = Laporan::where('Status_terkini', 'Dalam Pengerjaan')->where('id_teknisi', $user->id_user)->count();
        $selesai         = Laporan::where('Status_terkini', 'Selesai')->where('id_teknisi', $user->id_user)->count();
        $darurat         = Laporan::where('Tingkat_Kerusakan', 'Parah')
                                  ->where(function($q) use ($user) {
                                      $q->where('Status_terkini', 'Sedang Diperbaiki')
                                        ->orWhere(function($q2) use ($user) {
                                            $q2->where('Status_terkini', 'Dalam Pengerjaan')->where('id_teknisi', $user->id_user);
                                        });
                                  })->count();

        // Tugas terbaru (5 teratas)
        $tugasTerbaru = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])
            ->where(function($q) use ($user) {
                $q->where('Status_terkini', 'Sedang Diperbaiki')
                  ->orWhere(function($q2) use ($user) {
                      $q2->where('Status_terkini', 'Dalam Pengerjaan')->where('id_teknisi', $user->id_user);
                  });
            })
            ->latest()
            ->limit(5)
            ->get();

        // Aktivitas terbaru (semua status, 6 teratas)
        $aktivitasTerbaru = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])
            ->where(function($q) use ($user) {
                $q->where('Status_terkini', 'Sedang Diperbaiki')
                  ->orWhere(function($q2) use ($user) {
                      $q2->whereIn('Status_terkini', ['Dalam Pengerjaan', 'Selesai'])->where('id_teknisi', $user->id_user);
                  });
            })
            ->latest('updated_at')
            ->limit(6)
            ->get();

        return view('Teknisi.dashboard', compact(
            'user',
            'totalTugas', 'tugasBaru', 'dalamPengerjaan', 'selesai', 'darurat',
            'tugasTerbaru', 'aktivitasTerbaru'
        ));
    }

    /* ─────────────────────────────────────────────────────────────────
     |  TUGAS SAYA — daftar semua laporan yang dikelola teknisi
     | ──────────────────────────────────────────────────────────────── */
    public function tugasSaya(Request $request)
    {
        $user  = Auth::user();
        $query = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])
            ->where(function($q) use ($user) {
                $q->where('Status_terkini', 'Sedang Diperbaiki')
                  ->orWhere(function($q2) use ($user) {
                      $q2->whereIn('Status_terkini', ['Dalam Pengerjaan', 'Selesai'])->where('id_teknisi', $user->id_user);
                  });
            })
            ->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('Status_terkini', $request->status);
        }

        // Filter tingkat
        if ($request->filled('tingkat')) {
            $query->where('Tingkat_Kerusakan', $request->tingkat);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', fn($q2) => $q2->where('Nama_mahasiswa', 'like', "%{$search}%"))
                  ->orWhereHas('lokasi', fn($q3) => $q3->where(function ($q4) use ($search) {
                      $q4->where('nama_ruangan', 'like', "%{$search}%")
                         ->orWhere('nama_gedung', 'like', "%{$search}%");
                  }));
            });
        }

        $laporanList = $query->paginate(10)->withQueryString();

        // Stat badges
        $statTotal   = Laporan::where('Status_terkini', 'Sedang Diperbaiki')
                              ->orWhere(function($q) use ($user) {
                                  $q->whereIn('Status_terkini', ['Dalam Pengerjaan', 'Selesai'])->where('id_teknisi', $user->id_user);
                              })->count();
        $statBaru    = Laporan::where('Status_terkini', 'Sedang Diperbaiki')->count();
        $statProses  = Laporan::where('Status_terkini', 'Dalam Pengerjaan')->where('id_teknisi', $user->id_user)->count();
        $statSelesai = Laporan::where('Status_terkini', 'Selesai')->where('id_teknisi', $user->id_user)->count();

        return view('Teknisi.tugas', compact(
            'user', 'laporanList',
            'statTotal', 'statBaru', 'statProses', 'statSelesai'
        ));
    }

    /* ─────────────────────────────────────────────────────────────────
     |  DETAIL TUGAS — lihat detail laporan
     | ──────────────────────────────────────────────────────────────── */
    public function detailTugas($id)
    {
        $user    = Auth::user();
        $laporan = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])->findOrFail($id);

        return view('Teknisi.detail', compact('user', 'laporan'));
    }

    /* ─────────────────────────────────────────────────────────────────
     |  MULAI PERBAIKAN — ubah status ke "Dalam Pengerjaan"
     | ──────────────────────────────────────────────────────────────── */
    public function mulaiPerbaikan($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        // Ensure another technician hasn't already taken it
        if ($laporan->id_teknisi !== null && $laporan->id_teknisi !== Auth::user()->id_user) {
            return redirect()
                ->route('teknisi.detail', $laporan->id_laporan)
                ->with('error', 'Laporan ini sudah diambil oleh teknisi lain.');
        }

        $laporan->update([
            'Status_terkini' => 'Dalam Pengerjaan',
            'id_teknisi'     => Auth::user()->id_user
        ]);

        return redirect()
            ->route('teknisi.detail', $laporan->id_laporan)
            ->with('success', '🔧 Status laporan diubah ke "Dalam Pengerjaan". Silakan mulai perbaikan!');
    }

    /* ─────────────────────────────────────────────────────────────────
     |  FORM SELESAIKAN TUGAS — halaman upload bukti
     | ──────────────────────────────────────────────────────────────── */
    public function formSelesai($id)
    {
        $user    = Auth::user();
        $laporan = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])->findOrFail($id);

        return view('Teknisi.selesai', compact('user', 'laporan'));
    }

   /* ─────────────────────────────────────────────────────────────────
     |  SELESAIKAN TUGAS — upload bukti & ubah status ke "Selesai"
     | ──────────────────────────────────────────────────────────────── */
    public function selesaikanTugas(Request $request, $id)
    {
        $request->validate([
            'foto_selesai' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'catatan'      => 'required|string|min:10|max:1000',
        ], [
            'foto_selesai.required' => 'Foto bukti perbaikan wajib diunggah.',
            'foto_selesai.image'    => 'File harus berupa gambar.',
            'foto_selesai.max'      => 'Ukuran foto maksimal 5 MB.',
            'catatan.required'      => 'Catatan hasil perbaikan wajib diisi.',
            'catatan.min'           => 'Catatan minimal 10 karakter.',
        ]);

        $laporan = Laporan::findOrFail($id);

        // Simpan foto bukti perbaikan
        $fotoPath = null;
        if ($request->hasFile('foto_selesai')) {
            $fotoPath = $request->file('foto_selesai')->store('bukti-perbaikan', 'public');
        }

        // 🌟 PERBAIKAN UTAMA: Satukan semua data update ke dalam Eloquent Model
        $updateData = [
            'Status_terkini' => 'Selesai',
        ];

        // Cek ketersediaan kolom secara aman sebelum diisi
        try {
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('laporan');
            
            if (in_array('foto_selesai', $columns) && $fotoPath) {
                $updateData['foto_selesai'] = $fotoPath;
            }
            if (in_array('catatan_selesai', $columns)) {
                $updateData['catatan_selesai'] = $request->catatan;
            }
        } catch (\Exception $e) {
            // Abaikan jika pengecekan kolom gagal
        }

        // Eksekusi update secara serentak sehingga data tidak saling menimpa
        $laporan->update($updateData);

        return redirect()
            ->route('teknisi.tugas')
            ->with('success', '✅ Tugas berhasil diselesaikan! Notifikasi telah dikirim ke mahasiswa dan admin.');
    }

    /* ─────────────────────────────────────────────────────────────────
     |  PROFIL TEKNISI
     | ──────────────────────────────────────────────────────────────── */

    public function editProfil()
    {
        $user = Auth::user();
        return view('Teknisi.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'nullable|email|max:150',
        ]);

        User::where('id_user', $user->id_user)->update([
            'nama'  => $request->nama,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $namaFile = 'teknisi_' . $user->id_user . '_' . time() . '.' . $request->file('foto_profil')->getClientOriginalExtension();
        $path = $request->file('foto_profil')->storeAs('profil', $namaFile, 'public');

        User::where('id_user', $user->id_user)->update(['foto_profil' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        User::where('id_user', $user->id_user)->update(['password' => Hash::make($request->password_baru)]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
