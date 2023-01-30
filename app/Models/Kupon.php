<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kupon extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'kupon';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nama_kupon',
        'jumlah_kupon',
        'tipe_kupon',
        'event_id',
        'kode_kupon',
        'tipe_potongan',
        'value',
        'kadaluarsa',
    ];

    public function eventBatch() {
        return $this->belongsTo(EventBatch::class, 'event_id', 'id');
    }
}
