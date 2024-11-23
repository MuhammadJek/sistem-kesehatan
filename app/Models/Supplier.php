<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'kode_supplier',
        'nama_supplier',
    ];


    public function header_pembelians()
    {
        return $this->hasMany(HeaderPembelian::class);
    }
}
