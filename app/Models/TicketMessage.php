<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $fillable = [
        'ticket_id',
        'sender_type',
        'sender_id',
        'message',
        'attachment',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    
    // Virtual attribute for sender name
    public function getSenderNameAttribute()
    {
        if ($this->sender_type === 'reporter') {
            $reporter = Reporter::find($this->sender_id);
            return $reporter ? $reporter->name : 'Unknown Reporter';
        } else {
            $admin = User::find($this->sender_id);
            return $admin ? $admin->name . ' (Admin)' : 'Admin';
        }
    }
}
