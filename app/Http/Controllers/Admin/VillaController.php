<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillaController extends Controller
{
    public function index(): View
    {
        $villas = Villa::with(['owner', 'dokumenVilla'])->latest()->get();
        return view('backend.v_villa.index', compact('villas'));
    }

    public function updateStatus(Request $request, $id): RedirectResponse
    {
        $villa = Villa::findOrFail($id);
        $villa->update(['status' => $request->status]);
        return back()->with('success', 'Status villa berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        Villa::findOrFail($id)->delete();
        return back()->with('success', 'Villa berhasil dihapus.');
    }
}
