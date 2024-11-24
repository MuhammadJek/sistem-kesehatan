<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Service\BarangService;
use Illuminate\Http\Request;
use DataTable;
use Yajra\DataTables\DataTables;

// use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function __construct(private BarangService $barangService)
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return $this->barangService->getDataTable();
    }

    public function show(string $uuid)
    {
        return response()->json([
            'data' => $this->barangService->detail($uuid),
        ]);
    }
}
