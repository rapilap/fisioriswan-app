<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    /** Batas salah password per email + IP sebelum dikunci sementara. */
    private const MAKS_PERCOBAAN = 5;

    /** Lama kunci (detik) setelah batas tercapai. */
    private const LAMA_KUNCI = 900;

    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.testimoni.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        // Kunci per kombinasi email + IP: menebak password satu akun dari banyak
        // percobaan akan berhenti, tanpa mengunci admin asli yang login dari IP lain.
        $kunci = 'admin-login:'.Str::lower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($kunci, self::MAKS_PERCOBAAN)) {
            $menit = (int) ceil(RateLimiter::availableIn($kunci) / 60);

            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Coba lagi dalam {$menit} menit.",
            ])->onlyInput('email');
        }

        // Akun non-admin diperlakukan sama seperti password salah: pesan yang sama
        // agar penyerang tidak bisa mengetahui email mana yang terdaftar.
        if (! Auth::attempt($credentials) || Auth::user()->role !== 'admin') {
            if (Auth::check()) {
                Auth::logout();
            }

            RateLimiter::hit($kunci, self::LAMA_KUNCI);
            Log::warning('Login admin gagal', ['email' => $credentials['email'], 'ip' => $request->ip()]);

            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ])->onlyInput('email');
        }

        RateLimiter::clear($kunci);

        // Ganti ID sesi agar sesi lama (mungkin dicuri sebelum login) tidak ikut menjadi admin.
        $request->session()->regenerate();
        Log::info('Login admin berhasil', ['user_id' => Auth::id(), 'ip' => $request->ip()]);

        return redirect()->intended(route('admin.testimoni.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
