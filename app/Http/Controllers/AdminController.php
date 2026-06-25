<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Laporan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard admin: tampilkan data lengkap untuk dashboard profesional.
     */
    public function dashboard()
    {
        $user  = Auth::user();
        $admin = Admin::where('nip', $user->username)->first()
                 ?? Admin::where('nama_admin', 'like', '%' . $user->username . '%')->first()
                 ?? (object)['nama_admin' => $user->username];

        // ── Statistik Utama ──────────────────────────────────────────
        $totalLaporan    = Laporan::count();
        $menunggu        = Laporan::where('Status_terkini', 'Menunggu Verifikasi')->count();
        $dalamPengerjaan = Laporan::where('Status_terkini', 'Dalam Pengerjaan')->count();
        $selesai         = Laporan::where('Status_terkini', 'Selesai')->count();

        // ── Laporan Terbaru (5 terakhir) ─────────────────────────────
        $laporanTerbaru = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])
            ->latest()
            ->limit(5)
            ->get();

        // ── Laporan Prioritas Tinggi (Parah) ─────────────────────────
        $laporanPrioritas = Laporan::with(['lokasi', 'kategori'])
            ->where('Tingkat_Kerusakan', 'Parah')
            ->whereIn('Status_terkini', ['Sedang Diperbaiki', 'Dalam Pengerjaan'])
            ->latest()
            ->limit(5)
            ->get();

        // ── Laporan per bulan (tahun ini) ────────────────────────────
        $laporanBulanan = Laporan::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $chartBulan = array_fill(0, 12, 0);
        foreach ($laporanBulanan as $row) {
            $chartBulan[$row->bulan - 1] = $row->total;
        }

        // ── Kategori terbanyak ───────────────────────────────────────
        $kategoriStats = Laporan::select('id_kategori', DB::raw('COUNT(*) as total'))
            ->with('kategori')
            ->groupBy('id_kategori')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $chartKategoriLabels = $kategoriStats->map(fn($k) => $k->kategori?->nama_kategori ?? 'Lainnya')->toArray();
        $chartKategoriData   = $kategoriStats->pluck('total')->toArray();

        // ── Notifikasi dummy (bisa dihubungkan ke data nyata) ────────
        $notifikasi = [];

        // Laporan baru hari ini
        $baruHariIni = Laporan::whereDate('created_at', today())->count();
        if ($baruHariIni > 0) {
            $notifikasi[] = [
                'type'  => 'info',
                'icon'  => 'fa-file-circle-plus',
                'pesan' => "$baruHariIni laporan baru masuk hari ini",
                'waktu' => 'Hari ini',
            ];
        }

        // Laporan prioritas tinggi yang belum selesai
        $prioritasCount = $laporanPrioritas->count();
        if ($prioritasCount > 0) {
            $notifikasi[] = [
                'type'  => 'danger',
                'icon'  => 'fa-triangle-exclamation',
                'pesan' => "$prioritasCount laporan prioritas tinggi belum ditangani",
                'waktu' => 'Perlu segera',
            ];
        }

        // Laporan lebih dari 3 hari belum selesai
        $telantar = Laporan::where('Status_terkini', 'Sedang Diperbaiki')
            ->where('created_at', '<', now()->subDays(3))
            ->count();
        if ($telantar > 0) {
            $notifikasi[] = [
                'type'  => 'warning',
                'icon'  => 'fa-clock',
                'pesan' => "$telantar laporan belum ditangani lebih dari 3 hari",
                'waktu' => '> 3 hari lalu',
            ];
        }

        // Fallback jika tidak ada notifikasi
        if (empty($notifikasi)) {
            $notifikasi[] = [
                'type'  => 'success',
                'icon'  => 'fa-circle-check',
                'pesan' => 'Semua laporan dalam kondisi terkendali',
                'waktu' => 'Sekarang',
            ];
        }

        return view('admin.dashboard', compact(
            'user', 'admin',
            'totalLaporan', 'menunggu', 'dalamPengerjaan', 'selesai',
            'laporanTerbaru', 'laporanPrioritas',
            'chartBulan', 'chartKategoriLabels', 'chartKategoriData',
            'notifikasi',
        ));
    }

    public function daftarMahasiswa()
    {
        $mahasiswas = Mahasiswa::withCount('laporan')->get();
        return view('admin.mahasiswa', compact('mahasiswas'));
    }

    public function detailMahasiswa($id)
    {
        $mhs = Mahasiswa::with(['laporan' => function ($q) {
            $q->latest();
        }])->withCount('laporan')->findOrFail($id);
        
        return view('admin.detail_mahasiswa', compact('mhs'));
    }

    /**
     * Hapus mahasiswa & akun user-nya.
     */
    public function hapusMahasiswa($id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        // Hapus akun login (user) yang NIM-nya cocok
        $user = User::where('username', (string) $mhs->Nim)->first();
        $userId = $user ? $user->id_user : -1;

        if ($user) {
            $user->delete();
        }

        // Hapus foto profil mahasiswa jika ada
        if ($mhs->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($mhs->foto_profil)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($mhs->foto_profil);
        }

        // Hapus foto dari setiap laporan milik mahasiswa tersebut
        $laporans = \App\Models\Laporan::where('user_id', $userId)->get();
        foreach ($laporans as $lap) {
            if ($lap->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($lap->foto)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lap->foto);
            }
            $lap->delete(); // Mencegah orphaned records
        }

        $mhs->delete();

        return redirect()->route('admin.mahasiswa')
                         ->with('success', 'Data mahasiswa dan semua laporan terkait berhasil dihapus beserta file fotonya.');
    }

    /**
     * Tampilkan halaman Riwayat Laporan — data dari database.
     */
    public function riwayat(Request $request)
    {
        $user  = Auth::user();
        $admin = Admin::where('nip', $user->username)->first()
                 ?? Admin::where('nama_admin', 'like', '%' . $user->username . '%')->first()
                 ?? (object)['nama_admin' => $user->username];

        // ── Query dengan filter & pencarian ──────────────────────────
        $query = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])->latest();

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('Status_terkini', $request->status);
        }

        // Filter: Tingkat Kerusakan
        if ($request->filled('tingkat')) {
            $query->where('Tingkat_Kerusakan', $request->tingkat);
        }

        // Search: deskripsi atau nama pelapor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', fn($q2) =>
                      $q2->where('Nama_mahasiswa', 'like', "%{$search}%")
                  )
                  ->orWhereHas('lokasi', fn($q3) =>
                      $q3->where(function ($q4) use ($search) {
                          $q4->where('nama_ruangan', 'like', "%{$search}%")
                             ->orWhere('nama_gedung', 'like', "%{$search}%");
                      })
                  );
            });
        }

        // Paginasi (15 per halaman), pertahankan query string
        $laporanList = $query->paginate(15)->withQueryString();

        // ── Hitung total per status untuk badge ──────────────────────
        $statTotal    = Laporan::count();
        $statProses   = Laporan::whereIn('Status_terkini', ['Sedang Diperbaiki', 'Dalam Pengerjaan'])->count();
        $statSelesai  = Laporan::where('Status_terkini', 'Selesai')->count();

        // ── Pre-build JSON untuk modal JavaScript ────────────────────
        $laporanJson = $laporanList->getCollection()->map(function ($lap) {
            $lokasi    = $lap->lokasi;
            $lokasiStr = collect([
                $lokasi?->nama_gedung,
                $lokasi?->nama_ruangan,
            ])->filter()->implode(', ') ?: '–';

            $foto = null;
            if ($lap->foto) {
                $foto = str_starts_with($lap->foto, 'http') || str_starts_with($lap->foto, '//')
                    ? $lap->foto
                    : asset('storage/' . $lap->foto);
            }

            return [
                'id'       => $lap->id_laporan,
                'pelapor'  => $lap->mahasiswa?->Nama_mahasiswa ?? 'Anonim',
                'nim'      => $lap->mahasiswa?->Nim ?? '–',
                'deskripsi'=> $lap->deskripsi ?? '–',
                'lokasi'   => $lokasiStr,
                'kategori' => ucfirst(($lap->kategori?->nama_kategori ?? 'Fasilitas') . ($lap->subkategori ? ' — ' . $lap->subkategori->nama_sub_kategori : '')),
                'tingkat'  => $lap->Tingkat_Kerusakan,
                'status'   => $lap->Status_terkini,
                'foto'     => $foto,
                'tanggal'  => $lap->created_at?->format('d M Y, H:i') ?? '–',
                'updated'  => $lap->updated_at?->format('d M Y, H:i') ?? '–',
            ];
        })->values();

        return view('admin.riwayat', compact(
            'user', 'admin',
            'laporanList',
            'statTotal', 'statProses', 'statSelesai',
            'laporanJson',
        ));
    }

    /**
     * Tampilkan halaman Edit Profil Admin.
     */
    public function editProfil()
    {
        $user  = Auth::user();
        $admin = Admin::where('nip', $user->username)
                      ->orWhere('nama_admin', 'like', '%' . $user->username . '%')
                      ->first();
        
        return view('admin.edit_profil', compact('user', 'admin'));
    }

    /**
     * Update Profil Admin.
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        // Pertama coba cari berdasarkan NIP yang ada di form
        $admin = null;
        if ($request->filled('nip')) {
            $admin = Admin::where('nip', $request->nip)->first();
        }
        
        // Jika tidak ketemu, cari berdasarkan username
        if (!$admin) {
            $admin = Admin::where('nip', $user->username)
                          ->orWhere('nama_admin', 'like', '%' . $user->username . '%')
                          ->first();
        }

        $nipRule = 'nullable|string|max:50|unique:user,username,' . $user->id_user . ',id_user';
        if ($admin) {
            $nipRule .= '|unique:admin,nip,' . $admin->id_admin . ',id_admin';
        } else {
            $nipRule .= '|unique:admin,nip';
        }

        $request->validate([
            'nama_admin'  => 'required|string|max:100',
            'nip'         => $nipRule,
            'kontak'      => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        // Update User table (foto_profil, nama, username)
        $userData = ['nama' => $request->nama_admin];
        if ($request->filled('nip') && $user->username !== $request->nip) {
            $userData['username'] = $request->nip;
        }

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profil)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            $userData['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        }
        
        // As user model is retrieved via Auth::user(), we can use the User model directly to update
        \App\Models\User::where('id_user', $user->id_user)->update($userData);

        // Update Admin table
        if ($admin) {
            $admin->update([
                'nama_admin' => $request->nama_admin,
                'nip'        => $request->nip,
                'kontak'     => $request->kontak,
            ]);
        } else {
            // Jika data admin belum ada, buat baru
            Admin::create([
                'nama_admin' => $request->nama_admin,
                'nip'        => $request->nip,
                'kontak'     => $request->kontak,
                'sandi'      => $user->password, // Sandi diperlukan oleh database
            ]);
        }

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Proses ganti password admin.
     */
    public function gantiPassword(Request $request)
    {
        $request->validate([
            'password_lama'              => 'required|string',
            'password_baru'              => 'required|string|min:6|confirmed',
            'password_baru_confirmation' => 'required|string',
        ], [
            'password_lama.required'     => 'Password lama wajib diisi.',
            'password_baru.required'     => 'Password baru wajib diisi.',
            'password_baru.min'          => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        // Verifikasi password lama
        if (!\Illuminate\Support\Facades\Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors([
                'password_lama' => 'Password lama yang Anda masukkan salah.',
            ]);
        }

        // Cek jika password baru sama dengan lama
        if (\Illuminate\Support\Facades\Hash::check($request->password_baru, $user->password)) {
            return back()->withErrors([
                'password_baru' => 'Password baru tidak boleh sama dengan password lama.',
            ]);
        }

        // Update password di tabel user
        $userModel = User::find($user->id_user);
        $userModel->password = \Illuminate\Support\Facades\Hash::make($request->password_baru);
        $userModel->save();

        // Update sandi di tabel admin juga
        $admin = Admin::where('nip', $user->username)
                      ->orWhere('nama_admin', 'like', '%' . $user->username . '%')
                      ->first();
        if ($admin) {
            $admin->update(['sandi' => $userModel->password]);
        }

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Password berhasil diperbarui! Silakan login ulang jika diperlukan.');
    }

    /**
     * Tampilkan halaman Semua Laporan.
     */
    public function semuaLaporan(Request $request)
    {
        $user  = Auth::user();
        $admin = Admin::where('nip', $user->username)->first()
                 ?? Admin::where('nama_admin', 'like', '%' . $user->username . '%')->first()
                 ?? (object)['nama_admin' => $user->username];

        // ── Query dengan filter & pencarian ──────────────────────────
        $query = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])->latest();

        if ($request->filled('status')) {
            $query->where('Status_terkini', $request->status);
        }

        if ($request->filled('tingkat')) {
            $query->where('Tingkat_Kerusakan', $request->tingkat);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', fn($q2) =>
                      $q2->where('Nama_mahasiswa', 'like', "%{$search}%")
                  )
                  ->orWhereHas('lokasi', fn($q3) =>
                      $q3->where(function ($q4) use ($search) {
                          $q4->where('nama_ruangan', 'like', "%{$search}%")
                             ->orWhere('nama_gedung', 'like', "%{$search}%");
                      })
                  );
            });
        }

        $laporanList = $query->paginate(15)->withQueryString();

        $statTotal    = Laporan::count();
        $statProses   = Laporan::whereIn('Status_terkini', ['Sedang Diperbaiki', 'Dalam Pengerjaan'])->count();
        $statSelesai  = Laporan::where('Status_terkini', 'Selesai')->count();

        $laporanJson = $laporanList->getCollection()->map(function ($lap) {
            $lokasi    = $lap->lokasi;
            $lokasiStr = collect([
                $lokasi?->nama_gedung,
                $lokasi?->nama_ruangan,
            ])->filter()->implode(', ') ?: '–';

            $foto = null;
            if ($lap->foto) {
                $foto = str_starts_with($lap->foto, 'http') || str_starts_with($lap->foto, '//')
                    ? $lap->foto
                    : asset('storage/' . $lap->foto);
            }

            return [
                'id'       => $lap->id_laporan,
                'pelapor'  => $lap->mahasiswa?->Nama_mahasiswa ?? 'Anonim',
                'nim'      => $lap->mahasiswa?->Nim ?? '–',
                'deskripsi'=> $lap->deskripsi ?? '–',
                'lokasi'   => $lokasiStr,
                'kategori' => ucfirst(($lap->kategori?->nama_kategori ?? 'Fasilitas') . ($lap->subkategori ? ' — ' . $lap->subkategori->nama_sub_kategori : '')),
                'tingkat'  => $lap->Tingkat_Kerusakan,
                'status'   => $lap->Status_terkini,
                'foto'     => $foto,
                'tanggal'  => $lap->created_at?->format('d M Y, H:i') ?? '–',
                'updated'  => $lap->updated_at?->format('d M Y, H:i') ?? '–',
            ];
        })->values();

        return view('admin.semua_laporan', compact(
            'user', 'admin',
            'laporanList',
            'statTotal', 'statProses', 'statSelesai',
            'laporanJson',
        ));
    }

    /**
     * Tampilkan halaman verifikasi laporan.
     */
    public function verifikasiList(Request $request)
    {
        $user  = Auth::user();
        $admin = Admin::where('nip', $user->username)->first()
                 ?? Admin::where('nama_admin', 'like', '%' . $user->username . '%')->first()
                 ?? (object)['nama_admin' => $user->username];

        // Ambil laporan yang berstatus 'Menunggu Verifikasi'
        $query = Laporan::with(['mahasiswa', 'kategori', 'subkategori', 'lokasi'])
            ->where('Status_terkini', 'Menunggu Verifikasi')
            ->latest();

        // Pencarian jika ada
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('deskripsi', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', fn($q2) =>
                      $q2->where('Nama_mahasiswa', 'like', "%{$search}%")
                  )
                  ->orWhereHas('lokasi', fn($q3) =>
                      $q3->where(function ($q4) use ($search) {
                          $q4->where('nama_ruangan', 'like', "%{$search}%")
                             ->orWhere('nama_gedung', 'like', "%{$search}%");
                      })
                  );
            });
        }

        $laporanList = $query->paginate(15)->withQueryString();

        return view('admin.verifikasi', compact('user', 'admin', 'laporanList'));
    }

    /**
     * Setujui laporan (teruskan ke teknisi).
     */
    public function verifikasiSetuju($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'Status_terkini' => 'Sedang Diperbaiki'
        ]);

        return redirect()->route('admin.verifikasi.index')
                         ->with('success', 'Laporan berhasil diverifikasi dan dikirim ke teknisi.');
    }

    /**
     * Tolak laporan.
     */
    public function verifikasiTolak($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'Status_terkini' => 'Ditolak'
        ]);

        return redirect()->route('admin.verifikasi.index')
                         ->with('success', 'Laporan berhasil ditolak.');
    }

    /**
     * Hapus laporan.
     */
    public function verifikasiHapus($id)
    {
        $laporan = Laporan::findOrFail($id);
        
        // Hapus file foto dari storage jika ada
        if ($laporan->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
        }
        
        $laporan->delete();

        return redirect()->route('admin.verifikasi.index')
                         ->with('success', 'Laporan beserta lampiran fotonya berhasil dihapus.');
    }
}

