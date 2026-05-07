<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AkunController extends Controller
{
    public function profil(): View
    {
        $owner = Auth::guard('owner')->user();
        return view('owner.v_akun.profil', compact('owner'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        $owner = Auth::guard('owner')->user();

        $request->validate([
            'nama'          => 'required|string|max:100',
            'phone'         => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable|string|max:255',
            'nik'           => 'nullable|string|size:16',
            'password_baru' => 'nullable|min:8|confirmed',
        ], [
            'nama.required'            => 'Nama lengkap wajib diisi.',
            'phone.required'           => 'No. handphone wajib diisi.',
            'tanggal_lahir.required'   => 'Tanggal lahir wajib diisi.',
            'nik.size'                 => 'NIK harus 16 digit.',
            'password_baru.min'        => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek password lama kalau mau ganti password
        if ($request->filled('password_baru')) {
            if (! Hash::check($request->password_lama, $owner->password)) {
                return back()->with('error', 'Password lama tidak sesuai.');
            }
            $owner->password = Hash::make($request->password_baru);
        }

        $owner->nama          = $request->nama;
        $owner->phone         = $request->phone;
        $owner->tanggal_lahir = $request->tanggal_lahir;
        $owner->alamat        = $request->alamat;
        $owner->nik           = $request->nik;

        if ($request->hasFile('foto')) {
            if ($owner->foto && Storage::exists('public/' . $owner->foto)) {
                Storage::delete('public/' . $owner->foto);
            }
            $owner->foto = $request->file('foto')->store('foto_owner', 'public');
        }

        $owner->save();

        return redirect()->route('owner.akun.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
