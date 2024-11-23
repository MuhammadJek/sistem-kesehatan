<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailPembelianRequest;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\HeaderPembelian;
use App\Models\Stock;
use App\Service\DetailPembelianService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DetailPembelianController extends Controller
{

    public function __construct(private DetailPembelianService $detailPembelianService) {}
    public function detailTransaksi(string $uuid)
    {
        $barangs = Barang::all();
        $pembelian = HeaderPembelian::where('uuid', $uuid)->firstOrFail();

        // $this->detailPembelianService->getDataTable();
        // $totalqQuantity = DetailPembelian::sum('quantity');
        // dd($totalqQuantity);
        return view('detail_pembelian.index', compact('pembelian', 'barangs'));
    }
    public function dataTable(string $notransaksi)
    {
        return $this->detailPembelianService->getDataTable($notransaksi);
    }

    public function store(DetailPembelianRequest $request)
    {
        $data = $request->validated();

        try {
            $this->detailPembelianService->create($data);
            return response()->json(['message' => 'Barang pembelian Berhasil dibuat']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }
}
