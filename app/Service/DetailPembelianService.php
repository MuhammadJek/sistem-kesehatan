<?php

namespace App\Service;

use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;
use App\Models\Stock;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DetailPembelianService
{
    public function getDataTable(Request $request, string $notransaksi)
    {
        $detailPembelian = DetailPembelian::where('no_transaksi', $notransaksi)->latest()->get();
        if (request()->ajax()) {
            return DataTables::of($detailPembelian)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn  =  '<button class="btn btn-primary mx-2" onclick="showEditModal(this)" data-id="' . $row->uuid . '">Edit</button>';
                    $btn =   $btn . '<button class="btn btn-success mx-2 my-2" onclick="showDetailModal(this)" data-id="' . $row->uuid . '">Detail</button>';
                    $btn =   $btn . '<button class="btn btn-danger mx-2 " onclick="deleteModal(this)" data-id="' . $row->uuid . '">Delete</button>';
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
    public function detail(string $uuid)
    {
        return  DetailPembelian::where('uuid', $uuid)->firstOrFail();
    }
    public function edit(string $id, array $data)
    {
        $total_harga_beli =  $data['quantity'] * $data['harga_beli'];
        $total_diskon_barang = $total_harga_beli * $data['diskon_barang'] / 100;
        $detailPembelian = DetailPembelian::where('uuid', $id)->firstOrFail();
        $stockUpdate = Stock::where('kode_barang', $detailPembelian->kode_barang)->firstOrFail();
        $stockBarang = Stock::where('kode_barang', $data['kode_barang'])->first();
        if ($stockBarang == null) {
            $totalQuantity = DetailPembelian::where('kode_barang', $stockUpdate->kode_barang)->sum('quantity');
            $stockUpdate->update([
                'quantity' => $totalQuantity
            ]);
            Stock::create([
                'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'kode_barang' => $data['kode_barang'],
                'quantity' => $data['quantity']
            ]);
        }
        $detailPembelian->update([
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
        }
    }

    public function delete(string $id)
    {
        $detailPembelian =  DetailPembelian::where('uuid', $id)->firstOrFail();

        Stock::where('kode_barang', $detailPembelian->kode_barang)->decrement('quantity', $detailPembelian->quantity);
        DetailPembelian::where('uuid', $id)->firstOrFail()->delete();
    }
}
