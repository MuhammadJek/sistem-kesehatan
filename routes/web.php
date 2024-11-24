<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/table/barang', [BarangController::class, 'serversideTable'])->name('barang_table');
Auth::routes();

Route::resource('barang', BarangController::class, ['only' => ['index', 'show']]);
Route::resource('supplier', SupplierController::class, ['only' => ['index', 'show']]);
Route::resource('transaksi', PembelianController::class);
Route::get('/detail-transaksi/{uuid}', [DetailPembelianController::class, 'detailTransaksi'])->name('detail.transaksi');
Route::put('/detail-transaksi/{uuid}/{id}', [DetailPembelianController::class, 'update'])->name('detail.transaksi.update');
Route::get('/detail-transaksi/{uuid}/{id}', [DetailPembelianController::class, 'show'])->name('detail.transaksi.show');
Route::delete('/detail-transaksi/{uuid}/{id}', [DetailPembelianController::class, 'destroy'])->name('detail.transaksi.destroy');
Route::get('/data-table/{uuid}', [DetailPembelianController::class, 'dataTable'])->name('detail.dataTable');
Route::post('/detail-transaksi', [DetailPembelianController::class, 'store'])->name('detail.dataTable.store');
Route::resource('/stock', StockController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
