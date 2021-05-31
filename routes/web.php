<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockObatController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['middleware' => ['role:owner']], function () {

    //Router Supplier
    Route::get('supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('supplier/hapus', [SupplierController::class, 'hapus'])->name('supplier.hapus');

    //Router Obat
    Route::get('obat/index', [ObatController::class, 'index'])->name('obat.index');
    Route::post('obat/store', [ObatController::class, 'store'])->name('obat.store');
    Route::post('obat/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::post('obat/update', [ObatController::class, 'update'])->name('obat.update');
    Route::post('obat/hapus', [ObatController::class, 'hapus'])->name('obat.hapus');

    //Router Stock Obat
    Route::get('stock-obat/index', [StockObatController::class, 'index'])->name('stock-obat.index');
    Route::post('stock-obat/getObat', [StockObatController::class, 'getObat'])->name('stock-obat.getObat');
    Route::post('stock-obat/store', [StockObatController::class, 'store'])->name('stock-obat.store');
    Route::post('stock-obat/edit', [StockObatController::class, 'edit'])->name('stock-obat.edit');
    Route::post('stock-obat/update', [StockObatController::class, 'update'])->name('stock-obat.update');
    Route::post('stock-obat/delete', [StockObatController::class, 'hapus'])->name('stock-obat.hapus');

    //Route Penjualan Barang
    Route::get('penjualan/index', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::post('penjualan/getObat', [PenjualanController::class, 'getObat'])->name('penjualan.getObat');
    Route::post('penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::post('penjualan/edit', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::post('penjualan/update', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::post('penjualan/delete', [PenjualanController::class, 'hapus'])->name('penjualan.hapus');


});

require __DIR__ . '/auth.php';
