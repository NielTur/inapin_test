<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('frontend.v_auth.login');
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

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('beranda'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->nama . '!');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah. Silakan coba lagi.');
    }

    public function showRegister(): View
    {
        return view('frontend.v_auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email|unique:customer,email',
            'phone'         => 'required|string|min:9|max:20',
            'tanggal_lahir' => 'required|date',
            'password'      => 'required|min:8|confirmed',
            ], 
            [
            'nama.required'          => 'Nama lengkap wajib diisi.',
            'email.required'         => 'Email wajib diisi.',
            'email.unique'           => 'Email sudah terdaftar.',
            'phone.min'              => 'No. handphone minimal 9 digit.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'password.required'      => 'Password wajib diisi.',
            'password.min'           => 'Password minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Customer::create([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'tanggal_lahir' => $request->tanggal_lahir,
            'password'      => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('beranda')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->nama . '!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
