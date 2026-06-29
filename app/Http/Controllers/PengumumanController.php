<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    /**
     * Daftar semua pengumuman (halaman admin).
     */
    public function index()
    {
        $user = Auth::user();

        $pengumumanList = Pengumuman::with('pembuat')
            ->latest('tanggal_publish')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengumuman.index', compact('user', 'pengumumanList'));
    }

    /**
     * Form tambah pengumuman.
     */
    public function create()
    {
        $user = Auth::user();
        return view('admin.pengumuman.create', compact('user'));
    }

    /**
     * Simpan pengumuman baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:200',
            'isi'             => 'required|string|min:10',
            'tanggal_publish' => 'required|date',
            'status'          => 'required|in:aktif,nonaktif',
        ], [
            'judul.required'           => 'Judul pengumuman wajib diisi.',
            'isi.required'             => 'Isi pengumuman wajib diisi.',
            'isi.min'                  => 'Isi pengumuman minimal 10 karakter.',
            'tanggal_publish.required' => 'Tanggal publish wajib diisi.',
            'status.required'          => 'Status wajib dipilih.',
        ]);

        Pengumuman::create([
            'judul'           => $request->judul,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'status'          => $request->status,
            'dibuat_oleh'     => Auth::user()->id_user,
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', '✅ Pengumuman berhasil ditambahkan.');
    }

    /**
     * Form edit pengumuman.
     */
    public function edit($id)
    {
        $user       = Auth::user();
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('user', 'pengumuman'));
    }

    /**
     * Update pengumuman.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'           => 'required|string|max:200',
            'isi'             => 'required|string|min:10',
            'tanggal_publish' => 'required|date',
            'status'          => 'required|in:aktif,nonaktif',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'judul'           => $request->judul,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'status'          => $request->status,
        ]);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', '✅ Pengumuman berhasil diperbarui.');
    }

    /**
     * Hapus pengumuman.
     */
    public function destroy($id)
    {
        Pengumuman::findOrFail($id)->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', '🗑️ Pengumuman berhasil dihapus.');
    }

    /**
     * Toggle status aktif / nonaktif.
     */
    public function toggleStatus($id)
    {
        $p = Pengumuman::findOrFail($id);
        $p->update(['status' => $p->status === 'aktif' ? 'nonaktif' : 'aktif']);

        return back()->with('success', 'Status pengumuman berhasil diubah.');
    }
}
