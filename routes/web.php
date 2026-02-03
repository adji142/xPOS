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
use App\Http\Controllers\PembayaranPenjualanController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\DiskonPeriodikController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\PembayaranKonsinyasiController;
use App\Http\Controllers\KelompokMejaController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\InvoicePenggunaController;
use App\Http\Controllers\VariantMenuController;
use App\Http\Controllers\MenuAddonController;
use App\Http\Controllers\TipeOrderRestoController;
use App\Http\Controllers\MenuRestoAddonController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TnCController;
use App\Http\Controllers\KasKeluarController;
use App\Http\Controllers\KasMasukController;
use App\Http\Controllers\CustDisplayController;
use App\Http\Controllers\MasterControllerController;
use App\Http\Controllers\TitikLampuController;
use App\Http\Controllers\EnvController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TableOrderController;
use App\Http\Controllers\BookingOnlineController;
use App\Http\Controllers\DocumentOutputController;
use App\Http\Controllers\KelompokLampuController;
use App\Http\Controllers\QueueManagementController;
use App\Http\Controllers\DiscountVoucherController;
use App\Http\Controllers\SupportPageController;
use App\Http\Controllers\LogingController;
use App\Http\Controllers\SerialNumberController;
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
Route::get('/daftar', [LoginController::class,'Register'])->name('daftar');
Route::post('/action-login', [LoginController::class, 'action_login'])->name('action-login');
Route::post('/action-daftar', [LoginController::class, 'actionRegister'])->name('action-daftar');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'check.session']);
Route::get('/dashboardadmin', [DashboardController::class, 'dashboardAdmin'])->name('dashboardadmin')->middleware(['auth', 'check.session']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['auth', 'check.session']);
Route::get('/konfirmasi/{id}', [LoginController::class, 'Konfirmasi'])->name('konfirmasi');
Route::post('/konfirmasi', [LoginController::class, 'KonfirmasiStore'])->name('konfirmasi-store');
Route::get('/dashboard/filter', [DashboardController::class, 'filterOmzet'])->name('dashboard.filter');


Route::get('/forgotpassword', [LoginController::class, 'forgotpassword'])->name('forgotpassword');
Route::get('/resetpassword/{id}', [LoginController::class, 'resetpassword'])->name('resetpassword');
Route::post('/SendEmailResetPassword', [LoginController::class, 'SendEmailResetPassword'])->name('SendEmailResetPassword');
Route::post('/actionResetPassword', [LoginController::class, 'actionResetPassword'])->name('actionResetPassword');

