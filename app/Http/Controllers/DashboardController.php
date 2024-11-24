<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $barang = Barang::all()->count();
        $supplier = Supplier::all()->count();
        $stock = Stock::sum('quantity');
        return view('dashboard.index', compact('barang', 'supplier', 'stock'));
    }
}
