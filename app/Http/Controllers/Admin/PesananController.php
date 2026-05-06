<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function index(): View
    {
        $pesanan = Pemesanan::with(['villa', 'customer', 'detailPemesanan'])
            ->latest()->get();
        return view('backend.v_pesanan.index', compact('pesanan'));
    }
}
