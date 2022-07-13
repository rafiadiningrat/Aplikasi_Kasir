<?php

use Illuminate\Support\Facades\Route;
use App\Models\master_barang;
use App\Models\transaksi_pembelian;
use App\Models\transaksi_pembelian_barang;
use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoginController;



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
    return view('home');
});

Route::get('/product', function () {
    return view('products.index', [
        'products'=> master_barang::all()
    ]);
});


// Route::get('/history_transaction', function () {
//     return view('transaction.history');
// });

// Route::get('/transaction', [TransactionController::class, 'index'])->middleware('auth');
Route::get('/findProductId', [ProductController::class, 'findProductId']);
Route::post('/addCart', [TransactionController::class, 'addCart']);
Route::get('/save/{totalHarga}', [TransactionController::class, 'save']);
// Route::get('/detail/{id}', [TransactionController::class, 'detail']);
Route::get('/transaction', [TransactionController::class, 'store']);
Route::post('/update-to-cart',[TransactionController::class, 'updatetocart']);

Route::get('/detail_transaction/{id}', [TransactionController::class, 'detail_transaction']);
Route::get('/detailBarang/{id}', [TransactionController::class, 'detailBarang']);
Route::get('/history', [TransactionController::class, 'index'])->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);