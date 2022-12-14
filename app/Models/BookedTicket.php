<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedTicket extends Model
{
    use HasFactory;

    protected $table = 'booked_tickets';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'code',
        'event_batch_id',
        'user_id',
        'price_per_ticket',
        'sub_total',
        'tax',
        'quantity',
        'tax',
        'status',
    ];

    public function batch() 
    {
        return $this->belongsTo(EventBatch::class, 'event_batch_id', 'id');
    }
    
    public function payment() 
    {
        return $this->hasOne(Payment::class, 'booked_ticket_id', 'id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'booked_ticket_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
