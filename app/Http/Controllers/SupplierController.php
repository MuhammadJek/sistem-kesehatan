<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Service\SupplierService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    public function __construct(private SupplierService $supplierService)
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        return $this->supplierService->getDataTable();
    }
    public function show(string $uuid)
    {
        return response()->json([
            'data' => $this->supplierService->detail($uuid),
        ]);
    }
}
