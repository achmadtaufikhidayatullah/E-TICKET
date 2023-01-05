<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'code',
        'booked_ticket_id',
        'bank_name',
        'account_holder_name',
        'grand_total',
        'unique_payment_code',
        'payment_proof',
        'status',
    ];

    public function bookedTicket() {
        return $this->hasOne(BookedTicket::class, 'id', 'booked_ticket_id');
    }
}
