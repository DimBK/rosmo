<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'reporter_id',
        'ticket_number',
        'subject',
        'status',
    ];

    public function reporter()
    {
        return $this->belongsTo(Reporter::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }
}
