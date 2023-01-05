<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'code',
        'start_date',
        'end_date',
        'description',
        'image',
        'contact_persons',
        'status',
    ];

    public function batches() {
        return $this->hasMany(EventBatch::class, 'event_id', 'id');
    }

    public function whatsappLink()
    {
        return 'http://wa.me/62' . substr($this->contact_persons, 1);
    }
}
