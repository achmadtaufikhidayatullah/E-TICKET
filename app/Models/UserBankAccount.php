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
        'user_id',
        'bank_code',
        'bank_name',
        'account_number',
        'account_holder_name',
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
