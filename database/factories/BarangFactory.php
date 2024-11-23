<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $satuan = ['kg', 'gram', 'pcs', 'lusin', 'pak', 'dus', 'liter', 'box'];
        $nama_barang = ['jarum suntik', 'pil ctm', 'sarung tangan', 'obat cair', 'termometer', 'kertas', 'alkohol', 'map'];
        return [
            'uuid' =>  \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'kode_barang' => Str::random(10),
            'nama_barang' => fake()->randomElement($nama_barang),
            'satuan_barang' => fake()->randomElement($satuan),
            'harga_beli' => fake()->randomNumber(4),
        ];
    }
}