Route::get('/emenu/{id}/{roid}', [TitikLampuController::class, 'emenu'])->name('emenu.order');
Route::post('/emenu/store', [TitikLampuController::class, 'storeOrder'])->name('emenu.store');
Route::post('/emenu/create-payment', [TitikLampuController::class, 'createPaymentEMenu'])->name('emenu.create-payment');
Route::post('/emenu/store-qris', [TitikLampuController::class, 'storeOrderEMenuQRIS'])->name('emenu.store-qris');
Route::get('titiklampu/generate-qrcode', [TitikLampuController::class, 'generateQRCode'])->name('titiklampu-generate-qrcode');
Route::get('titiklampu/download-qr-zip', [TitikLampuController::class, 'downloadZipQR'])->name('titiklampu-download-qr-zip')->middleware(['auth', 'check.session']);
/*
|--------------------------------------------------------------------------
| Grup Pelanggan
|--------------------------------------------------------------------------
|
*/
/*
|--------------------------------------------------------------------------
| Grup Pelanggan
|--------------------------------------------------------------------------
|
*/
Route::get('/gruppelanggan', [GrupPelangganController::class,'View'])->name('gruppelanggan')->middleware(['auth', 'check.session']);
Route::get('/gruppelanggan/form/{id}', [GrupPelangganController::class,'Form'])->name('gruppelanggan-form')->middleware(['auth', 'check.session']);
Route::post('/gruppelanggan/store', [GrupPelangganController::class, 'store'])->name('gruppelanggan-store')->middleware(['auth', 'check.session']);
Route::post('/gruppelanggan/edit', [GrupPelangganController::class, 'edit'])->name('gruppelanggan-edit')->middleware(['auth', 'check.session']);
Route::delete('/gruppelanggan/delete/{id}', [GrupPelangganController::class, 'deletedata'])->name('gruppelanggan-delete')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Serial Number
|--------------------------------------------------------------------------
|
*/
Route::get('/serialnumber', [SerialNumberController::class, 'View'])->name('serialnumber')->middleware(['auth', 'check.session']);
Route::get('/serialnumber/form/{id}', [SerialNumberController::class, 'Form'])->name('serialnumber-form')->middleware(['auth', 'check.session']);
Route::post('/serialnumber/store', [SerialNumberController::class, 'store'])->name('serialnumber-store')->middleware(['auth', 'check.session']);
Route::post('/serialnumber/edit', [SerialNumberController::class, 'edit'])->name('serialnumber-edit')->middleware(['auth', 'check.session']);
Route::delete('/serialnumber/delete/{id}', [SerialNumberController::class, 'deletedata'])->name('serialnumber-delete')->middleware(['auth', 'check.session']);
Route::post('/serialnumber/generate', [SerialNumberController::class, 'generateJson'])->name('serialnumber-generate')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Pelanggan
|--------------------------------------------------------------------------
|
*/
Route::get('/pelanggan', [PelangganController::class,'View'])->name('pelanggan')->middleware(['auth', 'check.session']);
Route::get('/pelanggan/form/{id}', [PelangganController::class,'Form'])->name('pelanggan-form')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan-store')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/storejson', [PelangganController::class, 'storeJson'])->name('pelanggan-storeJson')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/edit', [PelangganController::class, 'edit'])->name('pelanggan-edit')->middleware(['auth', 'check.session']);
Route::delete('/pelanggan/delete/{id}', [PelangganController::class, 'deletedata'])->name('pelanggan-delete')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/demografi', [PelangganController::class, 'ReadDemografi'])->name('demografipelanggan');
Route::get('/pelanggan/export', [PelangganController::class,'Export'])->name('pelanggan-export')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/viewJson', [PelangganController::class, 'ReadPelangganJson'])->name('pelanggan-viewJson');
Route::post('/pelanggan/activate', [PelangganController::class, 'activateMember'])->name('pelanggan-activate')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/extend', [PelangganController::class, 'extendMember'])->name('pelanggan-extend')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/payment-gateway', [PelangganController::class, 'paymentGateway'])->name('pelanggan-payment-gateway')->middleware(['auth', 'check.session']);
Route::post('/pelanggan/payment-callback', [PelangganController::class, 'paymentCallback'])->name('pelanggan-payment-callback')->middleware(['auth', 'check.session']);
/*
|--------------------------------------------------------------------------
| Supplier
|--------------------------------------------------------------------------
|
*/
Route::get('/supplier', [SupplierController::class,'View'])->name('supplier')->middleware(['auth', 'check.session']);
Route::get('/supplier/form/{id}', [SupplierController::class,'Form'])->name('supplier-form')->middleware(['auth', 'check.session']);
Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier-store')->middleware(['auth', 'check.session']);
Route::post('/supplier/edit', [SupplierController::class, 'edit'])->name('supplier-edit')->middleware(['auth', 'check.session']);
Route::delete('/supplier/delete/{id}', [SupplierController::class, 'deletedata'])->name('supplier-delete')->middleware(['auth', 'check.session']);
Route::get('/supplier/export', [SupplierController::class,'Export'])->name('supplier-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Supplier
|--------------------------------------------------------------------------
|
*/
Route::get('/sales', [SalesController::class,'View'])->name('sales')->middleware(['auth', 'check.session']);
Route::get('/sales/form/{id}', [SalesController::class,'Form'])->name('sales-form')->middleware(['auth', 'check.session']);
Route::post('/sales/store', [SalesController::class, 'store'])->name('sales-store')->middleware(['auth', 'check.session']);
Route::post('/sales/edit', [SalesController::class, 'edit'])->name('sales-edit')->middleware(['auth', 'check.session']);
Route::delete('/sales/delete/{id}', [SalesController::class, 'deletedata'])->name('sales-delete')->middleware(['auth', 'check.session']);
Route::get('/sales/export', [SalesController::class,'Export'])->name('sales-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| KelompokAkses
|--------------------------------------------------------------------------
|
*/
Route::get('/roles', [RolesController::class,'View'])->name('roles')->middleware(['auth', 'check.session']);
Route::get('/roles/form/{id}', [RolesController::class,'Form'])->name('roles-form')->middleware(['auth', 'check.session']);
Route::post('/roles/store', [RolesController::class, 'store'])->name('roles-store')->middleware(['auth', 'check.session']);
Route::post('/roles/edit', [RolesController::class, 'edit'])->name('roles-edit')->middleware(['auth', 'check.session']);
Route::delete('/roles/delete/{id}', [RolesController::class, 'deletedata'])->name('roles-delete')->middleware(['auth', 'check.session']);
Route::get('/roles/export', [RolesController::class,'Export'])->name('roles-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
|
*/
Route::get('/user', [UserController::class,'View'])->name('user')->middleware(['auth', 'check.session']);
Route::get('/user/form/{id}', [UserController::class,'Form'])->name('user-form')->middleware(['auth', 'check.session']);
Route::post('/user/store', [UserController::class, 'store'])->name('user-store')->middleware(['auth', 'check.session']);
Route::post('/user/edit', [UserController::class, 'edit'])->name('user-edit')->middleware(['auth', 'check.session']);
// Route::delete('/user/delete/{id}', [UserController::class, 'deletedata'])->name('user-delete')->middleware(['auth', 'check.session']);
Route::delete('/user/logout/{id}', [UserController::class, 'LogOutUser'])->name('user-logout')->middleware(['auth', 'check.session']);
Route::get('/user/export', [UserController::class,'Export'])->name('user-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Jenis Item
|--------------------------------------------------------------------------
|
*/
Route::get('/jenisitem', [JenisItemController::class,'View'])->name('jenisitem')->middleware(['auth', 'check.session']);
Route::get('/jenisitem/form/{id}', [JenisItemController::class,'Form'])->name('jenisitem-form')->middleware(['auth', 'check.session']);
Route::post('/jenisitem/store', [JenisItemController::class, 'store'])->name('jenisitem-store')->middleware(['auth', 'check.session']);
Route::post('/jenisitem/edit', [JenisItemController::class, 'edit'])->name('jenisitem-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/jenisitem/read', [JenisItemController::class, 'ViewJson'])->name('jenisitem-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/jenisitem/storeJson', [JenisItemController::class, 'storeJson'])->name('jenisitem-storeJson')->middleware(['auth', 'check.session']);
Route::post('/jenisitem/editJson', [JenisItemController::class, 'editJson'])->name('jenisitem-editJson')->middleware(['auth', 'check.session']);
// json

Route::delete('/jenisitem/delete/{id}', [JenisItemController::class, 'deletedata'])->name('jenisitem-delete')->middleware(['auth', 'check.session']);
Route::get('/jenisitem/export', [JenisItemController::class,'Export'])->name('jenisitem-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Merk
|--------------------------------------------------------------------------
|
*/
Route::get('/merk', [MerkController::class,'View'])->name('merk')->middleware(['auth', 'check.session']);
Route::get('/merk/form/{id}', [MerkController::class,'Form'])->name('merk-form')->middleware(['auth', 'check.session']);
Route::post('/merk/store', [MerkController::class, 'store'])->name('merk-store')->middleware(['auth', 'check.session']);
Route::post('/merk/edit', [MerkController::class, 'edit'])->name('merk-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/merk/read', [MerkController::class, 'ViewJson'])->name('merk-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/merk/storeJson', [MerkController::class, 'storeJson'])->name('merk-storeJson')->middleware(['auth', 'check.session']);
Route::post('/merk/editJson', [MerkController::class, 'editJson'])->name('merk-editJson')->middleware(['auth', 'check.session']);
// json

Route::delete('/merk/delete/{id}', [MerkController::class, 'deletedata'])->name('merk-delete')->middleware(['auth', 'check.session']);
Route::get('/merk/export', [MerkController::class,'Export'])->name('merk-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Gudang
|--------------------------------------------------------------------------
|
*/
Route::get('/gudang', [GudangController::class,'View'])->name('gudang')->middleware(['auth', 'check.session']);
Route::get('/gudang/form/{id}', [GudangController::class,'Form'])->name('gudang-form')->middleware(['auth', 'check.session']);
Route::post('/gudang/store', [GudangController::class, 'store'])->name('gudang-store')->middleware(['auth', 'check.session']);
Route::post('/gudang/edit', [GudangController::class, 'edit'])->name('gudang-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/gudang/read', [GudangController::class, 'ViewJson'])->name('gudang-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/gudang/storeJson', [GudangController::class, 'storeJson'])->name('gudang-storeJson')->middleware(['auth', 'check.session']);
Route::post('/gudang/editJson', [GudangController::class, 'editJson'])->name('gudang-editJson')->middleware(['auth', 'check.session']);
// endjson

Route::delete('/gudang/delete/{id}', [GudangController::class, 'deletedata'])->name('gudang-delete')->middleware(['auth', 'check.session']);
Route::get('/gudang/export', [GudangController::class,'Export'])->name('gudang-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Satuan
|--------------------------------------------------------------------------
|
*/
Route::get('/satuan', [SatuanController::class,'View'])->name('satuan')->middleware(['auth', 'check.session']);
Route::get('/satuan/form/{id}', [SatuanController::class,'Form'])->name('satuan-form')->middleware(['auth', 'check.session']);
Route::post('/satuan/store', [SatuanController::class, 'store'])->name('satuan-store')->middleware(['auth', 'check.session']);
Route::post('/satuan/edit', [SatuanController::class, 'edit'])->name('satuan-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/satuan/read', [SatuanController::class, 'ViewJson'])->name('satuan-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/satuan/storeJson', [SatuanController::class, 'storeJson'])->name('satuan-storeJson')->middleware(['auth', 'check.session']);
Route::post('/satuan/editJson', [SatuanController::class, 'editJson'])->name('satuan-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/satuan/delete/{id}', [SatuanController::class, 'deletedata'])->name('satuan-delete')->middleware(['auth', 'check.session']);
Route::get('/satuan/export', [SatuanController::class,'Export'])->name('satuan-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Kellompok Rekening
|--------------------------------------------------------------------------
|
*/
Route::get('/kelompokrekening', [KelompokRekeningController::class,'View'])->name('kelompokrekening')->middleware(['auth', 'check.session']);
Route::get('/kelompokrekening/form/{id}', [KelompokRekeningController::class,'Form'])->name('kelompokrekening-form')->middleware(['auth', 'check.session']);
Route::post('/kelompokrekening/store', [KelompokRekeningController::class, 'store'])->name('kelompokrekening-store')->middleware(['auth', 'check.session']);
Route::post('/kelompokrekening/edit', [KelompokRekeningController::class, 'edit'])->name('kelompokrekening-edit')->middleware(['auth', 'check.session']);
Route::delete('/kelompokrekening/delete/{id}', [KelompokRekeningController::class, 'deletedata'])->name('kelompokrekening-delete')->middleware(['auth', 'check.session']);
Route::get('/kelompokrekening/export', [KelompokRekeningController::class,'Export'])->name('kelompokrekening-export')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Rekening
|--------------------------------------------------------------------------
|
*/
Route::get('/rekening', [RekeningController::class,'View'])->name('rekening')->middleware(['auth', 'check.session']);
Route::get('/rekening/form/{id}', [RekeningController::class,'Form'])->name('rekening-form')->middleware(['auth', 'check.session']);
Route::post('/rekening/store', [RekeningController::class, 'store'])->name('rekening-store')->middleware(['auth', 'check.session']);
Route::post('/rekening/edit', [RekeningController::class, 'edit'])->name('rekening-edit')->middleware(['auth', 'check.session']);
Route::delete('/rekening/delete/{id}', [RekeningController::class, 'deletedata'])->name('rekening-delete')->middleware(['auth', 'check.session']);
Route::get('/rekening/export', [RekeningController::class,'Export'])->name('rekening-export')->middleware(['auth', 'check.session']);
Route::post('/rekening/getjson', [RekeningController::class, 'ViewJson'])->name('rekening-json')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Item Master Data
|--------------------------------------------------------------------------
|
*/
Route::get('/itemmaster', [ItemMasterController::class,'View'])->name('itemmaster')->middleware(['auth', 'check.session']);
Route::post('/itemmaster/read', [ItemMasterController::class, 'ViewJson'])->name('itemmaster-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/itemmaster/find', [ItemMasterController::class, 'Find'])->name('itemmaster-find')->middleware(['auth', 'check.session']);
Route::get('/itemmaster/form/{id}', [ItemMasterController::class,'Form'])->name('itemmaster-form')->middleware(['auth', 'check.session']);
Route::post('/itemmaster/edit', [ItemMasterController::class, 'edit'])->name('itemmaster-edit')->middleware(['auth', 'check.session']);
Route::post('/itemmaster/store', [ItemMasterController::class, 'store'])->name('itemmaster-store')->middleware(['auth', 'check.session']);
Route::post('/itemmaster/readstockperwhs', [ItemMasterController::class, 'GetStockPerWhs'])->name('itemmaster-readstockperwhs')->middleware(['auth', 'check.session']);
/*
|--------------------------------------------------------------------------
| Setting
|--------------------------------------------------------------------------
|
*/
Route::get('/acctsetting', [SettingAccountController::class,'View'])->name('acctsetting')->middleware(['auth', 'check.session']);
Route::post('/acctsetting/edit', [SettingAccountController::class, 'edit'])->name('acctsetting-edit')->middleware(['auth', 'check.session']);

Route::get('/companysetting', [CompanyController::class,'View'])->name('companysetting')->middleware(['auth', 'check.session']);
Route::get('/companysetting/testprint', [CompanyController::class,'TestPrint'])->name('companysetting-testprint')->middleware(['auth', 'check.session']);
Route::post('/companysetting/edit', [CompanyController::class, 'edit'])->name('companysetting-edit')->middleware(['auth', 'check.session']);
Route::post('/companysetting/importitem', [CompanyController::class, 'ImportItemMaster'])->name('companysetting-importitem')->middleware(['auth', 'check.session']);
Route::post('/companysetting/importharga', [CompanyController::class, 'ImportHargaJual'])->name('companysetting-importharga')->middleware(['auth', 'check.session']);
Route::post('/companysetting/importpelanggan', [CompanyController::class, 'ImportPelanggan'])->name('companysetting-importpelanggan')->middleware(['auth', 'check.session']);
Route::post('/companysetting/importsupplier', [CompanyController::class, 'ImportSupplier'])->name('companysetting-importsupplier')->middleware(['auth', 'check.session']);
Route::post('/companysetting/updateSlip', [CompanyController::class, 'updateSlip'])->name('companysetting-updateSlip')->middleware(['auth', 'check.session']);
Route::post('/companysetting/getcompanydetail', [CompanyController::class, 'getCompanyDetails'])->name('companysetting-getcompanydetail')->middleware(['auth', 'check.session']);


// DocumentNumbering
Route::get('/docnum', [DocumentNumberingController::class,'View'])->name('docnum')->middleware(['auth', 'check.session']);
Route::post('/docnum/read', [DocumentNumberingController::class, 'ViewJson'])->name('docnum-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/docnum/store', [DocumentNumberingController::class, 'storeJson'])->name('docnum-store')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Bank
|--------------------------------------------------------------------------
|
*/
Route::get('/bank', [BankController::class,'View'])->name('bank')->middleware(['auth', 'check.session']);
Route::get('/bank/form/{id}', [BankController::class,'Form'])->name('bank-form')->middleware(['auth', 'check.session']);
Route::post('/bank/store', [BankController::class, 'store'])->name('bank-store')->middleware(['auth', 'check.session']);
Route::post('/bank/edit', [BankController::class, 'edit'])->name('bank-edit')->middleware(['auth', 'check.session']);
Route::delete('/bank/delete/{id}', [BankController::class, 'deletedata'])->name('bank-delete')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Metode Pembayaran
|--------------------------------------------------------------------------
|
*/
Route::get('/metodepembayaran', [MetodePembayaranController::class,'View'])->name('metodepembayaran')->middleware(['auth', 'check.session']);
Route::get('/metodepembayaran/form/{id}', [MetodePembayaranController::class,'Form'])->name('metodepembayaran-form')->middleware(['auth', 'check.session']);
Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store'])->name('metodepembayaran-store')->middleware(['auth', 'check.session']);
Route::post('/metodepembayaran/edit', [MetodePembayaranController::class, 'edit'])->name('metodepembayaran-edit')->middleware(['auth', 'check.session']);
Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'deletedata'])->name('metodepembayaran-delete')->middleware(['auth', 'check.session']);
Route::post('/metodepembayaran/viewJson', [MetodePembayaranController::class, 'ViewJson'])->name('metodepembayaran-viewJson')->middleware(['auth', 'check.session']);
Route::post('/create-transaction', [PaymentGatewayController::class, 'createTransaction'])->name('create-transaction')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Termin
|--------------------------------------------------------------------------
|
*/
Route::get('/termin', [TerminController::class,'View'])->name('termin')->middleware(['auth', 'check.session']);
Route::get('/termin/form/{id}', [TerminController::class,'Form'])->name('termin-form')->middleware(['auth', 'check.session']);
Route::post('/termin/store', [TerminController::class, 'store'])->name('termin-store')->middleware(['auth', 'check.session']);
Route::post('/termin/edit', [TerminController::class, 'edit'])->name('termin-edit')->middleware(['auth', 'check.session']);
Route::delete('/termin/delete/{id}', [TerminController::class, 'deletedata'])->name('termin-delete')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Shift
|--------------------------------------------------------------------------
|
*/
Route::get('/shift', [ShiftController::class,'View'])->name('shift')->middleware(['auth', 'check.session']);
Route::get('/shift/form/{id}', [ShiftController::class,'Form'])->name('shift-form')->middleware(['auth', 'check.session']);
Route::post('/shift/store', [ShiftController::class, 'store'])->name('shift-store')->middleware(['auth', 'check.session']);
Route::post('/shift/edit', [ShiftController::class, 'edit'])->name('shift-edit')->middleware(['auth', 'check.session']);
Route::delete('/shift/delete/{id}', [ShiftController::class, 'deletedata'])->name('shift-delete')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Harga Jual
|--------------------------------------------------------------------------
|
*/
Route::get('/hargajual', [HargaJualController::class,'View'])->name('hargajual')->middleware(['auth', 'check.session']);
Route::post('/hargajual/store', [HargaJualController::class, 'store'])->name('hargajual-store')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| OrderPembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/opembelian', [OrderPembelianController::class,'View'])->name('opembelian')->middleware(['auth', 'check.session']);
Route::get('/opembelian/form/{id}', [OrderPembelianController::class,'Form'])->name('opembelian-form')->middleware(['auth', 'check.session']);
Route::post('/opembelian/storeJson', [OrderPembelianController::class, 'storeJson'])->name('opembelian-storeJson')->middleware(['auth', 'check.session']);
Route::post('/opembelian/editJson', [OrderPembelianController::class, 'editJson'])->name('opembelian-editJson')->middleware(['auth', 'check.session']);
Route::post('/opembelian/readheader', [OrderPembelianController::class, 'ViewHeader'])->name('opembelian-readheader')->middleware(['auth', 'check.session']);
Route::post('/opembelian/readdetail', [OrderPembelianController::class, 'ViewDetail'])->name('opembelian-readdetail')->middleware(['auth', 'check.session']);
Route::post('/opembelian/findheader', [OrderPembelianController::class, 'FindHeader'])->name('opembelian-findheader')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| FakturPembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/fpembelian', [FakturPembelianController::class,'View'])->name('fpembelian')->middleware(['auth', 'check.session']);
Route::get('/fpembelian/form/{id}', [FakturPembelianController::class,'Form'])->name('fpembelian-form')->middleware(['auth', 'check.session']);
Route::post('/fpembelian/storeJson', [FakturPembelianController::class, 'storeJson'])->name('fpembelian-storeJson')->middleware(['auth', 'check.session']);
Route::post('/fpembelian/editJson', [FakturPembelianController::class, 'editJson'])->name('fpembelian-editJson')->middleware(['auth', 'check.session']);
Route::post('/fpembelian/readheader', [FakturPembelianController::class, 'ViewHeader'])->name('fpembelian-readheader')->middleware(['auth', 'check.session']);
Route::post('/fpembelian/readdetail', [FakturPembelianController::class, 'ViewDetail'])->name('fpembelian-readdetail')->middleware(['auth', 'check.session']);
Route::post('/fpembelian/findheader', [FakturPembelianController::class, 'FindHeader'])->name('fpembelian-findheader')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Pembayaran Pembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/pembayaranpembelian', [PembayaranController::class,'View'])->name('pembayaranpembelian')->middleware(['auth', 'check.session']);
Route::get('/pembayaranpembelian/form/{id}', [PembayaranController::class,'Form'])->name('pembayaranpembelian-form')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembelian/storeJson', [PembayaranController::class, 'storeJson'])->name('pembayaranpembelian-storeJson')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembelian/editJson', [PembayaranController::class, 'editJson'])->name('pembayaranpembelian-editJson')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembelian/readheader', [PembayaranController::class, 'ViewHeader'])->name('pembayaranpembelian-readheader')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembelian/readdetail', [PembayaranController::class, 'ViewDetail'])->name('pembayaranpembelian-readdetail')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Retur Pembelian
|--------------------------------------------------------------------------
|
*/
Route::get('/returpembelian', [ReturPembelianController::class,'View'])->name('returpembelian')->middleware(['auth', 'check.session']);
Route::get('/returpembelian/form/{id}', [ReturPembelianController::class,'Form'])->name('returpembelian-form')->middleware(['auth', 'check.session']);
Route::post('/returpembelian/storeJson', [ReturPembelianController::class, 'storeJson'])->name('returpembelian-storeJson')->middleware(['auth', 'check.session']);
Route::post('/returpembelian/editJson', [ReturPembelianController::class, 'editJson'])->name('returpembelian-editJson')->middleware(['auth', 'check.session']);
Route::post('/returpembelian/readheader', [ReturPembelianController::class, 'ViewHeader'])->name('returpembelian-readheader')->middleware(['auth', 'check.session']);
Route::post('/returpembelian/readdetail', [ReturPembelianController::class, 'ViewDetail'])->name('returpembelian-readdetail')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Pengakuan Barang
|--------------------------------------------------------------------------
|
*/
Route::get('/gr', [PengakuanBarangController::class,'View'])->name('gr')->middleware(['auth', 'check.session']);
Route::get('/gr/form/{id}', [PengakuanBarangController::class,'Form'])->name('gr-form')->middleware(['auth', 'check.session']);
Route::post('/gr/storeJson', [PengakuanBarangController::class, 'storeJson'])->name('gr-storeJson')->middleware(['auth', 'check.session']);
Route::post('/gr/editJson', [PengakuanBarangController::class, 'editJson'])->name('gr-editJson')->middleware(['auth', 'check.session']);
Route::post('/gr/readheader', [PengakuanBarangController::class, 'ViewHeader'])->name('gr-readheader')->middleware(['auth', 'check.session']);
Route::post('/gr/readdetail', [PengakuanBarangController::class, 'ViewDetail'])->name('gr-readdetail')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Penghapusan Barang
|--------------------------------------------------------------------------
|
*/
Route::get('/gi', [PenghapusanBarangController::class,'View'])->name('gi')->middleware(['auth', 'check.session']);
Route::get('/gi/form/{id}', [PenghapusanBarangController::class,'Form'])->name('gi-form')->middleware(['auth', 'check.session']);
Route::post('/gi/storeJson', [PenghapusanBarangController::class, 'storeJson'])->name('gi-storeJson')->middleware(['auth', 'check.session']);
Route::post('/gi/editJson', [PenghapusanBarangController::class, 'editJson'])->name('gi-editJson')->middleware(['auth', 'check.session']);
Route::post('/gi/readheader', [PenghapusanBarangController::class, 'ViewHeader'])->name('gi-readheader')->middleware(['auth', 'check.session']);
Route::post('/gi/readdetail', [PenghapusanBarangController::class, 'ViewDetail'])->name('gi-readdetail')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Konsinyasi
|--------------------------------------------------------------------------
|
*/
Route::get('/cons', [PenerimaanKonsinyasiController::class,'View'])->name('cons')->middleware(['auth', 'check.session']);
Route::get('/cons/form/{id}', [PenerimaanKonsinyasiController::class,'Form'])->name('cons-form')->middleware(['auth', 'check.session']);
Route::post('/cons/storeJson', [PenerimaanKonsinyasiController::class, 'storeJson'])->name('cons-storeJson')->middleware(['auth', 'check.session']);
Route::post('/cons/editJson', [PenerimaanKonsinyasiController::class, 'editJson'])->name('cons-editJson')->middleware(['auth', 'check.session']);
Route::post('/cons/readheader', [PenerimaanKonsinyasiController::class, 'ViewHeader'])->name('cons-readheader')->middleware(['auth', 'check.session']);
Route::post('/cons/readdetail', [PenerimaanKonsinyasiController::class, 'ViewDetail'])->name('cons-readdetail')->middleware(['auth', 'check.session']);
Route::post('/cons/findheader', [PenerimaanKonsinyasiController::class, 'FindHeader'])->name('cons-findheader')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Konsinyasi
|--------------------------------------------------------------------------
|
*/
Route::get('/retcons', [ReturKonsinyasiController::class,'View'])->name('retcons')->middleware(['auth', 'check.session']);
Route::get('/retcons/form/{id}', [ReturKonsinyasiController::class,'Form'])->name('retcons-form')->middleware(['auth', 'check.session']);
Route::post('/retcons/storeJson', [ReturKonsinyasiController::class, 'storeJson'])->name('retcons-storeJson')->middleware(['auth', 'check.session']);
Route::post('/retcons/editJson', [ReturKonsinyasiController::class, 'editJson'])->name('retcons-editJson')->middleware(['auth', 'check.session']);
Route::post('/retcons/readheader', [ReturKonsinyasiController::class, 'ViewHeader'])->name('retcons-readheader')->middleware(['auth', 'check.session']);
Route::post('/retcons/readdetail', [ReturKonsinyasiController::class, 'ViewDetail'])->name('retcons-readdetail')->middleware(['auth', 'check.session']);
Route::post('/retcons/findheader', [ReturKonsinyasiController::class, 'FindHeader'])->name('retcons-findheader')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Pembayaran Konsinyasi
|--------------------------------------------------------------------------
|
*/
Route::get('/pembayaranpembeliankonsinyasi', [PembayaranKonsinyasiController::class,'View'])->name('pembayaranpembeliankonsinyasi')->middleware(['auth', 'check.session']);
Route::get('/pembayaranpembeliankonsinyasi/form/{id}', [PembayaranKonsinyasiController::class,'Form'])->name('pembayaranpembeliankonsinyasi-form')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembeliankonsinyasi/storeJson', [PembayaranKonsinyasiController::class, 'storeJson'])->name('pembayaranpembeliankonsinyasi-storeJson')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembeliankonsinyasi/editJson', [PembayaranKonsinyasiController::class, 'editJson'])->name('pembayaranpembeliankonsinyasi-editJson')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembeliankonsinyasi/readheader', [PembayaranKonsinyasiController::class, 'ViewHeader'])->name('pembayaranpembeliankonsinyasi-readheader')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembeliankonsinyasi/readdetail', [PembayaranKonsinyasiController::class, 'ViewDetail'])->name('pembayaranpembeliankonsinyasi-readdetail')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpembeliankonsinyasi/readpenjualan', [PembayaranKonsinyasiController::class, 'getKonsinyasiValue'])->name('pembayaranpembeliankonsinyasi-readpenjualan')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Order Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/openjualan', [OrderPenjualanController::class,'View'])->name('openjualan')->middleware(['auth', 'check.session']);
Route::get('/openjualan/form/{id}', [OrderPenjualanController::class,'Form'])->name('openjualan-form')->middleware(['auth', 'check.session']);
Route::post('/openjualan/storeJson', [OrderPenjualanController::class, 'storeJson'])->name('openjualan-storeJson')->middleware(['auth', 'check.session']);
Route::post('/openjualan/editJson', [OrderPenjualanController::class, 'editJson'])->name('openjualan-editJson')->middleware(['auth', 'check.session']);
Route::post('/openjualan/readheader', [OrderPenjualanController::class, 'ViewHeader'])->name('openjualan-readheader')->middleware(['auth', 'check.session']);
Route::post('/openjualan/readdetail', [OrderPenjualanController::class, 'ViewDetail'])->name('openjualan-readdetail')->middleware(['auth', 'check.session']);
Route::post('/openjualan/findheader', [OrderPenjualanController::class, 'FindHeader'])->name('openjualan-findheader')->middleware(['auth', 'check.session']);
Route::post('/openjualan/delete', [OrderPenjualanController::class, 'Delete'])->name('openjualan-delete')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Faktur Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/fpenjualan', [FakturPenjualanController::class,'View'])->name('fpenjualan')->middleware(['auth', 'check.session']);
Route::get('/fpenjualan/form/{id}', [FakturPenjualanController::class,'Form'])->name('fpenjualan-form')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/storeJson', [FakturPenjualanController::class, 'storeJson'])->name('fpenjualan-storeJson')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/editJson', [FakturPenjualanController::class, 'editJson'])->name('fpenjualan-editJson')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/readheader', [FakturPenjualanController::class, 'ViewHeader'])->name('fpenjualan-readheader')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/readdetail', [FakturPenjualanController::class, 'ViewDetail'])->name('fpenjualan-readdetail')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/findheader', [FakturPenjualanController::class, 'FindHeader'])->name('fpenjualan-findheader')->middleware(['auth', 'check.session']);
Route::get('/fpenjualan/pos', [PoSController::class, 'View'])->name('fpenjualan-pos')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/getDiskon', [PoSController::class, 'GetDiscount'])->name('fpenjualan-getDiskon')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/retailPos', [FakturPenjualanController::class, 'storePoS'])->name('fpenjualan-retailPos')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/editStatus', [FakturPenjualanController::class, 'EditTransactionStatus'])->name('fpenjualan-editStatus')->middleware(['auth', 'check.session']);
Route::get('/fpenjualan/print/{id}', [FakturPenjualanController::class, 'CetakFaktur'])->name('fpenjualan-print')->middleware(['auth', 'check.session']);
Route::get('/fpenjualan/printthermal/{id}', [FakturPenjualanController::class, 'PrintThermalReciept'])->name('fpenjualan-printthermal')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/retailPosFnb', [FakturPenjualanController::class, 'storePoSFnB'])->name('fpenjualan-retailPosFnB')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/editJsonPosFnb', [FakturPenjualanController::class, 'editJsonPoSFnB'])->name('fpenjualan-editJsonPosFnB')->middleware(['auth', 'check.session']);
Route::get('/fpenjualan/custdisplay', [CustDisplayController::class, 'View'])->name('fpenjualan-custdisplay')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/hiburanPoS', [FakturPenjualanController::class, 'storePoSHiburan'])->name('fpenjualan-hiburanPoS')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/void', [FakturPenjualanController::class, 'void'])->name('fpenjualan-void')->middleware(['auth', 'check.session']);
Route::post('/fpenjualan/getTimeSlots', [TableOrderController::class, 'getAvailableTimeSlots'])->name('fpenjualan-getTimeSlots')->middleware(['auth', 'check.session']);
Route::get('/daftartableorder', [TableOrderController::class, 'DaftarTableOrder'])->name('daftartableorder')->middleware(['auth', 'check.session']);
Route::post('/daftartableorder/reset', [TableOrderController::class, 'ResetController'])->name('daftartableorder-reset')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Retur Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/returpenjualan', [ReturPenjualanController::class,'View'])->name('returpenjualan')->middleware(['auth', 'check.session']);
Route::get('/returpenjualan/form/{id}', [ReturPenjualanController::class,'Form'])->name('returpenjualan-form')->middleware(['auth', 'check.session']);
Route::post('/returpenjualan/storeJson', [ReturPenjualanController::class, 'storeJson'])->name('returpenjualan-storeJson')->middleware(['auth', 'check.session']);
Route::post('/returpenjualan/editJson', [ReturPenjualanController::class, 'editJson'])->name('returpenjualan-editJson')->middleware(['auth', 'check.session']);
Route::post('/returpenjualan/readheader', [ReturPenjualanController::class, 'ViewHeader'])->name('returpenjualan-readheader')->middleware(['auth', 'check.session']);
Route::post('/returpenjualan/readdetail', [ReturPenjualanController::class, 'ViewDetail'])->name('returpenjualan-readdetail')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Printing Section
|--------------------------------------------------------------------------
|
*/

