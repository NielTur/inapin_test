<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Villa;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function form($id, Request $request): View
    {
        $villa = Villa::where('id_villa', $id)
            ->where('status', 'aktif')
            ->with(['fasilitasVilla', 'dokumenVilla'])
            ->firstOrFail();

        $checkin  = $request->get('checkin', date('Y-m-d'));
        $checkout = $request->get('checkout', date('Y-m-d', strtotime('+1 day')));
        $tamu     = $request->get('tamu', 1);

        // Hitung jumlah malam & total harga
        $malam = max(1, (int) ((strtotime($checkout) - strtotime($checkin)) / 86400));
        $total = $malam * $villa->harga;

        return view('frontend.v_booking.form', compact(
            'villa',
            'checkin',
            'checkout',
            'tamu',
            'malam',
            'total'
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_villa'          => 'required|exists:villa,id_villa',
            'tanggal_checkin'   => 'required|date|after_or_equal:today',
            'tanggal_checkout'  => 'required|date|after:tanggal_checkin',
            'metode_pembayaran' => 'required|string',
        ], [
            'tanggal_checkin.after_or_equal'  => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'tanggal_checkout.after'           => 'Tanggal check-out harus setelah check-in.',
            'metode_pembayaran.required'       => 'Pilih metode pembayaran.',
        ]);

        $villa = Villa::findOrFail($request->id_villa);
        $malam = (int) ((strtotime($request->tanggal_checkout) - strtotime($request->tanggal_checkin)) / 86400);
        $total = $malam * $villa->harga;

        // Simpan pemesanan
        $pemesanan = Pemesanan::create([
            'id_villa'          => $villa->id_villa,
            'id_customer'       => Auth::id(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_pemesanan' => now(),
        ]);

        // Simpan detail pemesanan
        DetailPemesanan::create([
            'id_pemesanan'     => $pemesanan->id_pemesanan,
            'tanggal_checkin'  => $request->tanggal_checkin,
            'tanggal_checkout' => $request->tanggal_checkout,
            'harga_default'    => $villa->harga,
            'sub_total'        => $total,
        ]);

        return redirect()->route('booking.riwayat')
            ->with('success', 'Pemesanan berhasil! Menunggu konfirmasi dari owner villa.');
    }

    public function riwayat(): View
    {
        $pemesanan = Pemesanan::where('id_customer', Auth::id())
            ->with(['villa', 'detailPemesanan'])
            ->latest()
            ->get();

        return view('frontend.v_booking.riwayat', compact('pemesanan'));
    }

    public function batal($id): RedirectResponse
    {
        $pemesanan = Pemesanan::where('id_pemesanan', $id)
            ->where('id_customer', Auth::id())
            ->where('status', 'menunggu')
            ->firstOrFail();

        $pemesanan->update(['status' => 'dibatalkan']);

        return redirect()->route('booking.riwayat')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    public function hapus($id): RedirectResponse
    {
        $pemesanan = Pemesanan::where('id_pemesanan', $id)
            ->where('id_customer', Auth::id())
            ->where('status', 'dibatalkan')
            ->firstOrFail();

        $pemesanan->detailPemesanan()->delete();
        $pemesanan->delete();

        return redirect()->route('booking.riwayat')
            ->with('success', 'Riwayat pemesanan berhasil dihapus.');
    }
}
