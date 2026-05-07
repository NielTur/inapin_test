<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        // Kalau udah login sebagai owner, langsung ke dashboard
        if (Auth::guard('owner')->check()) {
            return redirect()->route('owner.dashboard');
        }

        return view('owner.v_auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::guard('owner')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('owner.dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::guard('owner')->user()->nama . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('owner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('owner.login')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
