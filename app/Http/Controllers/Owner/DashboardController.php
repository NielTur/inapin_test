<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Villa;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $idOwner = Auth::id();

        // Statistik villa
        $totalVilla  = Villa::where('id_owner', $idOwner)->count();
        $villaAktif  = Villa::where('id_owner', $idOwner)->where('status', 'aktif')->count();

        // Statistik pesanan
        $totalPesanan     = Pemesanan::whereHas('villa', fn($q) => $q->where('id_owner', $idOwner))->count();
        $pesananMenunggu  = Pemesanan::whereHas('villa', fn($q) => $q->where('id_owner', $idOwner))
            ->where('status', 'menunggu')->count();
        $pesananKonfirmasi = Pemesanan::whereHas('villa', fn($q) => $q->where('id_owner', $idOwner))
            ->where('status', 'dikonfirmasi')->count();

        // Total pendapatan (dari pesanan yang dikonfirmasi)
        $totalPendapatan = Pemesanan::whereHas('villa', fn($q) => $q->where('id_owner', $idOwner))
            ->where('status', 'dikonfirmasi')
            ->with('detailPemesanan')
            ->get()
            ->sum(fn($p) => $p->detailPemesanan?->sub_total ?? 0);

        // 5 pesanan terbaru
        $pesananTerbaru = Pemesanan::whereHas('villa', fn($q) => $q->where('id_owner', $idOwner))
            ->with(['villa', 'customer', 'detailPemesanan'])
            ->latest()
            ->take(5)
            ->get();

        return view('owner.v_dashboard.index', compact(
            'totalVilla',
            'villaAktif',
            'totalPesanan',
            'pesananMenunggu',
            'pesananKonfirmasi',
            'totalPendapatan',
            'pesananTerbaru'
        ));
    }
}
