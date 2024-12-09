<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setoran extends Model
{
    use HasFactory;

    protected $fillable = [
        'peternak_id',
        'jumlah_pagi',
        'jumlah_sore',
        'jumlah_setoran',
        'tanggal_setoran',
        
    ];

    public function peternak()
    {
        return $this->belongsTo(Peternak::class);
    }
}
