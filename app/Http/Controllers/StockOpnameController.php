<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\DocumentNumbering;
use App\Models\Sales;
use App\Models\Gudang;
use App\Models\StockOpnameHeader;
use App\Models\StockOpnameDetail;

class StockOpnameController extends Controller
{
    public function View(Request $request){
        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');

        $sales = Sales::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $sql = "stockopnameheader.TglTransaksi, stockopnameheader.NoTransaksi, 
                COUNT(DISTINCT stockopnamedetail.KodeItem) JumlahItem, 
                SUM(stockopnamedetail.Qty) QtyOpname, SUM(stockopnamedetail.Stock) Stock ";
        $stockopname = StockOpnameHeader::selectRaw($sql)
                    ->leftJoin('stockopnamedetail', function ($value){
                        $value->on('stockopnamedetail.NoTransaksi','=','stockopnameheader.NoTransaksi')
                        ->on('stockopnamedetail.RecordOwnerID','=','stockopnameheader.RecordOwnerID');
                    })
                    ->whereBetween(DB::raw("DATE(stockopnameheader.TglTransaksi)"), [$TglAwal, $TglAkhir])
                    ->groupBy('stockopnameheader.TglTransaksi','stockopnameheader.NoTransaksi')
                    ->get();
        return view("Transaksi.Inventory.StockCount",[
            'stockopname' => $stockopname, 
            'sales' => $sales
        ]);
    }

    public function Form($NoTransaksi = null)
    {
    	$sales = Sales::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        $gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $stockcountheader = StockOpnameHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('NoTransaksi', $NoTransaksi)
                    ->get();
        $stockcountdetail = StockOpnameDetail::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('NoTransaksi', $NoTransaksi)
                    ->get();
        
        return view("Transaksi.Inventory.StockCount-Input",[
            'sales' => $sales,
            'gudang' => $gudang,
            'stockcountheader' => $stockcountheader,
            'stockcountdetail' => $stockcountdetail,
        ]);
    }

    public function storeJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
		Log::debug($request->all());
		DB::beginTransaction();

        $errorCount = 0;
		$jsonData = $request->json()->all();

        try {
            $currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

            $numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("OSC","stockopnameheader","NoTransaksi");

            $model = new StockOpnameHeader;
            $model->NoTransaksi = $NoTransaksi;
            $model->Periode = $Year.$Month;
            $model->TglTransaksi = $jsonData['TglTransaksi'];
            $model->TanggalMulai = Carbon::now();
            $model->TanggalSelesai = Carbon::now();
            $model->KodeKaryawan = $jsonData['KodeKaryawan'];
            $model->Keterangan = $jsonData['Keterangan'];
            $model->CreatedBy = Auth::user()->name;
            $model->UpdatedBy = "";
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $saveheader = $model->save();

            // Detail
            if (count($jsonData['Detail']) == 0) {
                $data['message'] = "No Data Found";
                $errorCount += 1;
                goto jump;
            }

            $index = 0;
            foreach ($jsonData['Detail'] as $key) {
                $modelDetail = new StockOpnameDetail;
                $modelDetail->NoTransaksi = $NoTransaksi;
                $modelDetail->KodeGudang = $key['KodeGudang'];
                $modelDetail->NoUrut = $index;
                $modelDetail->KodeItem = $key['KodeItem'];
                $modelDetail->Qty = $key['Qty'];
                $modelDetail->Stock = $key['Stock'];
                $modelDetail->CreatedBy = Auth::user()->name;
                $modelDetail->UpdatedBy = "";
                $modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

                $saveDetail = $modelDetail->save();
                if (!$saveDetail) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key['NoUrut'];
					$errorCount += 1;
					goto jump;
				}
                $index +=1;
            }

            jump:
	        if ($errorCount > 0) {
		        DB::rollback();
		        $data['success'] = false;
	        }
	        else{
		        DB::commit();
		        $data['success'] = true;
	        }
        } catch (\Exception $e) {
			Log::debug($e->getMessage());
	        $data['message'] = $e->getMessage();
		}

		return response()->json($data);
    }

    public function editJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;
        $jsonData = $request->json()->all();

        try {
            $model = StockOpnameHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                $update = DB::table('stockopnameheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                           ->update(
                               [
                                    'KodeKaryawan' => $jsonData['KodeKaryawan'],
									'Keterangan' => $jsonData['Keterangan'],
									'UpdatedBy' => Auth::user()->name
                               ]
                           );
                
                if (count($jsonData['Detail']) > 0) {
                    $delete = DB::table('stockopnamedetail')
		                        ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
		                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                        ->delete();

                    // Detail
                    if (count($jsonData['Detail']) == 0) {
                        $data['message'] = "No Data Found";
                        $errorCount += 1;
                        goto jump;
                    }

                    foreach ($jsonData['Detail'] as $key) {
                        $modelDetail = new StockOpnameDetail;
                        $modelDetail->NoTransaksi = $NoTransaksi;
                        $modelDetail->KodeGudang = $jsonData['KodeGudang'];
                        $modelDetail->NoUrut = $key['NoUrut'];
                        $modelDetail->KodeItem = $key['KodeItem'];
                        $modelDetail->Qty = $key['Qty'];
                        $modelDetail->Stock = $key['Stock'];
                        $modelDetail->CreatedBy = Auth::user()->name;
                        $modelDetail->UpdatedBy = "";
                        $modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

                        $saveDetail = $modelDetail->save();
                        if (!$save) {
                            $data['message'] = "Gagal Menyimpan Data Detail di Row ".$key['NoUrut'];
                            $errorCount += 1;
                            goto jump;
                        }
                    }
                }
            }

            jump:
        } catch (\Exception $e) {
			Log::debug($e->getMessage());
	        $data['message'] = $e->getMessage();
		}

		return response()->json($data);
    }
}
