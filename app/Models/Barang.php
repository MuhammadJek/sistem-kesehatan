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

    public function stock()
    {
        return  $this->hasMany(Stock::class, 'kode_barang', 'kode_barang');
    }
    public function detail_pembelians()
    {
        return $this->hasMany(DetailPembelian::class);
    }
}
