<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Reporter extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp',
        'type',
        'nip',
        'nik',
    ];

    protected $hidden = [
        'password',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
