<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Models\FasilitasVilla;
use App\Models\DokumenVilla;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VillaController extends Controller
{
    public function index(): View
    {
        $villas = Villa::where('id_owner', Auth::id())
            ->with(['fasilitasVilla', 'dokumenVilla'])
            ->latest()
            ->paginate(10);

        return view('owner.v_villa.index', compact('villas'));
    }

    public function create(): View
    {
        return view('owner.v_villa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_villa' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kota' => 'required|string|max:50',
            'alamat' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_villa.required' => 'Nama villa wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'kota.required' => 'Kota wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'kapasitas.required' => 'Kapasitas wajib diisi.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Simpan villa — status default pending, menunggu persetujuan admin
        $villa = Villa::create([
            'id_owner' => Auth::id(),
            'nama_villa' => $request->nama_villa,
            'deskripsi' => $request->deskripsi,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'harga' => $request->harga,
            'kapasitas' => $request->kapasitas,
            'jumlah_kamar' => $request->jumlah_kamar,
            'jumlah_kamar_mandi' => $request->jumlah_kamar_mandi,
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'tiktok' => $request->tiktok,
            'status' => 'pending',
        ]);

        // Simpan fasilitas
        if ($request->filled('fasilitas')) {
            foreach ($request->fasilitas as $fas) {
                if (trim($fas)) {
                    FasilitasVilla::create([
                        'id_villa' => $villa->id_villa,
                        'fasilitas' => trim($fas),
                    ]);
                }
            }
        }

        // Upload foto
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_villa', 'public');
                DokumenVilla::create([
                    'id_villa' => $villa->id_villa,
                    'id_owner' => Auth::id(),
                    'file_path' => $path,
                    'status' => 'disetujui',
                ]);
            }
        }

        return redirect()->route('owner.villa.index')
            ->with('success', 'Villa berhasil ditambahkan! Menunggu persetujuan admin.');
    }

    public function edit($id): View
    {
        $villa = Villa::where('id_villa', $id)
            ->where('id_owner', Auth::id())
            ->with(['fasilitasVilla', 'dokumenVilla'])
            ->firstOrFail();

        return view('owner.v_villa.edit', compact('villa'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $villa = Villa::where('id_villa', $id)
            ->where('id_owner', Auth::id())
            ->firstOrFail();

        $request->validate([
            'nama_villa' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'kota' => 'required|string|max:50',
            'alamat' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:pending,disetujui,ditolak,nonaktif',
            'fasilitas' => 'nullable|array',
            'foto.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $villa->update([
            'nama_villa' => $request->nama_villa,
            'deskripsi' => $request->deskripsi,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'harga' => $request->harga,
            'kapasitas' => $request->kapasitas,
            'jumlah_kamar' => $request->jumlah_kamar,
            'jumlah_kamar_mandi' => $request->jumlah_kamar_mandi,
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'tiktok' => $request->tiktok,
            'status' => $request->status,
        ]);

        // Update fasilitas — hapus lama, insert baru
        $villa->fasilitasVilla()->delete();
        if ($request->filled('fasilitas')) {
            foreach ($request->fasilitas as $fas) {
                if (trim($fas)) {
                    FasilitasVilla::create([
                        'id_villa' => $villa->id_villa,
                        'fasilitas' => trim($fas),
                    ]);
                }
            }
        }

        // Upload foto baru
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_villa', 'public');
                DokumenVilla::create([
                    'id_villa' => $villa->id_villa,
                    'id_owner' => Auth::id(),
                    'file_path' => $path,
                    'status' => 'disetujui',
                ]);
            }
        }

        return redirect()->route('owner.villa.index')
            ->with('success', 'Villa berhasil diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        $villa = Villa::where('id_villa', $id)
            ->where('id_owner', Auth::id())
            ->firstOrFail();

        // Hapus foto dari storage
        foreach ($villa->dokumenVilla as $dok) {
            Storage::disk('public')->delete($dok->file_path);
        }

        $villa->fasilitasVilla()->delete();
        $villa->dokumenVilla()->delete();
        $villa->delete();

        return redirect()->route('owner.villa.index')
            ->with('success', 'Villa berhasil dihapus.');
    }
}