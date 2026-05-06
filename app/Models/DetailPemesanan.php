<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanan';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_pemesanan',
        'id_pembayaran',
        'tanggal_checkin',
        'tanggal_checkout',
        'harga_default',
        'sub_total',
    ];

    protected $casts = [
        'tanggal_checkin'  => 'date',
        'tanggal_checkout' => 'date',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}
