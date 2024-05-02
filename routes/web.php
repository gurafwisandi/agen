<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\bulanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HariController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KodeposController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaketBelajarController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PosBayarController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DetailPembelianController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SatuanController;
use App\Models\DetailPembelianModels;
use App\Models\DetailPenjualanModels;

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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::group(
    [
        'prefix'     => 'login'
    ],
    function () {
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.proses');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
        Route::get('/register', [LoginController::class, 'register'])->name('login.register');
        Route::post('/post', [LoginController::class, 'store'])->name('login.store');
    }
);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::group(
    [
        'prefix'     => 'user'
    ],
    function () {
        Route::get('/', [UserController::class, 'index'])->name('user.list');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update', [UserController::class, 'update'])->name('user.update');
        Route::delete('/destroy', [UserController::class, 'destroy'])->name('user.destroy');
    }
);

Route::group(
    [
        'middleware' => 'auth'
    ],
    function () {
        Route::resource('/cabang', CabangController::class);
        Route::resource('/satuan', SatuanController::class);
        Route::resource('/customer', CustomerController::class);
        Route::resource('/item', ItemController::class);
        Route::post('/store_price', [ItemController::class, 'store_price'])->name('item.store_price');
        Route::delete('/destroy_price/{id}', [ItemController::class, 'destroy_price'])->name('item.destroy_price');
        Route::post('/dropdown_price', [ItemController::class, 'dropdown_price'])->name('item.dropdown_price');

        Route::resource('/pembelian', PembelianController::class);
        Route::post('/store_edit', [PembelianController::class, 'store_edit'])->name('pembelian.store_edit');
        Route::resource('/detail_pembelian', DetailPembelianController::class);

        Route::resource('/penjualan', PenjualanController::class);
        Route::post('/store_edit', [PenjualanController::class, 'store_edit'])->name('penjualan.store_edit');
        Route::resource('/detail_penjualan', DetailPenjualanController::class);
        Route::get('print/{id}', [PenjualanController::class, 'print'])->name('penjualan.print');
        Route::get('pos/{id}', [PenjualanController::class, 'pos'])->name('penjualan.pos');
    }
);
