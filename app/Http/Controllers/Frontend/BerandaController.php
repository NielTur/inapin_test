<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function index(): View
    {
        // Ambil 6 villa terbaru yang sudah disetujui admin
        $villasTerbaru = Villa::where('status', 'disetujui')
            ->with(['fasilitasVilla', 'dokumenVilla'])
            ->latest()
            ->take(6)
            ->get();

        // Ambil villa featured (harga tertinggi sebagai proxy "premium")
        $villasFeatured = Villa::where('status', 'disetujui')
            ->with(['fasilitasVilla', 'dokumenVilla'])
            ->orderByDesc('harga')
            ->take(3)
            ->get();

        // Ambil daftar kota unik untuk quick-pick search bar
        $kotaList = Villa::where('status', 'disetujui')
            ->selectRaw('kota, COUNT(*) as total')
            ->groupBy('kota')
            ->orderByDesc('total')
            ->pluck('kota')
            ->take(5);

        return view('frontend.v_beranda.index', compact(
            'villasTerbaru',
            // 'villasFeatured',
            'kotaList'
        ));
    }
}