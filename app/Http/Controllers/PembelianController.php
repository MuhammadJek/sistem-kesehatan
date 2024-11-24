<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembelianRequest;
use App\Models\HeaderPembelian;
use App\Models\Supplier;
use App\Service\PembelianService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PembelianController extends Controller
{

    public function __construct(private PembelianService $service)
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        return  $this->service->getDataTable();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PembelianRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            //code...
            $this->service->create($data);

            return response()->json(['message' => 'Transaksi Berhasil dibuat']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return response()->json([
            'data' => $this->service->getUUID($uuid),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PembelianRequest $request, string $uuid)
    {
        $data = $request->validated();

        try {
            $this->service->edit($data, $uuid);
            return response()->json(['message' => 'Transaksi Berhasil dibuat']);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {

        $this->service->delete($uuid);
        return response()->json(['message' => 'Data Pembelian berhasil di hapus']);
    }
}
