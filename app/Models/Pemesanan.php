<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_villa',
        'id_customer',
        'metode_pembayaran',
        'tanggal_pemesanan',
        'status',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'datetime',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class, 'id_villa', 'id_villa');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function detailPemesanan(): HasOne
    {
        return $this->hasOne(DetailPemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}
