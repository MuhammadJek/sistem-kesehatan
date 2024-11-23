<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'no_transaksi',
        'kode_supplier',
        'tanggal_beli',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'kode_supplier', 'kode_supplier');
    }

    public function detail_pembelian()
    {
        return $this->hasMany(DetailPembelian::class);
    }
}
