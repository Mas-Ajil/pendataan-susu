<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peternak extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peternak',
        'no_daerah',
        'simpan_pinjam',
        
    ];

    public function setoran()
    {
        return $this->hasMany(Setoran::class);
    }
}
