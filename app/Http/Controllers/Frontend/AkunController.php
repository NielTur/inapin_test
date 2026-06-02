<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AkunController extends Controller
{
    public function profil(): View
    {
        $user = Auth::user();
        return view('frontend.v_akun.profil', compact('user'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'nama'          => 'required|string|max:100',
            'phone'         => 'required|string|min:9|max:20',
            'tanggal_lahir' => 'required|date',
            'password_baru' => 'nullable|min:8|confirmed',
        ], [
            'nama.required'           => 'Nama lengkap wajib diisi.',
            'phone.min'               => 'No. handphone minimal 9 digit.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'password_baru.min'       => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->nama          = $request->nama;
        $user->phone         = $request->phone;
        $user->tanggal_lahir = $request->tanggal_lahir;

        // Ganti password hanya kalau diisi
        if ($request->filled('password_baru')) {
            $user->password = Hash::make($request->password_baru);
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($user->foto && \Storage::exists('public/' . $user->foto)) {
                \Storage::delete('public/' . $user->foto);
            }
            $user->foto = $request->file('foto')->store('foto_profil', 'public');
        }

        $user->save();

        return redirect()->route('akun.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
