<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offline extends Model
{
    use HasFactory;

    protected $table = 'offline';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'code',
        'nik',
        'email',
        'phone',
        'booked_ticket_id',
    ];

    public function bookedTicket() {
        return $this->hasOne(BookedTicket::class, 'id', 'booked_ticket_id');
    }
}
