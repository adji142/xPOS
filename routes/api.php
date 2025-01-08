<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrintingRecieptController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\FlutterWebAppsController;
use App\Http\Controllers\FakturPenjualanController;
use App\Http\Controllers\TableOrderController;
use App\Http\Controllers\MasterControllerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[LoginController::class,'API_login']);
Route::post('logout',[LoginController::class,'logout'])->middleware('auth:sanctum');
Route::post('test',[PrintingRecieptController::class,'GetData']);

Route::post('printerlist',[PrinterController::class,'Read']);
Route::post('printerstore',[PrinterController::class,'store']);
Route::post('printeredit',[PrinterController::class,'edit']);
Route::post('printerdelete',[PrinterController::class,'delete']);
Route::post('testnotif',[PrinterController::class,'TestNotif']);


Route::post('initWebMenu',[FlutterWebAppsController::class,'InitProgram']);
Route::post('saveFromTable',[FlutterWebAppsController::class,'TableServices']);

Route::post('getMenu',[FlutterWebAppsController::class,'GetMenuByKelompok']);
Route::post('getAddon',[FlutterWebAppsController::class,'getVariantAddonData']);
Route::post('getTable',[TableOrderController::class,'ReadTableAPI']);

Route::post('checkCommand',[MasterControllerController::class,'CheckCommand']);
Route::post('releaseCommand',[MasterControllerController::class,'DeviceCommand']);