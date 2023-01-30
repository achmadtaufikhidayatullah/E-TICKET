<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBatch extends Model
{
    use HasFactory;

    protected $table = 'event_batches';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'event_id',
        'name',
        'start_date',
        'end_date',
        'description',
        'price',
        'kupon_status',
        'kupon_aktif',
        'max_ticket',
        'status',
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function bookedTickets()
    {
        return $this->hasMany(BookedTicket::class, 'event_batch_id');
    }

    public function kupon() {
        return $this->belongsTo(Kupon::class, 'kupon_aktif', 'id');
    }

    public function quota()
    {
        $quota = 0;
        $bookedTickets = $this->bookedTickets->where('status', 'payment_successful');
        foreach($bookedTickets as $bookedTicket) {
            $quota += $bookedTicket->tickets->where('status', 'payment_successful')->count();
        }

        return $quota;
    }

    public function isFull()
    {
        return $this->quota() >= $this->max_ticket;
    }

    public function isActive()
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->start_date);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->end_date);

        return $this->status == "Aktif" && (today()->gte($startDate) || $endDate->gte(today()));
    }
}
