<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;


    protected $fillable = [
        'uuid',
        'kode_barang',
        'quantity',
    ];

    public function barang()
    {
        $this->belongsTo(Barang::class, 'kode_barang');
    }
}
