<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Penggunaan: ->middleware('role:admin,teknisi')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        // Cek apakah akun aktif
        if (isset($user->status) && $user->status !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['username' => 'Akun Anda telah dinonaktifkan.']);
        }

        $userRole = $user->role;

        if (!in_array($userRole, $roles, true)) {
            // Redirect ke dashboard yang sesuai role user
            if ($userRole === 'teknisi') {
                return redirect()->route('teknisi.dashboard');
            }
            if (in_array($userRole, ['super_admin', 'admin'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('mahasiswa.dashboard');
        }

        return $next($request);
    }
}
