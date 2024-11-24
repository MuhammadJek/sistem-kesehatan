<?php

namespace App\Service;

use App\Models\Stock;
use Yajra\DataTables\DataTables;

class StockService
{
    public function getDataTable()
    {
        $stock = Stock::get();
        if (request()->ajax()) {
            return DataTables::of($stock)
                ->addIndexColumn()
                ->editColumn('nama_barang', function ($data) {
                    return $data->barang->nama_barang;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="btn btn-success" onclick="showDetailModal(this)" data-id="' . $row->uuid . '">Detail
</button>';

                    // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('stock.index');
    }


    public function detail(string $uuid)
    {
        return  Stock::with('barang')->where('uuid', $uuid)->firstOrFail();
    }
}
