<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBatch extends Model
{
    use HasFactory;

    protected $table = 'event_batches';
    public $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'event_id',
        'name',
        'start_date',
        'end_date',
        'description',
        'price',
        'max_ticket',
        'status',
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
