<?php

use App\Http\Controllers\DashboardController;
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

Route::group(['middleware' => ['role:owner']], function() {
    //Route::resource('supplier', SupplierController::class);
    Route::get('supplier/index', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('supplier/hapus', [SupplierController::class, 'hapus'])->name('supplier.hapus');
});

require __DIR__ . '/auth.php';
