<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrupPelangganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisItemController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\KelompokRekeningController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\SettingAccountController;
use App\Http\Controllers\ItemMasterController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\TerminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HargaJualController;
use App\Http\Controllers\OrderPembelianController;
use App\Http\Controllers\DocumentNumberingController;
use App\Http\Controllers\FakturPembelianController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReturPembelianController;
use App\Http\Controllers\PengakuanBarangController;
use App\Http\Controllers\PenghapusanBarangController;
use App\Http\Controllers\PenerimaanKonsinyasiController;
use App\Http\Controllers\ReturKonsinyasiController;
use App\Http\Controllers\OrderPenjualanController;
use App\Http\Controllers\FakturPenjualanController;
use App\Http\Controllers\PoSController;
use App\Http\Controllers\BluetoothController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ReturPenjualanController;
use App\Http\Controllers\DeliveryNoteController;

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
Route::post('/pelanggan/viewJson', [PelangganController::class, 'ReadPelangganJson'])->name('pelanggan-viewJson')->middleware('auth');
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

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
|
*/
Route::get('/user', [UserController::class,'View'])->name('user')->middleware('auth');
Route::get('/user/form/{id}', [UserController::class,'Form'])->name('user-form')->middleware('auth');
Route::post('/user/store', [UserController::class, 'store'])->name('user-store')->middleware('auth');
Route::post('/user/edit', [UserController::class, 'edit'])->name('user-edit')->middleware('auth');
Route::delete('/user/delete/{id}', [UserController::class, 'deletedata'])->name('user-delete')->middleware('auth');
Route::get('/user/export', [UserController::class,'Export'])->name('user-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Jenis Item
|--------------------------------------------------------------------------
|
*/
Route::get('/jenisitem', [JenisItemController::class,'View'])->name('jenisitem')->middleware('auth');
Route::get('/jenisitem/form/{id}', [JenisItemController::class,'Form'])->name('jenisitem-form')->middleware('auth');
Route::post('/jenisitem/store', [JenisItemController::class, 'store'])->name('jenisitem-store')->middleware('auth');
Route::post('/jenisitem/edit', [JenisItemController::class, 'edit'])->name('jenisitem-edit')->middleware('auth');

// json
Route::post('/jenisitem/read', [JenisItemController::class, 'ViewJson'])->name('jenisitem-ViewJson')->middleware('auth');
Route::post('/jenisitem/storeJson', [JenisItemController::class, 'storeJson'])->name('jenisitem-storeJson')->middleware('auth');
Route::post('/jenisitem/editJson', [JenisItemController::class, 'editJson'])->name('jenisitem-editJson')->middleware('auth');
// json

Route::delete('/jenisitem/delete/{id}', [JenisItemController::class, 'deletedata'])->name('jenisitem-delete')->middleware('auth');
Route::get('/jenisitem/export', [JenisItemController::class,'Export'])->name('jenisitem-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Merk
|--------------------------------------------------------------------------
|
*/
Route::get('/merk', [MerkController::class,'View'])->name('merk')->middleware('auth');
Route::get('/merk/form/{id}', [MerkController::class,'Form'])->name('merk-form')->middleware('auth');
Route::post('/merk/store', [MerkController::class, 'store'])->name('merk-store')->middleware('auth');
Route::post('/merk/edit', [MerkController::class, 'edit'])->name('merk-edit')->middleware('auth');

// json
Route::post('/merk/read', [MerkController::class, 'ViewJson'])->name('merk-ViewJson')->middleware('auth');
Route::post('/merk/storeJson', [MerkController::class, 'storeJson'])->name('merk-storeJson')->middleware('auth');
Route::post('/merk/editJson', [MerkController::class, 'editJson'])->name('merk-editJson')->middleware('auth');
// json

Route::delete('/merk/delete/{id}', [MerkController::class, 'deletedata'])->name('merk-delete')->middleware('auth');
Route::get('/merk/export', [MerkController::class,'Export'])->name('merk-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Gudang
|--------------------------------------------------------------------------
|
*/
Route::get('/gudang', [GudangController::class,'View'])->name('gudang')->middleware('auth');
Route::get('/gudang/form/{id}', [GudangController::class,'Form'])->name('gudang-form')->middleware('auth');
Route::post('/gudang/store', [GudangController::class, 'store'])->name('gudang-store')->middleware('auth');
Route::post('/gudang/edit', [GudangController::class, 'edit'])->name('gudang-edit')->middleware('auth');

// json
Route::post('/gudang/read', [GudangController::class, 'ViewJson'])->name('gudang-ViewJson')->middleware('auth');
Route::post('/gudang/storeJson', [GudangController::class, 'storeJson'])->name('gudang-storeJson')->middleware('auth');
Route::post('/gudang/editJson', [GudangController::class, 'editJson'])->name('gudang-editJson')->middleware('auth');
// endjson

Route::delete('/gudang/delete/{id}', [GudangController::class, 'deletedata'])->name('gudang-delete')->middleware('auth');
Route::get('/gudang/export', [GudangController::class,'Export'])->name('gudang-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Satuan
|--------------------------------------------------------------------------
|
*/
Route::get('/satuan', [SatuanController::class,'View'])->name('satuan')->middleware('auth');
Route::get('/satuan/form/{id}', [SatuanController::class,'Form'])->name('satuan-form')->middleware('auth');
Route::post('/satuan/store', [SatuanController::class, 'store'])->name('satuan-store')->middleware('auth');
Route::post('/satuan/edit', [SatuanController::class, 'edit'])->name('satuan-edit')->middleware('auth');

// json
Route::post('/satuan/read', [SatuanController::class, 'ViewJson'])->name('satuan-ViewJson')->middleware('auth');
Route::post('/satuan/storeJson', [SatuanController::class, 'storeJson'])->name('satuan-storeJson')->middleware('auth');
Route::post('/satuan/editJson', [SatuanController::class, 'editJson'])->name('satuan-editJson')->middleware('auth');
// end json
Route::delete('/satuan/delete/{id}', [SatuanController::class, 'deletedata'])->name('satuan-delete')->middleware('auth');
Route::get('/satuan/export', [SatuanController::class,'Export'])->name('satuan-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Kellompok Rekening
|--------------------------------------------------------------------------
|
*/
Route::get('/kelompokrekening', [KelompokRekeningController::class,'View'])->name('kelompokrekening')->middleware('auth');
Route::get('/kelompokrekening/form/{id}', [KelompokRekeningController::class,'Form'])->name('kelompokrekening-form')->middleware('auth');
Route::post('/kelompokrekening/store', [KelompokRekeningController::class, 'store'])->name('kelompokrekening-store')->middleware('auth');
Route::post('/kelompokrekening/edit', [KelompokRekeningController::class, 'edit'])->name('kelompokrekening-edit')->middleware('auth');
Route::delete('/kelompokrekening/delete/{id}', [KelompokRekeningController::class, 'deletedata'])->name('kelompokrekening-delete')->middleware('auth');
Route::get('/kelompokrekening/export', [KelompokRekeningController::class,'Export'])->name('kelompokrekening-export')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Rekening
|--------------------------------------------------------------------------
|
*/
Route::get('/rekening', [RekeningController::class,'View'])->name('rekening')->middleware('auth');
Route::get('/rekening/form/{id}', [RekeningController::class,'Form'])->name('rekening-form')->middleware('auth');
Route::post('/rekening/store', [RekeningController::class, 'store'])->name('rekening-store')->middleware('auth');
Route::post('/rekening/edit', [RekeningController::class, 'edit'])->name('rekening-edit')->middleware('auth');
Route::delete('/rekening/delete/{id}', [RekeningController::class, 'deletedata'])->name('rekening-delete')->middleware('auth');
Route::get('/rekening/export', [RekeningController::class,'Export'])->name('rekening-export')->middleware('auth');
Route::post('/rekening/getjson', [RekeningController::class, 'ViewJson'])->name('rekening-json')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Item Master Data
|--------------------------------------------------------------------------
|
*/
Route::get('/itemmaster', [ItemMasterController::class,'View'])->name('itemmaster')->middleware('auth');
Route::post('/itemmaster/read', [ItemMasterController::class, 'ViewJson'])->name('itemmaster-ViewJson')->middleware('auth');
Route::post('/itemmaster/find', [ItemMasterController::class, 'Find'])->name('itemmaster-find')->middleware('auth');
Route::get('/itemmaster/form/{id}', [ItemMasterController::class,'Form'])->name('itemmaster-form')->middleware('auth');
Route::post('/itemmaster/edit', [ItemMasterController::class, 'edit'])->name('itemmaster-edit')->middleware('auth');
Route::post('/itemmaster/store', [ItemMasterController::class, 'store'])->name('itemmaster-store')->middleware('auth');
Route::post('/itemmaster/edit', [ItemMasterController::class, 'edit'])->name('itemmaster-edit')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Setting
|--------------------------------------------------------------------------
|
*/
Route::get('/acctsetting', [SettingAccountController::class,'View'])->name('acctsetting')->middleware('auth');
Route::post('/acctsetting/edit', [SettingAccountController::class, 'edit'])->name('acctsetting-edit')->middleware('auth');

Route::get('/companysetting', [CompanyController::class,'View'])->name('companysetting')->middleware('auth');
Route::get('/companysetting/testprint', [CompanyController::class,'TestPrint'])->name('companysetting-testprint')->middleware('auth');
Route::post('/companysetting/edit', [CompanyController::class, 'edit'])->name('companysetting-edit')->middleware('auth');

// DocumentNumbering
Route::get('/docnum', [DocumentNumberingController::class,'View'])->name('docnum')->middleware('auth');
Route::post('/docnum/read', [DocumentNumberingController::class, 'ViewJson'])->name('docnum-ViewJson')->middleware('auth');
Route::post('/docnum/store', [DocumentNumberingController::class, 'storeJson'])->name('docnum-store')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Bank
|--------------------------------------------------------------------------
|
*/
Route::get('/bank', [BankController::class,'View'])->name('bank')->middleware('auth');
Route::get('/bank/form/{id}', [BankController::class,'Form'])->name('bank-form')->middleware('auth');
Route::post('/bank/store', [BankController::class, 'store'])->name('bank-store')->middleware('auth');
Route::post('/bank/edit', [BankController::class, 'edit'])->name('bank-edit')->middleware('auth');
Route::delete('/bank/delete/{id}', [BankController::class, 'deletedata'])->name('bank-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Metode Pembayaran
|--------------------------------------------------------------------------
|
*/
Route::get('/metodepembayaran', [MetodePembayaranController::class,'View'])->name('metodepembayaran')->middleware('auth');
Route::get('/metodepembayaran/form/{id}', [MetodePembayaranController::class,'Form'])->name('metodepembayaran-form')->middleware('auth');
Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store'])->name('metodepembayaran-store')->middleware('auth');
Route::post('/metodepembayaran/edit', [MetodePembayaranController::class, 'edit'])->name('metodepembayaran-edit')->middleware('auth');
Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'deletedata'])->name('metodepembayaran-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Termin
|--------------------------------------------------------------------------
|
*/
Route::get('/termin', [TerminController::class,'View'])->name('termin')->middleware('auth');
Route::get('/termin/form/{id}', [TerminController::class,'Form'])->name('termin-form')->middleware('auth');
Route::post('/termin/store', [TerminController::class, 'store'])->name('termin-store')->middleware('auth');
Route::post('/termin/edit', [TerminController::class, 'edit'])->name('termin-edit')->middleware('auth');
Route::delete('/termin/delete/{id}', [TerminController::class, 'deletedata'])->name('termin-delete')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Shift
|--------------------------------------------------------------------------
|
*/
Route::get('/shift', [ShiftController::class,'View'])->name('shift')->middleware('auth');
Route::get('/shift/form/{id}', [ShiftController::class,'Form'])->name('shift-form')->middleware('auth');
Route::post('/shift/store', [ShiftController::class, 'store'])->name('shift-store')->middleware('auth');
Route::post('/shift/edit', [ShiftController::class, 'edit'])->name('shift-edit')->middleware('auth');
Route::delete('/shift/delete/{id}', [ShiftController::class, 'deletedata'])->name('shift-delete')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Harga Jual
|--------------------------------------------------------------------------
|
*/
Route::get('/hargajual', [HargaJualController::class,'View'])->name('hargajual')->middleware('auth');
Route::post('/hargajual/store', [HargaJualController::class, 'store'])->name('hargajual-store')->middleware('auth');


/*
|--------------------------------------------------------------------------
| OrderPembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/opembelian', [OrderPembelianController::class,'View'])->name('opembelian')->middleware('auth');
Route::get('/opembelian/form/{id}', [OrderPembelianController::class,'Form'])->name('opembelian-form')->middleware('auth');
Route::post('/opembelian/storeJson', [OrderPembelianController::class, 'storeJson'])->name('opembelian-storeJson')->middleware('auth');
Route::post('/opembelian/editJson', [OrderPembelianController::class, 'editJson'])->name('opembelian-editJson')->middleware('auth');
Route::post('/opembelian/readheader', [OrderPembelianController::class, 'ViewHeader'])->name('opembelian-readheader')->middleware('auth');
Route::post('/opembelian/readdetail', [OrderPembelianController::class, 'ViewDetail'])->name('opembelian-readdetail')->middleware('auth');
Route::post('/opembelian/findheader', [OrderPembelianController::class, 'FindHeader'])->name('opembelian-findheader')->middleware('auth');


/*
|--------------------------------------------------------------------------
| FakturPembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/fpembelian', [FakturPembelianController::class,'View'])->name('fpembelian')->middleware('auth');
Route::get('/fpembelian/form/{id}', [FakturPembelianController::class,'Form'])->name('fpembelian-form')->middleware('auth');
Route::post('/fpembelian/storeJson', [FakturPembelianController::class, 'storeJson'])->name('fpembelian-storeJson')->middleware('auth');
Route::post('/fpembelian/editJson', [FakturPembelianController::class, 'editJson'])->name('fpembelian-editJson')->middleware('auth');
Route::post('/fpembelian/readheader', [FakturPembelianController::class, 'ViewHeader'])->name('fpembelian-readheader')->middleware('auth');
Route::post('/fpembelian/readdetail', [FakturPembelianController::class, 'ViewDetail'])->name('fpembelian-readdetail')->middleware('auth');
Route::post('/fpembelian/findheader', [FakturPembelianController::class, 'FindHeader'])->name('fpembelian-findheader')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Pembayaran Pembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/pembayaranpembelian', [PembayaranController::class,'View'])->name('pembayaranpembelian')->middleware('auth');
Route::get('/pembayaranpembelian/form/{id}', [PembayaranController::class,'Form'])->name('pembayaranpembelian-form')->middleware('auth');
Route::post('/pembayaranpembelian/storeJson', [PembayaranController::class, 'storeJson'])->name('pembayaranpembelian-storeJson')->middleware('auth');
Route::post('/pembayaranpembelian/editJson', [PembayaranController::class, 'editJson'])->name('pembayaranpembelian-editJson')->middleware('auth');
Route::post('/pembayaranpembelian/readheader', [PembayaranController::class, 'ViewHeader'])->name('pembayaranpembelian-readheader')->middleware('auth');
Route::post('/pembayaranpembelian/readdetail', [PembayaranController::class, 'ViewDetail'])->name('pembayaranpembelian-readdetail')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Retur Pembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/returpembelian', [ReturPembelianController::class,'View'])->name('returpembelian')->middleware('auth');
Route::get('/returpembelian/form/{id}', [ReturPembelianController::class,'Form'])->name('returpembelian-form')->middleware('auth');
Route::post('/returpembelian/storeJson', [ReturPembelianController::class, 'storeJson'])->name('returpembelian-storeJson')->middleware('auth');
Route::post('/returpembelian/editJson', [ReturPembelianController::class, 'editJson'])->name('returpembelian-editJson')->middleware('auth');
Route::post('/returpembelian/readheader', [ReturPembelianController::class, 'ViewHeader'])->name('returpembelian-readheader')->middleware('auth');
Route::post('/returpembelian/readdetail', [ReturPembelianController::class, 'ViewDetail'])->name('returpembelian-readdetail')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Pengakuan Barang
|--------------------------------------------------------------------------
|
*/
Route::get('/gr', [PengakuanBarangController::class,'View'])->name('gr')->middleware('auth');
Route::get('/gr/form/{id}', [PengakuanBarangController::class,'Form'])->name('gr-form')->middleware('auth');
Route::post('/gr/storeJson', [PengakuanBarangController::class, 'storeJson'])->name('gr-storeJson')->middleware('auth');
Route::post('/gr/editJson', [PengakuanBarangController::class, 'editJson'])->name('gr-editJson')->middleware('auth');
Route::post('/gr/readheader', [PengakuanBarangController::class, 'ViewHeader'])->name('gr-readheader')->middleware('auth');
Route::post('/gr/readdetail', [PengakuanBarangController::class, 'ViewDetail'])->name('gr-readdetail')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Penghapusan Barang
|--------------------------------------------------------------------------
|
*/
Route::get('/gi', [PenghapusanBarangController::class,'View'])->name('gi')->middleware('auth');
Route::get('/gi/form/{id}', [PenghapusanBarangController::class,'Form'])->name('gi-form')->middleware('auth');
Route::post('/gi/storeJson', [PenghapusanBarangController::class, 'storeJson'])->name('gi-storeJson')->middleware('auth');
Route::post('/gi/editJson', [PenghapusanBarangController::class, 'editJson'])->name('gi-editJson')->middleware('auth');
Route::post('/gi/readheader', [PenghapusanBarangController::class, 'ViewHeader'])->name('gi-readheader')->middleware('auth');
Route::post('/gi/readdetail', [PenghapusanBarangController::class, 'ViewDetail'])->name('gi-readdetail')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Konsinyasi
|--------------------------------------------------------------------------
|
*/
Route::get('/cons', [PenerimaanKonsinyasiController::class,'View'])->name('cons')->middleware('auth');
Route::get('/cons/form/{id}', [PenerimaanKonsinyasiController::class,'Form'])->name('cons-form')->middleware('auth');
Route::post('/cons/storeJson', [PenerimaanKonsinyasiController::class, 'storeJson'])->name('cons-storeJson')->middleware('auth');
Route::post('/cons/editJson', [PenerimaanKonsinyasiController::class, 'editJson'])->name('cons-editJson')->middleware('auth');
Route::post('/cons/readheader', [PenerimaanKonsinyasiController::class, 'ViewHeader'])->name('cons-readheader')->middleware('auth');
Route::post('/cons/readdetail', [PenerimaanKonsinyasiController::class, 'ViewDetail'])->name('cons-readdetail')->middleware('auth');
Route::post('/cons/findheader', [PenerimaanKonsinyasiController::class, 'FindHeader'])->name('cons-findheader')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Konsinyasi
|--------------------------------------------------------------------------
|
*/
Route::get('/retcons', [ReturKonsinyasiController::class,'View'])->name('retcons')->middleware('auth');
Route::get('/retcons/form/{id}', [ReturKonsinyasiController::class,'Form'])->name('retcons-form')->middleware('auth');
Route::post('/retcons/storeJson', [ReturKonsinyasiController::class, 'storeJson'])->name('retcons-storeJson')->middleware('auth');
Route::post('/retcons/editJson', [ReturKonsinyasiController::class, 'editJson'])->name('retcons-editJson')->middleware('auth');
Route::post('/retcons/readheader', [ReturKonsinyasiController::class, 'ViewHeader'])->name('retcons-readheader')->middleware('auth');
Route::post('/retcons/readdetail', [ReturKonsinyasiController::class, 'ViewDetail'])->name('retcons-readdetail')->middleware('auth');
Route::post('/retcons/findheader', [ReturKonsinyasiController::class, 'FindHeader'])->name('retcons-findheader')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Order Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/openjualan', [OrderPenjualanController::class,'View'])->name('openjualan')->middleware('auth');
Route::get('/openjualan/form/{id}', [OrderPenjualanController::class,'Form'])->name('openjualan-form')->middleware('auth');
Route::post('/openjualan/storeJson', [OrderPenjualanController::class, 'storeJson'])->name('openjualan-storeJson')->middleware('auth');
Route::post('/openjualan/editJson', [OrderPenjualanController::class, 'editJson'])->name('openjualan-editJson')->middleware('auth');
Route::post('/openjualan/readheader', [OrderPenjualanController::class, 'ViewHeader'])->name('openjualan-readheader')->middleware('auth');
Route::post('/openjualan/readdetail', [OrderPenjualanController::class, 'ViewDetail'])->name('openjualan-readdetail')->middleware('auth');
Route::post('/openjualan/findheader', [OrderPenjualanController::class, 'FindHeader'])->name('openjualan-findheader')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Faktur Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/fpenjualan', [FakturPenjualanController::class,'View'])->name('fpenjualan')->middleware('auth');
Route::get('/fpenjualan/form/{id}', [FakturPenjualanController::class,'Form'])->name('fpenjualan-form')->middleware('auth');
Route::post('/fpenjualan/storeJson', [FakturPenjualanController::class, 'storeJson'])->name('fpenjualan-storeJson')->middleware('auth');
Route::post('/fpenjualan/editJson', [FakturPenjualanController::class, 'editJson'])->name('fpenjualan-editJson')->middleware('auth');
Route::post('/fpenjualan/readheader', [FakturPenjualanController::class, 'ViewHeader'])->name('fpenjualan-readheader')->middleware('auth');
Route::post('/fpenjualan/readdetail', [FakturPenjualanController::class, 'ViewDetail'])->name('fpenjualan-readdetail')->middleware('auth');
Route::post('/fpenjualan/findheader', [FakturPenjualanController::class, 'FindHeader'])->name('fpenjualan-findheader')->middleware('auth');
Route::get('/fpenjualan/pos', [PoSController::class, 'View'])->name('fpenjualan-pos')->middleware('auth');
Route::post('/fpenjualan/getDiskon', [PoSController::class, 'GetDiscount'])->name('fpenjualan-getDiskon')->middleware('auth');
Route::post('/fpenjualan/retailPos', [FakturPenjualanController::class, 'storePoS'])->name('fpenjualan-retailPos')->middleware('auth');
Route::post('/fpenjualan/editStatus', [FakturPenjualanController::class, 'EditTransactionStatus'])->name('fpenjualan-editStatus')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Retur Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/returpenjualan', [ReturPenjualanController::class,'View'])->name('returpenjualan')->middleware('auth');
Route::get('/returpenjualan/form/{id}', [ReturPenjualanController::class,'Form'])->name('returpenjualan-form')->middleware('auth');
Route::post('/returpenjualan/storeJson', [ReturPenjualanController::class, 'storeJson'])->name('returpenjualan-storeJson')->middleware('auth');
Route::post('/returpenjualan/editJson', [ReturPenjualanController::class, 'editJson'])->name('returpenjualan-editJson')->middleware('auth');
Route::post('/returpenjualan/readheader', [ReturPenjualanController::class, 'ViewHeader'])->name('returpenjualan-readheader')->middleware('auth');
Route::post('/returpenjualan/readdetail', [ReturPenjualanController::class, 'ViewDetail'])->name('returpenjualan-readdetail')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Printing Section
|--------------------------------------------------------------------------
|
*/

Route::get('/bluetooth/scan', [BluetoothController::class, 'scan'])->name('bluetooth-scan')->middleware('auth');
Route::get('/bluetooth/connect/{id}', [BluetoothController::class, 'connect'])->name('bluetooth-connect')->middleware('auth');
Route::post('/print/test', [PrinterController::class, 'PrintRecieptTest'])->name('print-test')->middleware('auth');
Route::post('/print/retail', [PrinterController::class, 'PrintRecieptRetail'])->name('print-retail')->middleware('auth');


/*
|--------------------------------------------------------------------------
| Delivery Note
|--------------------------------------------------------------------------
|
*/
Route::get('/delivery', [DeliveryNoteController::class,'View'])->name('delivery')->middleware('auth');
Route::get('/delivery/form/{id}', [DeliveryNoteController::class,'Form'])->name('delivery-form')->middleware('auth');
Route::post('/delivery/storeJson', [DeliveryNoteController::class, 'storeJson'])->name('delivery-storeJson')->middleware('auth');
Route::post('/delivery/editJson', [DeliveryNoteController::class, 'editJson'])->name('delivery-editJson')->middleware('auth');
Route::post('/delivery/readheader', [DeliveryNoteController::class, 'ViewHeader'])->name('delivery-readheader')->middleware('auth');
Route::post('/delivery/readdetail', [DeliveryNoteController::class, 'ViewDetail'])->name('delivery-readdetail')->middleware('auth');