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
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->char('no_transaksi', 10);
            $table->char('kode_barang', 10);
            $table->integer('harga_beli');
            $table->integer('quantity');
            $table->integer('diskon_barang');
            $table->integer('total_diskon_barang');
            $table->integer('total_harga_beli');
            $table->foreign('no_transaksi')->references('no_transaksi')->on('header_pembelians')->onDelete('cascade');
            $table->foreign('kode_barang')->references('kode_barang')->on('barangs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelians');
    }
};
