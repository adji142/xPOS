<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrupPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RolesController;
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

Route::get('/', [LoginController::class,'login'])->name('login');
Route::post('/action-login', [LoginController::class, 'action_login'])->name('action-login');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Grup Pelanggan
|--------------------------------------------------------------------------
|
*/
Route::get('/gruppelanggan', [GrupPelangganController::class,'View'])->name('gruppelanggan')->middleware('auth');
Route::get('/gruppelanggan/form/{id}', [GrupPelangganController::class,'Form'])->name('gruppelanggan-form')->middleware('auth');
Route::post('/gruppelanggan/store', [GrupPelangganController::class, 'store'])->name('gruppelanggan-store')->middleware('auth');
Route::post('/gruppelanggan/edit', [GrupPelangganController::class, 'edit'])->name('gruppelanggan-edit')->middleware('auth');
Route::delete('/gruppelanggan/delete/{id}', [GrupPelangganController::class, 'deletedata'])->name('gruppelanggan-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Pelanggan
|--------------------------------------------------------------------------
|
*/
Route::get('/pelanggan', [PelangganController::class,'View'])->name('pelanggan')->middleware('auth');
Route::get('/pelanggan/form/{id}', [PelangganController::class,'Form'])->name('pelanggan-form')->middleware('auth');
Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan-store')->middleware('auth');
Route::post('/pelanggan/edit', [PelangganController::class, 'edit'])->name('pelanggan-edit')->middleware('auth');
Route::delete('/pelanggan/delete/{id}', [PelangganController::class, 'deletedata'])->name('pelanggan-delete')->middleware('auth');
Route::post('/pelanggan/demografi', [PelangganController::class, 'ReadDemografi'])->name('demografipelanggan')->middleware('auth');
Route::get('/pelanggan/export', [PelangganController::class,'Export'])->name('pelanggan-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Supplier
|--------------------------------------------------------------------------
|
*/
Route::get('/supplier', [SupplierController::class,'View'])->name('supplier')->middleware('auth');
Route::get('/supplier/form/{id}', [SupplierController::class,'Form'])->name('supplier-form')->middleware('auth');
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier-store')->middleware('auth');
Route::post('/supplier/edit', [SupplierController::class, 'edit'])->name('supplier-edit')->middleware('auth');
Route::delete('/supplier/delete/{id}', [SupplierController::class, 'deletedata'])->name('supplier-delete')->middleware('auth');
Route::get('/supplier/export', [SupplierController::class,'Export'])->name('supplier-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Supplier
|--------------------------------------------------------------------------
|
*/
Route::get('/sales', [SalesController::class,'View'])->name('sales')->middleware('auth');
Route::get('/sales/form/{id}', [SalesController::class,'Form'])->name('sales-form')->middleware('auth');
Route::post('/sales/store', [SalesController::class, 'store'])->name('sales-store')->middleware('auth');
Route::post('/sales/edit', [SalesController::class, 'edit'])->name('sales-edit')->middleware('auth');
Route::delete('/sales/delete/{id}', [SalesController::class, 'deletedata'])->name('sales-delete')->middleware('auth');
Route::get('/sales/export', [SalesController::class,'Export'])->name('sales-export')->middleware('auth');


/*
|--------------------------------------------------------------------------
| KelompokAkses
|--------------------------------------------------------------------------
|
*/
Route::get('/roles', [RolesController::class,'View'])->name('roles')->middleware('auth');
Route::get('/roles/form/{id}', [RolesController::class,'Form'])->name('roles-form')->middleware('auth');
Route::post('/roles/store', [RolesController::class, 'store'])->name('roles-store')->middleware('auth');
Route::post('/roles/edit', [RolesController::class, 'edit'])->name('roles-edit')->middleware('auth');
Route::delete('/roles/delete/{id}', [RolesController::class, 'deletedata'])->name('roles-delete')->middleware('auth');
Route::get('/roles/export', [RolesController::class,'Export'])->name('roles-export')->middleware('auth');