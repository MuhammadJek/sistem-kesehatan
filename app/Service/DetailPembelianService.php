<?php

namespace App\Service;

use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;
use App\Models\Stock;
use Yajra\DataTables\DataTables;

class DetailPembelianService
{
    public function getDataTable(string $notransaksi)
    {
        $detailPembelian = DetailPembelian::where('no_transaksi', $notransaksi)->get();
        if (request()->ajax()) {
            return DataTables::of($detailPembelian)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn  =  '<button class="btn btn-primary mx-2" onclick="showEditModal(this)" data-id="' . $row->uuid . '">Edit</button>';

                    $btn =   $btn . '<button class="btn btn-danger mx-2" onclick="deleteModal(this)" data-id="' . $row->uuid . '">Delete</button>';
                    // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function create(array $data)
    {
        $total_harga_beli =  $data['quantity'] * $data['harga_beli'];
        $total_diskon_barang = $total_harga_beli * $data['diskon_barang'] / 100;
        $createDetailPembelian = DetailPembelian::create([
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'no_transaksi' => $data['no_transaksi'],
            'kode_barang' => $data['kode_barang'],
            'harga_beli' => $data['harga_beli'],
            'quantity' => $data['quantity'],
            'diskon_barang' => $data['diskon_barang'],
            'total_diskon_barang' => $total_diskon_barang,
            'total_harga_beli' => $total_harga_beli,
        ]);

        $stock = Stock::where('kode_barang', $data['kode_barang'])->first();
        if ($stock != null) {
            $totalQuantity = DetailPembelian::where('kode_barang', $data['kode_barang'])->sum('quantity');
            $stock->update(['quantity' => $totalQuantity]);
        } else if ($stock == null) {
            Stock::create([
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'kode_barang' => $data['kode_barang'],
                'quantity' => $data['quantity']
            ]);
        }
    }
}
