<?php

namespace App\Service;

use App\Models\Barang;
use Yajra\DataTables\DataTables;

class BarangService
{
    public function getDataTable()
    {
        $product = Barang::latest()->get();
        if (request()->ajax()) {
            return DataTables::of($product)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="btn btn-success" onclick="showDetailModal(this)" data-id="' . $row->uuid . '">Detail
</button>';

                    // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // }
        return view('barang.index');
    }

    public function detail(string $uuid)
    {
        return Barang::where('uuid', $uuid)->first();
    }
}
