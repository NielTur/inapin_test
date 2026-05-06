<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenVilla extends Model
{
    protected $table = 'dokumen_villa';
    protected $primaryKey = 'id_dokumen_villa';

    protected $fillable = [
        'id_villa',
        'id_owner',
        'file_path',
        'status',
    ];

    public function villa(): BelongsTo
    {
        return $this->belongsTo(Villa::class, 'id_villa', 'id_villa');
    }
}
