<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'code',
        'booked_ticket_id',
        'status',
    ];

    public function bookedTicket() {
        return $this->belongsTo(BookedTicket::class, 'booked_ticket_id', 'id');
    }
}
