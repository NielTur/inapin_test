<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FasilitasVilla extends Model
{
    protected $table = 'fasilitas_villa';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'id_villa',
        'fasilitas',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class, 'id_villa', 'id_villa');
    }
}
