<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Stock;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
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

    public function show(string $uuid)
    {
        return response()->json(['data' => Stock::with('barang')->where('uuid', $uuid)->firstOrFail()]);
    }
}
