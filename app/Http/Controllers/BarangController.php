<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use DataTable;
use Yajra\DataTables\DataTables;

// use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
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

    public function show(string $id)
    {
        return response()->json([
            'data' => Barang::where('uuid', $id)->first(),
        ]);
    }
    public function serversideTable(Request $request) {}
}
