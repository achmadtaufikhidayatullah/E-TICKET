<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $table = 'user_bank_accounts';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'bank_code',
        'bank_name',
        'account_number',
        'user_id',
        'price_per_ticket',
        'sub_total',
        'tax',
        'quantity',
        'tax',
        'status',
    ];

    public function batch() {
        return $this->hasOne(EventBatch::class, 'event_batch_id', 'id');
    }
    
    public function payment() {
        return $this->hasOne(Payment::class, 'booked_ticket_id', 'id');
    }

    public static function ownerAccounts() {
        return self::where('status', 'owner_account')->get();
    }
}
