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

    public function __construct(private DetailPembelianService $detailPembelianService)
    {
        $this->middleware('auth');
    }
    public function detailTransaksi(string $uuid)
    {
        $barangs = Barang::all();
        $pembelian = HeaderPembelian::where('uuid', $uuid)->firstOrFail();
        return view('detail_pembelian.index', compact('pembelian', 'barangs'));
    }
    public function dataTable(Request $request, string $notransaksi)
    {
        return $this->detailPembelianService->getDataTable($request, $notransaksi);
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



    public function show(string $id, string $uuid)
    {
        return response()->json(['data' => DetailPembelian::where('uuid', $uuid)->firstOrFail()]);
    }

    public function update(DetailPembelianRequest $request, string $uuid, string $id)
    {
        $data = $request->validated();

        try {
            $this->detailPembelianService->edit($id, $data);
            return response()->json(['message' => 'Berhasil Membuat Data']);
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()]);
        }
    }

    public function destroy(string $uuid, string $id)
    {

        try {

            $this->detailPembelianService->delete($id);
            return response()->json(['message' => 'Data Pembelian berhasil di hapus']);
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()]);
        }
    }
}
