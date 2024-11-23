<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'kode_barang',
        'nama_barang',
        'satuan_barang',
        'harga_beli',
    ];

    public function detail_pembelians()
    {
        $this->hasMany(DetailPembelian::class);
    }

    public function stocks()
    {
        $this->hasMany(Stock::class);
    }
}
