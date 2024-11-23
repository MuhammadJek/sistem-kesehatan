<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama_supplier = ['PT jarum suntik', 'PT Obat Bius', 'PT Paracetamol', 'PT Ctm'];
        return [
            'uuid' =>  \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'kode_supplier' => Str::random(10),
            'nama_supplier' => fake()->randomElement($nama_supplier),
        ];
    }
}
