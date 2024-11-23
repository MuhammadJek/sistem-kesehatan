<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailPembelianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'no_transaksi' => 'required|exists:header_pembelians,no_transaksi',
            'kode_barang' => 'required|exists:barangs,kode_barang|max:10',
            'harga_beli' => 'required|integer',
            'quantity' => 'required|integer',
            'diskon_barang' => 'required|integer|max:100'
        ];
    }
}
