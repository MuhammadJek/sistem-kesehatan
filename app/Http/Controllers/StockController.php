<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Stock;
use App\Service\StockService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockController extends Controller
{
    public function __construct(private StockService $stockService)
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return $this->stockService->getDataTable();
    }

    public function show(string $uuid)
    {
        return response()->json(['data' => $this->stockService->detail($uuid)]);
    }
}
