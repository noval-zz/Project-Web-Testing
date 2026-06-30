<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Tampilkan form reset password.
     */
    public function showForm()
    {
        return view('auth.reset-password');
    }

    /**
     * Proses reset password dengan verifikasi kontak/email.
     *
     * Alur:
     * 1. Cari user berdasarkan username
     * 2. Verifikasi nomor kontak / email sesuai role
     * 3. Jika cocok → reset password
     * 4. Jika tidak cocok → tolak (pesan error generik, anti-enumeration)
     */
    public function reset(Request $request)
    {
        $request->validate([
            'username'                  => 'required|string',
            'kontak_verifikasi'         => 'required|string',
            'new_password'              => 'required|string|min:6|confirmed',
            'new_password_confirmation' => 'required|string',
        ], [
            'username.required'             => 'Username wajib diisi.',
            'kontak_verifikasi.required'    => 'Nomor kontak / email wajib diisi untuk verifikasi.',
            'new_password.required'         => 'Password baru wajib diisi.',
            'new_password.min'              => 'Password minimal 6 karakter.',
            'new_password.confirmed'        => 'Konfirmasi password tidak cocok.',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Verifikasi identitas berdasarkan role
        // Pesan error SENGAJA GENERIK — tidak mengungkapkan apakah username atau kontak yang salah
        $errorMsg = 'Data tidak valid. Pastikan username dan nomor kontak / email yang Anda masukkan sudah benar.';

        if (!$user) {
            return back()->withErrors(['kontak_verifikasi' => $errorMsg])->onlyInput('username');
        }

        $verified = $this->verifyIdentity($user, $request->kontak_verifikasi);

        if (!$verified) {
            return back()->withErrors(['kontak_verifikasi' => $errorMsg])->onlyInput('username');
        }

        // Verifikasi berhasil — reset password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Sinkronisasi ke profil mahasiswa / admin jika ada (Fix BUG-12)
        if (in_array($user->role, ['mahasiswa', 'dosen'])) {
            Mahasiswa::where('Nim', (string) $user->username)->update(['Sandi' => $user->password]);
        } elseif ($user->role === 'admin') {
            Admin::where('nip', $user->username)->update(['sandi' => $user->password]);
        }

        return redirect()->route('login')
                         ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }

    /**
     * Verifikasi identitas user berdasarkan role.
     * Mencocokkan nomor kontak atau email terdaftar.
     *
     * @param  User   $user
     * @param  string $input  Nomor kontak / email yang diinput
     * @return bool
     */
    private function verifyIdentity(User $user, string $input): bool
    {
        $input = trim($input);

        // Cek email di tabel user (berlaku untuk semua role)
        if (!empty($user->email) && strtolower($user->email) === strtolower($input)) {
            return true;
        }

        // Helper untuk normalisasi kontak (hapus awalan 0 dan karakter non-digit)
        $normalizeKontak = fn($val) => ltrim(preg_replace('/[^0-9]/', '', (string)$val), '0');
        $inputKontak = $normalizeKontak($input);

        // Cek kontak sesuai role
        switch ($user->role) {
            case 'mahasiswa':
            case 'dosen':
                $mhs = Mahasiswa::where('Nim', (string) $user->username)->first();
                if ($mhs && $normalizeKontak($mhs->Kontak) === $inputKontak) {
                    return true;
                }
                break;

            case 'admin':
                $admin = Admin::where('nama_admin', 'like', '%' . $user->username . '%')->first()
                    ?? Admin::where('nip', $user->username)->first();
                if ($admin && $normalizeKontak($admin->kontak) === $inputKontak) {
                    return true;
                }
                break;

            // teknisi & super_admin: hanya bisa via email (tidak ada tabel profil terpisah)
            // Jika email belum diset, mereka perlu hubungi super_admin untuk reset manual
        }

        return false;
    }
}
