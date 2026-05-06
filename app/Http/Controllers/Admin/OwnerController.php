<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OwnerController extends Controller
{
    public function index(): View
    {
        $owners = Owner::withCount('villa')->latest()->get();
        return view('backend.v_owner.index', compact('owners'));
    }

    public function destroy($id): RedirectResponse
    {
        Owner::findOrFail($id)->delete();
        return back()->with('success', 'Data owner berhasil dihapus.');
    }
}
