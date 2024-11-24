<?php

namespace App\Service;

use App\Models\HeaderPembelian;
use App\Models\Supplier;
use Yajra\DataTables\DataTables;

class PembelianService
{

    public function getUUID($uuid)
    {
        return  HeaderPembelian::where('uuid', $uuid)->firstOrFail();
    }
    public function create(array $data)
    {
        $pembelian = HeaderPembelian::all();

        return HeaderPembelian::create([
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'no_transaksi' => $pembelian->pluck('id')->isEmpty() ? 'B' . date('Ym') . str_pad(1, 3, '0', STR_PAD_LEFT) : 'B' . date('Ym') . str_pad($pembelian->pluck('id')->last() + 1, 3, '0', STR_PAD_LEFT),
            'kode_supplier' => $data['kode_supplier'],
            'tanggal_beli' => $data['tanggal_beli'],
        ]);
    }

    public function edit(array $data, string $uuid)
    {
        return HeaderPembelian::where('uuid', $uuid)->first()->update([
            'kode_supplier' => $data['kode_supplier'],
            'tanggal_beli' => $data['tanggal_beli'],
        ]);
    }

    public function delete(string $uuid)
    {
        return  HeaderPembelian::where('uuid', $uuid)->firstOrFail()->delete();
    }
    public function getDataTable()
    {
        $pembelianGet = HeaderPembelian::with(['supplier'])->latest()->get();
        if (request()->ajax()) {
            return DataTables::of($pembelianGet)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . Route('detail.transaksi', $row->uuid) . '" class="btn btn-success mx-2" >Detail</a>';
                    $btn  = $btn . '<button class="btn btn-primary mx-2" onclick="showEditModal(this)" data-id="' . $row->uuid . '">Edit</button>';

                    $btn =   $btn . '<button class="btn btn-danger mx-2" onclick="deleteModal(this)" data-id="' . $row->uuid . '">Delete</button>';
                    // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $supplier = Supplier::all();
        // }
        // dd($pembelian->pluck('id')->isEmpty() ? 'B' . date('Ym') . str_pad(1, 3, '0', STR_PAD_LEFT) : 'B' . date('Ym') . str_pad($pembelian->pluck('id')->last() + 1, 3, '0', STR_PAD_LEFT));
        return view('pembelian.index', compact('supplier'));
    }
}
