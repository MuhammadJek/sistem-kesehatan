<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('header_pembelians', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->char('no_transaksi', 10)->unique();
            $table->char('kode_supplier', 10);
            $table->date('tanggal_beli');
            $table->foreign('kode_supplier')->references('kode_supplier')->on('suppliers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_pembelians');
    }
};