Route::get('/bluetooth/scan', [BluetoothController::class, 'scan'])->name('bluetooth-scan')->middleware(['auth', 'check.session']);
Route::get('/bluetooth/connect/{id}', [BluetoothController::class, 'connect'])->name('bluetooth-connect')->middleware(['auth', 'check.session']);
Route::post('/print/test', [PrinterController::class, 'PrintRecieptTest'])->name('print-test')->middleware(['auth', 'check.session']);
Route::get('/print/testusb48', [PrinterController::class, 'PrintRecieptUSB'])->name('print-testusb48')->middleware(['auth', 'check.session']);
Route::post('/print/retail', [PrinterController::class, 'PrintRecieptRetail'])->name('print-retail')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Delivery Note
|--------------------------------------------------------------------------
|
*/
Route::get('/delivery', [DeliveryNoteController::class,'View'])->name('delivery')->middleware(['auth', 'check.session']);
Route::get('/delivery/form/{id}', [DeliveryNoteController::class,'Form'])->name('delivery-form')->middleware(['auth', 'check.session']);
Route::post('/delivery/storeJson', [DeliveryNoteController::class, 'storeJson'])->name('delivery-storeJson')->middleware(['auth', 'check.session']);
Route::post('/delivery/editJson', [DeliveryNoteController::class, 'editJson'])->name('delivery-editJson')->middleware(['auth', 'check.session']);
Route::post('/delivery/readheader', [DeliveryNoteController::class, 'ViewHeader'])->name('delivery-readheader')->middleware(['auth', 'check.session']);
Route::post('/delivery/readdetail', [DeliveryNoteController::class, 'ViewDetail'])->name('delivery-readdetail')->middleware(['auth', 'check.session']);
Route::post('/delivery/editdeliverystatus', [DeliveryNoteController::class, 'EditDeliveryStatus'])->name('delivery-editdeliverystatus')->middleware(['auth', 'check.session']);
Route::post('/delivery/findheader', [DeliveryNoteController::class, 'FindHeader'])->name('delivery-findheader')->middleware(['auth', 'check.session']);
Route::post('/delivery/delete', [DeliveryNoteController::class, 'Delete'])->name('delivery-delete')->middleware(['auth', 'check.session']);
/*
|--------------------------------------------------------------------------
| Pembayaran Penjualan
|--------------------------------------------------------------------------
|
*/
Route::get('/pembayaranpenjualan', [PembayaranPenjualanController::class,'View'])->name('pembayaranpenjualan')->middleware(['auth', 'check.session']);
Route::get('/pembayaranpenjualan/form/{id}', [PembayaranPenjualanController::class,'Form'])->name('pembayaranpenjualan-form')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpenjualan/storeJson', [PembayaranPenjualanController::class, 'storeJson'])->name('pembayaranpenjualan-storeJson')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpenjualan/editJson', [PembayaranPenjualanController::class, 'editJson'])->name('pembayaranpenjualan-editJson')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpenjualan/readheader', [PembayaranPenjualanController::class, 'ViewHeader'])->name('pembayaranpenjualan-readheader')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpenjualan/readdetail', [PembayaranPenjualanController::class, 'ViewDetail'])->name('pembayaranpenjualan-readdetail')->middleware(['auth', 'check.session']);
Route::post('/pembayaranpenjualan/createpayment', [PembayaranPenjualanController::class, 'createMidTransTransaction'])->name('pembayaranpenjualan-createpayment')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Accounting Biaya
|--------------------------------------------------------------------------
|
*/
Route::get('/biaya', [BiayaController::class,'View'])->name('biaya')->middleware(['auth', 'check.session']);
Route::get('/biaya/form/{id}', [BiayaController::class,'Form'])->name('biaya-form')->middleware(['auth', 'check.session']);
Route::post('/biaya/storeJson', [BiayaController::class, 'storeJson'])->name('biaya-storeJson')->middleware(['auth', 'check.session']);
Route::post('/biaya/editJson', [BiayaController::class, 'editJson'])->name('biaya-editJson')->middleware(['auth', 'check.session']);
Route::post('/biaya/readheader', [BiayaController::class, 'ViewHeader'])->name('biaya-readheader')->middleware(['auth', 'check.session']);
Route::post('/biaya/readdetail', [BiayaController::class, 'ViewDetail'])->name('biaya-readdetail')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Jurnal entry
|--------------------------------------------------------------------------
|
*/
Route::get('/journal', [JournalController::class,'View'])->name('journal')->middleware(['auth', 'check.session']);
Route::get('/journal/form/{id}', [JournalController::class,'Form'])->name('journal-form')->middleware(['auth', 'check.session']);
Route::post('/journal/storeJson', [JournalController::class, 'storeJson'])->name('journal-storeJson')->middleware(['auth', 'check.session']);
Route::post('/journal/editJson', [JournalController::class, 'editJson'])->name('journal-editJson')->middleware(['auth', 'check.session']);
Route::post('/journal/readheader', [JournalController::class, 'ViewHeader'])->name('journal-readheader')->middleware(['auth', 'check.session']);
Route::post('/journal/readdetail', [JournalController::class, 'ViewDetail'])->name('journal-readdetail')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| StockOpname
|--------------------------------------------------------------------------
|
*/
Route::get('/stockopname', [StockOpnameController::class,'View'])->name('stockopname')->middleware(['auth', 'check.session']);
Route::get('/stockopname/form/{id}', [StockOpnameController::class,'Form'])->name('stockopname-form')->middleware(['auth', 'check.session']);
Route::post('/stockopname/storeJson', [StockOpnameController::class, 'storeJson'])->name('stockopname-storeJson')->middleware(['auth', 'check.session']);
Route::post('/stockopname/editJson', [StockOpnameController::class, 'editJson'])->name('stockopname-editJson')->middleware(['auth', 'check.session']);
Route::post('/stockopname/readheader', [StockOpnameController::class, 'ViewHeader'])->name('stockopname-readheader')->middleware(['auth', 'check.session']);
Route::post('/stockopname/readdetail', [StockOpnameController::class, 'ViewDetail'])->name('stockopname-readdetail')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Diskon Periodik
|--------------------------------------------------------------------------
|
*/
Route::get('/diskonperiodik', [DiskonPeriodikController::class,'View'])->name('diskonperiodik')->middleware(['auth', 'check.session']);
Route::get('/diskonperiodik/form/{id}', [DiskonPeriodikController::class,'Form'])->name('diskonperiodik-form')->middleware(['auth', 'check.session']);
Route::post('/diskonperiodik/store', [DiskonPeriodikController::class, 'store'])->name('diskonperiodik-store')->middleware(['auth', 'check.session']);
Route::post('/diskonperiodik/edit', [DiskonPeriodikController::class, 'edit'])->name('diskonperiodik-edit')->middleware(['auth', 'check.session']);
Route::delete('/diskonperiodik/delete/{id}', [DiskonPeriodikController::class, 'deletedata'])->name('diskonperiodik-delete')->middleware(['auth', 'check.session']);
Route::get('/diskonperiodik/export', [DiskonPeriodikController::class,'Export'])->name('diskonperiodik-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Report
|--------------------------------------------------------------------------
|
*/

Route::get('/report/kartustock', [ReportController::class, 'KartuStock'])->name('report-kartustock')->middleware(['auth', 'check.session']);
Route::get('/report/saldostock', [ReportController::class, 'RptSaldoStock'])->name('report-saldostock')->middleware(['auth', 'check.session']);
Route::post('/report/getpapersize', [ReportController::class, 'GetKertas'])->name('report-getpapersize')->middleware(['auth', 'check.session']);
Route::get('/report/generatebarcode', [ReportController::class, 'GenerateBarcode'])->name('report-generatebarcode')->middleware(['auth', 'check.session']);
Route::get('/report/generatetemplate', [ReportController::class, 'GenerateBarcodeTemplate'])->name('report-generatetemplate')->middleware(['auth', 'check.session']);
Route::get('/report/penjualan', [ReportController::class, 'RptPenjualan'])->name('report-penjualan')->middleware(['auth', 'check.session']);
Route::get('/report/returpenjualan', [ReportController::class, 'RptReturPenjualan'])->name('report-returpenjualan')->middleware(['auth', 'check.session']);
Route::get('/report/pembayaranpenjualan', [ReportController::class, 'RptPembayaranPenjualan'])->name('report-pembayaranpenjualan')->middleware(['auth', 'check.session']);
Route::get('/report/pembelian', [ReportController::class, 'RptPembelian'])->name('report-pembelian')->middleware(['auth', 'check.session']);
Route::get('/report/returpembelian', [ReportController::class, 'RptReturPembelian'])->name('report-returpembelian')->middleware(['auth', 'check.session']);
Route::get('/report/pembayaranpembelian', [ReportController::class, 'RptPembayaranPembelian'])->name('report-pembayaranpembelian')->middleware(['auth', 'check.session']);
Route::get('/report/saldorekening', [ReportController::class, 'RptSaldoRekening'])->name('report-saldorekening')->middleware(['auth', 'check.session']);
Route::get('/report/neracasaldo', [ReportController::class, 'RptNeracaSaldo'])->name('report-neracasaldo')->middleware(['auth', 'check.session']);
Route::get('/report/labarugi', [ReportController::class, 'rptLabaRugi'])->name('report-labarugi')->middleware(['auth', 'check.session']);



/*
|--------------------------------------------------------------------------
| Katalog
|--------------------------------------------------------------------------
|
*/

Route::get('/cat/{ID}', [KatalogController::class, 'View'])->name('cat-catalouge');
Route::post('/cat/itemmaster', [KatalogController::class, 'ViewItemMaster'])->name('cat-itemmaster');

/*
|--------------------------------------------------------------------------
| Kelompok Meja
|--------------------------------------------------------------------------
|
*/
Route::get('/kelompokmeja', [KelompokMejaController::class,'View'])->name('kelompokmeja')->middleware(['auth', 'check.session']);
Route::get('/kelompokmeja/form/{id}', [KelompokMejaController::class,'Form'])->name('kelompokmeja-form')->middleware(['auth', 'check.session']);
Route::post('/kelompokmeja/store', [KelompokMejaController::class, 'store'])->name('kelompokmeja-store')->middleware(['auth', 'check.session']);
Route::post('/kelompokmeja/edit', [KelompokMejaController::class, 'edit'])->name('kelompokmeja-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/kelompokmeja/read', [KelompokMejaController::class, 'ViewJson'])->name('kelompokmeja-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/kelompokmeja/storeJson', [KelompokMejaController::class, 'storeJson'])->name('kelompokmeja-storeJson')->middleware(['auth', 'check.session']);
Route::post('/kelompokmeja/editJson', [KelompokMejaController::class, 'editJson'])->name('kelompokmeja-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/kelompokmeja/delete/{id}', [KelompokMejaController::class, 'deletedata'])->name('kelompokmeja-delete')->middleware(['auth', 'check.session']);
Route::get('/kelompokmeja/export', [KelompokMejaController::class,'Export'])->name('kelompokmeja-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Meja
|--------------------------------------------------------------------------
|
*/
Route::get('/meja', [MejaController::class,'View'])->name('meja')->middleware(['auth', 'check.session']);
Route::get('/meja/form/{id}', [MejaController::class,'Form'])->name('meja-form')->middleware(['auth', 'check.session']);
Route::post('/meja/store', [MejaController::class, 'store'])->name('meja-store')->middleware(['auth', 'check.session']);
Route::post('/meja/edit', [MejaController::class, 'edit'])->name('meja-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/meja/read', [MejaController::class, 'ViewJson'])->name('meja-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/meja/storeJson', [MejaController::class, 'storeJson'])->name('meja-storeJson')->middleware(['auth', 'check.session']);
Route::post('/meja/editJson', [MejaController::class, 'editJson'])->name('meja-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/meja/delete/{id}', [MejaController::class, 'deletedata'])->name('meja-delete')->middleware(['auth', 'check.session']);
Route::get('/meja/export', [MejaController::class,'Export'])->name('meja-export')->middleware(['auth', 'check.session']);
Route::get('/meja/exportQR', [MejaController::class,'ExportQRCode'])->name('exportQR')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Subscription - Admin
|--------------------------------------------------------------------------
|
*/
Route::get('/subs', [SubscriptionController::class,'View'])->name('subs')->middleware(['auth', 'check.session']);
Route::get('/subs/form/{id}', [SubscriptionController::class,'Form'])->name('subs-form')->middleware(['auth', 'check.session']);
Route::post('/subs/storeJson', [SubscriptionController::class, 'storeJson'])->name('subs-storeJson')->middleware(['auth', 'check.session']);
Route::post('/subs/editJson', [SubscriptionController::class, 'editJson'])->name('subs-editJson')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Subscription - Admin
|--------------------------------------------------------------------------
|
*/
Route::get('/penggunaaplikasi', [CompanyController::class,'AdminPelanggan'])->name('penggunaaplikasi')->middleware(['auth', 'check.session']);
Route::post('/penggunaaplikasi/suspend', [CompanyController::class, 'UpdateSuspend'])->name('penggunaaplikasi-suspend')->middleware(['auth', 'check.session']);
Route::post('/penggunaaplikasi/rubahlangganan', [CompanyController::class, 'UpdatePaket'])->name('penggunaaplikasi-rubahlangganan')->middleware(['auth', 'check.session']);
Route::get('/penggunaaplikasi/export', [CompanyController::class,'Export'])->name('penggunaaplikasi-export')->middleware(['auth', 'check.session']);
Route::post('/penggunaaplikasi/remove', [CompanyController::class,'DeletePengguna'])->name('penggunaaplikasi-remove')->middleware(['auth', 'check.session']);
/*
|--------------------------------------------------------------------------
| Invoice Pengguna - Admin
|--------------------------------------------------------------------------
|
*/
Route::post('/invpengguna/storeJson', [InvoicePenggunaController::class, 'storeJson'])->name('invpengguna-storeJson')->middleware(['auth', 'check.session']);
Route::post('/invpengguna/pay-gateway', [InvoicePenggunaController::class, 'SimpanPembayaranJson'])->name('invpengguna-pay-gateway')->middleware(['auth', 'check.session']);
Route::post('/invpengguna/create-gateway', [InvoicePenggunaController::class, 'createMidTransTransaction'])->name('invpengguna-create-gateway')->middleware(['auth', 'check.session']);
Route::post('/invpengguna/bayar', [InvoicePenggunaController::class, 'SimpanPembayaran'])->name('invpengguna-bayar')->middleware(['auth', 'check.session']);
Route::post('/invpengguna/viewheader', [InvoicePenggunaController::class, 'GetHeader'])->name('invpengguna-viewheader')->middleware(['auth', 'check.session']);
Route::get('/tagihanpengguna', [InvoicePenggunaController::class, 'View'])->name('invpengguna-tagihanpengguna')->middleware(['auth', 'check.session']);
Route::get('/tagihanpengguna/export/{TglAwal}/{TglAkhir}', [InvoicePenggunaController::class,'Export'])->name('tagihanpengguna-export')->middleware(['auth', 'check.session']);

// GetPerCompany SimpanPembayaranJson
Route::post('/invpengguna/viewpercom', [InvoicePenggunaController::class, 'GetPerCompany'])->name('invpengguna-viewpercom')->middleware(['auth', 'check.session']);

Route::get('/testseed', [CompanyController::class, 'GenerateInitialData'])->name('testseed');
Route::post('/voidinvoice', [InvoicePenggunaController::class, 'VoidInvoice'])->name('voidinvoice')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Variant Menu
|--------------------------------------------------------------------------
|
*/
Route::get('/grupvariant', [VariantMenuController::class,'View'])->name('grupvariant')->middleware(['auth', 'check.session']);
Route::get('/grupvariant/form/{id}', [VariantMenuController::class,'Form'])->name('grupvariant-form')->middleware(['auth', 'check.session']);
Route::post('/grupvariant/store', [VariantMenuController::class, 'store'])->name('grupvariant-store')->middleware(['auth', 'check.session']);
Route::post('/grupvariant/edit', [VariantMenuController::class, 'edit'])->name('grupvariant-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/grupvariant/read', [VariantMenuController::class, 'ViewJson'])->name('grupvariant-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/grupvariant/storeJson', [VariantMenuController::class, 'storeJson'])->name('meja-storeJson')->middleware(['auth', 'check.session']);
Route::post('/grupvariant/editJson', [VariantMenuController::class, 'editJson'])->name('meja-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/grupvariant/delete/{id}', [VariantMenuController::class, 'deletedata'])->name('grupvariant-delete')->middleware(['auth', 'check.session']);
Route::get('/grupvariant/export', [VariantMenuController::class,'Export'])->name('grupvariant-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Addon Menu
|--------------------------------------------------------------------------
|
*/
Route::get('/menuaddon', [MenuAddonController::class,'View'])->name('menuaddon')->middleware(['auth', 'check.session']);
Route::get('/menuaddon/form/{id}', [MenuAddonController::class,'Form'])->name('menuaddon-form')->middleware(['auth', 'check.session']);
Route::post('/menuaddon/store', [MenuAddonController::class, 'store'])->name('menuaddon-store')->middleware(['auth', 'check.session']);
Route::post('/menuaddon/edit', [MenuAddonController::class, 'edit'])->name('menuaddon-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/menuaddon/read', [MenuAddonController::class, 'ViewJson'])->name('menuaddon-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/menuaddon/storeJson', [MenuAddonController::class, 'storeJson'])->name('menuaddon-storeJson')->middleware(['auth', 'check.session']);
Route::post('/menuaddon/editJson', [MenuAddonController::class, 'editJson'])->name('menuaddon-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/menuaddon/delete/{id}', [MenuAddonController::class, 'deletedata'])->name('menuaddon-delete')->middleware(['auth', 'check.session']);
Route::get('/menuaddon/export', [MenuAddonController::class,'Export'])->name('menuaddon-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Tipe Order Resto
|--------------------------------------------------------------------------
|
*/
Route::get('/tipeorderresto', [TipeOrderRestoController::class,'View'])->name('tipeorderresto')->middleware(['auth', 'check.session']);
Route::get('/tipeorderresto/form/{id}', [TipeOrderRestoController::class,'Form'])->name('tipeorderresto-form')->middleware(['auth', 'check.session']);
Route::post('/tipeorderresto/store', [TipeOrderRestoController::class, 'store'])->name('tipeorderresto-store')->middleware(['auth', 'check.session']);
Route::post('/tipeorderresto/edit', [TipeOrderRestoController::class, 'edit'])->name('tipeorderresto-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/tipeorderresto/read', [TipeOrderRestoController::class, 'ViewJson'])->name('tipeorderresto-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/tipeorderresto/storeJson', [TipeOrderRestoController::class, 'storeJson'])->name('tipeorderresto-storeJson')->middleware(['auth', 'check.session']);
Route::post('/tipeorderresto/editJson', [TipeOrderRestoController::class, 'editJson'])->name('tipeorderresto-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/tipeorderresto/delete/{id}', [TipeOrderRestoController::class, 'deletedata'])->name('tipeorderresto-delete')->middleware(['auth', 'check.session']);
Route::get('/tipeorderresto/export', [TipeOrderRestoController::class,'Export'])->name('tipeorderresto-export')->middleware(['auth', 'check.session']);



/*
|--------------------------------------------------------------------------
| Tipe Order Resto
|--------------------------------------------------------------------------
|
*/
Route::get('/menu', [MenuRestoAddonController::class,'View'])->name('menu')->middleware(['auth', 'check.session']);
Route::get('/menu/form/{id}', [MenuRestoAddonController::class,'Form'])->name('menu-form')->middleware(['auth', 'check.session']);
Route::post('/menu/store', [MenuRestoAddonController::class, 'store'])->name('menu-store')->middleware(['auth', 'check.session']);
Route::post('/menu/edit', [MenuRestoAddonController::class, 'edit'])->name('menu-edit')->middleware(['auth', 'check.session']);

// json
Route::post('/menu/read', [MenuRestoAddonController::class, 'ViewJson'])->name('menu-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/menu/storeJson', [MenuRestoAddonController::class, 'storeJson'])->name('menu-storeJson')->middleware(['auth', 'check.session']);
Route::post('/menu/editJson', [MenuRestoAddonController::class, 'editJson'])->name('menu-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/menu/delete/{KodeItemHasil}', [MenuRestoAddonController::class, 'deletedata'])->name('menu-delete')->middleware(['auth', 'check.session']);
Route::get('/menu/export', [MenuRestoAddonController::class,'Export'])->name('menu-export')->middleware(['auth', 'check.session']);


// Sending Email
Route::get('/send/auth', [EmailController::class,'InitMail'])->name('send-auth');

// TnC TnCController
Route::get('/tnc', [TnCController::class,'View'])->name('tnc')->middleware(['auth', 'check.session']);
Route::post('/tnc/edit', [TnCController::class, 'edit'])->name('tnc-edit')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Kas Keluar
|--------------------------------------------------------------------------
|
*/
Route::get('/kaskeluar', [KasKeluarController::class,'View'])->name('kaskeluar')->middleware(['auth', 'check.session']);
Route::get('/kaskeluar/form/{id}', [KasKeluarController::class,'Form'])->name('kaskeluar-form')->middleware(['auth', 'check.session']);
Route::post('/kaskeluar/store', [KasKeluarController::class, 'store'])->name('kaskeluar-store')->middleware(['auth', 'check.session']);
Route::post('/kaskeluar/edit', [KasKeluarController::class, 'edit'])->name('kaskeluar-edit')->middleware(['auth', 'check.session']);
Route::post('/kaskeluar/readheader', [KasKeluarController::class, 'ViewHeader'])->name('kaskeluar-readheader')->middleware(['auth', 'check.session']);
Route::post('/kaskeluar/readdetail', [KasKeluarController::class, 'ViewDetail'])->name('kaskeluar-readdetail')->middleware(['auth', 'check.session']);
Route::delete('/kaskeluar/delete/{id}', [KasKeluarController::class, 'deletedata'])->name('kaskeluar-delete')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Kas Masuk
|--------------------------------------------------------------------------
|
*/
Route::get('/kasmasuk', [KasMasukController::class,'View'])->name('kasmasuk')->middleware(['auth', 'check.session']);
Route::get('/kasmasuk/form/{id}', [KasMasukController::class,'Form'])->name('kasmasuk-form')->middleware(['auth', 'check.session']);
Route::post('/kasmasuk/store', [KasMasukController::class, 'store'])->name('kasmasuk-store')->middleware(['auth', 'check.session']);
Route::post('/kasmasuk/edit', [KasMasukController::class, 'edit'])->name('kasmasuk-edit')->middleware(['auth', 'check.session']);
Route::post('/kasmasuk/readheader', [KasMasukController::class, 'ViewHeader'])->name('kasmasuk-readheader')->middleware(['auth', 'check.session']);
Route::post('/kasmasuk/readdetail', [KasMasukController::class, 'ViewDetail'])->name('kasmasuk-readdetail')->middleware(['auth', 'check.session']);
Route::delete('/kasmasuk/delete/{id}', [KasMasukController::class, 'deletedata'])->name('kasmasuk-delete')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Meja
|--------------------------------------------------------------------------
|
*/
Route::get('/controller', [MasterControllerController::class,'View'])->name('controller')->middleware(['auth', 'check.session']);
Route::get('/controller/form/{id}', [MasterControllerController::class,'Form'])->name('controller-form')->middleware(['auth', 'check.session']);
Route::post('/controller/store', [MasterControllerController::class, 'store'])->name('controller-store')->middleware(['auth', 'check.session']);
Route::post('/controller/edit', [MasterControllerController::class, 'edit'])->name('controller-edit')->middleware(['auth', 'check.session']);
// json
Route::post('/controller/read', [MasterControllerController::class, 'ViewJson'])->name('controller-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/controller/storeJson', [MasterControllerController::class, 'storeJson'])->name('controller-storeJson')->middleware(['auth', 'check.session']);
Route::post('/controller/editJson', [MasterControllerController::class, 'editJson'])->name('controller-editJson')->middleware(['auth', 'check.session']);
Route::post('/controller/editcommand', [MasterControllerController::class, 'DeviceCommand'])->name('controller-editcommand')->middleware(['auth', 'check.session']);
// end json
Route::delete('/controller/delete/{id}', [MasterControllerController::class, 'deletedata'])->name('controller-delete')->middleware(['auth', 'check.session']);
Route::get('/controller/export', [MasterControllerController::class,'Export'])->name('controller-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Meja
|--------------------------------------------------------------------------
|
*/
Route::get('/titiklampu', [TitikLampuController::class,'View'])->name('titiklampu')->middleware(['auth', 'check.session']);
Route::get('/titiklampu/form/{id}', [TitikLampuController::class,'Form'])->name('titiklampu-form')->middleware(['auth', 'check.session']);
Route::post('/titiklampu/store', [TitikLampuController::class, 'store'])->name('titiklampu-store')->middleware(['auth', 'check.session']);
Route::post('/titiklampu/edit', [TitikLampuController::class, 'edit'])->name('titiklampu-edit')->middleware(['auth', 'check.session']);
// json
Route::post('/titiklampu/read', [TitikLampuController::class, 'ViewJson'])->name('titiklampu-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/titiklampu/storeJson', [TitikLampuController::class, 'storeJson'])->name('titiklampu-storeJson')->middleware(['auth', 'check.session']);
Route::post('/titiklampu/editJson', [TitikLampuController::class, 'editJson'])->name('titiklampu-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/titiklampu/delete/{id}', [TitikLampuController::class, 'deletedata'])->name('titiklampu-delete')->middleware(['auth', 'check.session']);
Route::get('/titiklampu/export', [TitikLampuController::class,'Export'])->name('titiklampu-export')->middleware(['auth', 'check.session']);
Route::get('/get-meja', [TitikLampuController::class, 'getMeja'])->name('titiklampu-getMeja')->middleware(['auth', 'check.session']);
Route::post('/titiklampu/updateStatusMeja', [TitikLampuController::class, 'updateStatusMeja'])->name('titiklampu-updateStatusMeja')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| App Setting
|--------------------------------------------------------------------------
|
*/

Route::get('/appsetting', [EnvController::class,'View'])->name('appsetting')->middleware(['auth', 'check.session']);
Route::post('/appsetting/update', [EnvController::class, 'update'])->name('appsetting-update')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Paket Per Menit
|--------------------------------------------------------------------------
|
*/
Route::get('/paket', [PaketController::class,'View'])->name('paket')->middleware(['auth', 'check.session']);
Route::get('/paket/form/{id}', [PaketController::class,'Form'])->name('paket-form')->middleware(['auth', 'check.session']);
Route::post('/paket/store', [PaketController::class, 'store'])->name('paket-store')->middleware(['auth', 'check.session']);
Route::post('/paket/edit', [PaketController::class, 'edit'])->name('paket-edit')->middleware(['auth', 'check.session']);
// json
Route::post('/paket/read', [PaketController::class, 'ViewJson'])->name('paket-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/paket/storeJson', [PaketController::class, 'storeJson'])->name('paket-storeJson')->middleware(['auth', 'check.session']);
Route::post('/paket/editJson', [PaketController::class, 'editJson'])->name('paket-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/paket/delete/{id}', [PaketController::class, 'deletedata'])->name('paket-delete')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Billing
|--------------------------------------------------------------------------
|
*/
Route::get('/billing', [TableOrderController::class,'View'])->name('billing')->middleware(['auth', 'check.session']);
Route::post('/billing/store', [TableOrderController::class, 'store'])->name('billing-store')->middleware(['auth', 'check.session']);
Route::post('/billing/editdurasi', [TableOrderController::class, 'EditPaket'])->name('billing-editdurasi')->middleware(['auth', 'check.session']);
Route::post('/billing/checkout', [TableOrderController::class, 'CheckOut'])->name('billing-checkout')->middleware(['auth', 'check.session']);
Route::post('/billing/addfnb', [TableOrderController::class, 'AddFnB'])->name('billing-addfnb')->middleware(['auth', 'check.session']);
Route::post('/billing/readfnb', [TableOrderController::class, 'ReadTableOrderFnB'])->name('billing-readfnb')->middleware(['auth', 'check.session']);
Route::post('/billing/warning', [TableOrderController::class, 'NotifHampirHabis'])->name('billing-warning')->middleware(['auth', 'check.session']);
Route::post('/billing/repopulate', [TableOrderController::class, 'ReadTitikLampu'])->name('billing-repopulate')->middleware(['auth', 'check.session']);
Route::get('/billing/self-service', [TableOrderController::class,'ViewSelfService'])->name('billing-self-service')->middleware(['auth', 'check.session']);
Route::post('/billing/maxtime', [TableOrderController::class, 'GetMaximalPaketMenit'])->name('billing-maxtime')->middleware(['auth', 'check.session']);
// GetMaximalPaketMenit
/*
|--------------------------------------------------------------------------
| Booking Online
|--------------------------------------------------------------------------
|
*/
Route::get('/booking/{id}', [BookingOnlineController::class,'indexRev2'])->name('booking-index');   
Route::get('/booking', [BookingOnlineController::class, 'getData'])->name('booking');
Route::post('/booking/create-gateway', [BookingOnlineController::class, 'createMidTransTransaction'])->name('booking-create-gateway');
Route::post('/booking/pay-gateway', [BookingOnlineController::class, 'SimpanPembayaranJson'])->name('booking-pay-gateway');
Route::get('/booking/{id}/get-bookedtable', [BookingOnlineController::class, 'getBookingsByDate'])->name('booking-get-bookedtable');
Route::get('/booking/{id}/get-DiscountVoucher', [BookingOnlineController::class, 'getDiscountVoucher'])->name('booking-get-DiscountVoucher');
Route::get('/bookinglist', [BookingOnlineController::class, 'View'])->name('bookinglist')->middleware(['auth', 'check.session']);
Route::get('/booking/generateVoucher', [BookingOnlineController::class, 'ViewGenerateVoucher'])->name('booking-generateVoucher');
Route::post('/booking/voucher-store', [BookingOnlineController::class, 'storeVoucher'])->name('booking-voucherStore');
Route::get('/booking/get-listVoucher', [BookingOnlineController::class, 'getListVoucher'])->name('booking-getListVoucher');
Route::get('/get-Bookings', [BookingOnlineController::class, 'getBookings'])->name('booking-getBookings')->middleware(['auth', 'check.session']);
Route::get('/booking/get-detailBooking/{noTransaksi}', [BookingOnlineController::class, 'getBookingDetail'])->name('booking-getDetailBooking');
Route::get('/booking/get-meja-by-transaksi/{noTransaksi}', [BookingOnlineController::class, 'getMejaByTransaksi'])->name('booking-getMejaByTransaksi');
Route::post('/booking/insert-tableorderheader', [BookingOnlineController::class, 'insertTableOrder'])->name('booking-insertTableorderheader');
Route::post('/get-BookingsList', [BookingOnlineController::class, 'getBookingsList'])->name('booking-getBookingsList')->middleware(['auth', 'check.session']);
Route::post('/getjadwal', [BookingOnlineController::class, 'getjadwalMeja'])->name('booking-getjadwal')->middleware(['auth', 'check.session']);

/*
|--------------------------------------------------------------------------
| Document Controller
|--------------------------------------------------------------------------
|
*/
Route::get('/document', [DocumentOutputController::class,'index'])->name('document')->middleware(['auth', 'check.session']);
Route::post('/sendemail', [DocumentOutputController::class,'SendEmail'])->name('sendemail')->middleware(['auth', 'check.session']);
Route::post('/sendwa', [DocumentOutputController::class,'SendWhatsApp'])->name('sendwa')->middleware(['auth', 'check.session']);
Route::get('/download-pdf/{file}', [DocumentOutputController::class, 'downloadPdf'])->name('download-pdf');



/*
|--------------------------------------------------------------------------
| Kelompok Lampu
|--------------------------------------------------------------------------
|
*/
Route::get('/kelompoklampu', [KelompokLampuController::class,'View'])->name('kelompoklampu')->middleware(['auth', 'check.session']);
Route::get('/kelompoklampu/form/{id}', [KelompokLampuController::class,'Form'])->name('kelompoklampu-form')->middleware(['auth', 'check.session']);
Route::post('/kelompoklampu/store', [KelompokLampuController::class, 'store'])->name('kelompoklampu-store')->middleware(['auth', 'check.session']);
Route::post('/kelompoklampu/edit', [KelompokLampuController::class, 'edit'])->name('kelompoklampu-edit')->middleware(['auth', 'check.session']);
Route::delete('/kelompoklampu/delete/{id}', [KelompokLampuController::class, 'deletedata'])->name('kelompoklampu-delete')->middleware(['auth', 'check.session']);
// json
Route::post('/kelompoklampu/read', [KelompokLampuController::class, 'ViewJson'])->name('kelompoklampu-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/kelompoklampu/storeJson', [KelompokLampuController::class, 'storeJson'])->name('kelompoklampu-storeJson')->middleware(['auth', 'check.session']);
Route::post('/kelompoklampu/editJson', [KelompokLampuController::class, 'editJson'])->name('kelompoklampu-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/kelompoklampu/delete/{id}', [KelompokLampuController::class, 'deletedata'])->name('kelompoklampu-delete')->middleware(['auth', 'check.session']);
Route::get('/kelompoklampu/export', [KelompokLampuController::class,'Export'])->name('kelompoklampu-export')->middleware(['auth', 'check.session']);


/*
|--------------------------------------------------------------------------
| Discount Voucher
|--------------------------------------------------------------------------
|
*/
Route::get('/discountvoucher', [DiscountVoucherController::class,'View'])->name('discountvoucher')->middleware(['auth', 'check.session']);
Route::get('/discountvoucher/form/{id}', [DiscountVoucherController::class,'Form'])->name('discountvoucher-form')->middleware(['auth', 'check.session']);
Route::post('/discountvoucher/store', [DiscountVoucherController::class, 'store'])->name('discountvoucher-store')->middleware(['auth', 'check.session']);
Route::post('/discountvoucher/edit', [DiscountVoucherController::class, 'edit'])->name('discountvoucher-edit')->middleware(['auth', 'check.session']);
Route::delete('/discountvoucher/delete/{id}', [DiscountVoucherController::class, 'deletedata'])->name('discountvoucher-delete')->middleware(['auth', 'check.session']);
// json
Route::post('/discountvoucher/read', [DiscountVoucherController::class, 'ViewJson'])->name('discountvoucher-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/discountvoucher/storeJson', [DiscountVoucherController::class, 'storeJson'])->name('discountvoucher-storeJson')->middleware(['auth', 'check.session']);
Route::post('/discountvoucher/editJson', [DiscountVoucherController::class, 'editJson'])->name('discountvoucher-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/discountvoucher/delete/{id}', [DiscountVoucherController::class, 'deletedata'])->name('discountvoucher-delete')->middleware(['auth', 'check.session']);
Route::get('/discountvoucher/export', [DiscountVoucherController::class,'Export'])->name('discountvoucher-export')->middleware(['auth', 'check.session']);



Route::get('/queue/{id}', [QueueManagementController::class,'index'])->name('queue-management');
Route::post('/queue/getData', [QueueManagementController::class, 'handleQueue'])->name('queue-getData');

/*
|--------------------------------------------------------------------------
| Support Page
|--------------------------------------------------------------------------
|
*/
Route::get('/faq', [SupportPageController::class,'View'])->name('faq')->middleware(['auth', 'check.session']);
Route::get('/faqUser', [SupportPageController::class,'ViewUser'])->name('faqUser')->middleware(['auth', 'check.session']);
Route::get('/faq/detail/{id}', [SupportPageController::class,'ViewUserDetail'])->name('faq-detail')->middleware(['auth', 'check.session']);
Route::get('/faq/form/{id}', [SupportPageController::class,'Form'])->name('faq-form')->middleware(['auth', 'check.session']);
Route::post('/faq/store', [SupportPageController::class, 'store'])->name('faq-store')->middleware(['auth', 'check.session']);
Route::post('/faq/edit', [SupportPageController::class, 'edit'])->name('faq-edit')->middleware(['auth', 'check.session']);
Route::delete('/faq/delete/{id}', [SupportPageController::class, 'deletedata'])->name('faq-delete')->middleware(['auth', 'check.session']);
// json
Route::post('/faq/read', [SupportPageController::class, 'ViewJson'])->name('faq-ViewJson')->middleware(['auth', 'check.session']);
Route::post('/faq/storeJson', [SupportPageController::class, 'storeJson'])->name('faq-storeJson')->middleware(['auth', 'check.session']);
Route::post('/faq/editJson', [SupportPageController::class, 'editJson'])->name('faq-editJson')->middleware(['auth', 'check.session']);
// end json
Route::delete('/faq/delete/{id}', [SupportPageController::class, 'deletedata'])->name('faq-delete')->middleware(['auth', 'check.session']);
Route::get('/faq/export', [SupportPageController::class,'Export'])->name('faq-export')->middleware(['auth', 'check.session']);


Route::get('/log/{id}', [LogingController::class,'view'])->name('log');  