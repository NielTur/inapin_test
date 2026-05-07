<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Owner extends Authenticatable
{
    use Notifiable;

    protected $table      = 'owner';
    protected $primaryKey = 'id_owner';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'phone',
        'alamat',
        'nik',
        'tanggal_lahir',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'password'      => 'hashed',
    ];

    public function villa(): HasMany
    {
        return $this->hasMany(Villa::class, 'id_owner', 'id_owner');
    }
}
