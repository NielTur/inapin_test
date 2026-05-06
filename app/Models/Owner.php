<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    protected $table = 'owner';
    protected $primaryKey = 'id_owner';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'phone',
        'alamat',
        'nik',
        'tanggal_lahir',
    ];

    protected $hidden = ['password'];

    public function villa(): HasMany
    {
        return $this->hasMany(Villa::class, 'id_owner', 'id_owner');
    }
}
