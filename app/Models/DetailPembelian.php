<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'no_transaksi',
        'kode_barang',
        'harga_beli',
        'quantity',
        'diskon_barang',
        'total_diskon_barang',
        'total_harga_beli',
    ];

    public function header_pembelian()
    {
        return   $this->belongsTo(HeaderPembelian::class, 'no_transaksi');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang');
    }
}
