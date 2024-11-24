<?php

namespace App\Service;

use App\Models\Supplier;
use Yajra\DataTables\DataTables;

class SupplierService
{

    public function getDataTable()
    {
        $supplier = Supplier::latest()->get();
        if (request()->ajax()) {
            return DataTables::of($supplier)
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
        return view('supplier.index');
    }

    public function detail(string $uuid)
    {
        return Supplier::where('uuid', $uuid)->first();
    }
}
