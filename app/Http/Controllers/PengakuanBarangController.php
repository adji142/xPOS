<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\Gudang;
use App\Models\DocumentNumbering;
use App\Models\PengakuanBarangHeader;
use App\Models\PengakuanBarangDetail;

class PengakuanBarangController extends Controller
{
    public function View(Request $request){
		$Status = $request->input('Status');

		return view("Transaksi.Inventory.PengakuanStock",[
			'oldStatus' => $Status, 
		]);
    }
    public function ViewHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
	   	$Status = $request->input('Status');

	   	$sql = "";

	   	$model = PengakuanBarangHeader::where('RecordOwnerID',Auth::user()->RecordOwnerID)
	   				->whereBetween('TglTransaksi', [$TglAwal, $TglAkhir]);
	   	if ($Status != "") {
	   		$model->where('Status', $Status);
	   	}

	   	$data['data']= $model->get();
	    return response()->json($data);
    }

    public function ViewDetail(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$NoTransaksi = $request->input('NoTransaksi');

    	$sql = "pengakuanbarangdetail.*, itemmaster.NamaItem";
    	$model = PengakuanBarangDetail::selectRaw($sql)
	    			->leftJoin('itemmaster', function ($value){
						$value->on('pengakuanbarangdetail.KodeItem','=','itemmaster.KodeItem')
						->on('pengakuanbarangdetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
    				->where('pengakuanbarangdetail.NoTransaksi', $NoTransaksi)
    				->where('pengakuanbarangdetail.RecordOwnerID',Auth::user()->RecordOwnerID);
    	$data['data']= $model->get();
	    return response()->json($data);
    }

    public function Form($NoTransaksi=NULL)
    {
    	$pengakuanheader = PengakuanBarangHeader::where('NoTransaksi', $NoTransaksi)
    						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
    	$pengakuandetail = PengakuanBarangDetail::where('NoTransaksi', $NoTransaksi)
    						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
    	$item = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
						->where('Active','Y')->get();
		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

    	return view("Transaksi.Inventory.PengakuanStock-Input",[
	        'item' => $item,
	        'pengakuanheader' => $pengakuanheader,
	        'pengakuandetail' => $pengakuandetail,
	        'satuan' => $satuan,
	        'gudang' => $gudang
	    ]);
    }

    public function storeJson(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	    Log::debug($request->all());
	    DB::beginTransaction();

	    $errorCount = 0;
	    $jsonData = $request->json()->all();

	    try {
	    	$currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

            $model = new PengakuanBarangHeader;
           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("GR","pengakuanbarangheader","NoTransaksi");

           	$model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;
	        $model->TglTransaksi = $jsonData['TglTransaksi'];
	        $model->NoReff = empty($jsonData['NoReff']) ? "" : $jsonData['NoReff'];
	        $model->Keterangan = empty($jsonData['Keterangan']) ? "" : $jsonData['Keterangan'];
	        $model->Status = $jsonData['Status'];
	        $model->TotalTransaksi = $jsonData['TotalTransaksi'];
	        $model->CreatedBy = Auth::user()->name;
	        $model->UpdatedBy = '';
	        $model->Posted = 0;
	        $model->RecordOwnerID = Auth::user()->RecordOwnerID;
	        $save = $model->save();

	        if (!$save) {
           		$data['message'] = "Gagal Menyimpan Data Pengakuan Barang";
           		$errorCount += 1;
           		goto jump;
           	}

           	if (count($jsonData['Detail']) == 0) {
           		$data['message'] = "Data Detail Item Harus diisi";
           		$errorCount += 1;
           		goto jump;
           	}

           	$NoUrut = 0;
           	foreach ($jsonData['Detail'] as $key) {
           		if ($key['Qty'] == 0) {
					$data['message'] = "Quantity Harus lebih dari 0";
					$errorCount += 1;
					goto jump;
				}

				$modelDetail = new PengakuanBarangDetail;
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $NoUrut;
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['Qty'];
				$modelDetail->Satuan = $key['Satuan'];
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->KodeGudang = $key['KodeGudang'];
				$modelDetail->TotalTransaksi = $key['Qty'] * $key['Harga'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				$save = $modelDetail->save();

				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}

				$NoUrut +=1;
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
    	Log::debug($request->all());
		DB::beginTransaction();

		$errorCount = 0;
		$jsonData = $request->json()->all();

		try {
			$model = PengakuanBarangHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	        if ($model) {
	        	$update = DB::table('pengakuanbarangheader')
	                       ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                       ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                       ->update(
	                           [
	                                'TglTransaksi' => $jsonData['TglTransaksi'],
									'TotalTransaksi' => $jsonData['TotalTransaksi'],
									'Status' => $jsonData['Status'],
									'Keterangan' => empty($jsonData['Keterangan']) ? "" : $jsonData['Keterangan'],
									'NoReff' => empty($jsonData['NoReff']) ? "" : $jsonData['NoReff'],
									'UpdatedBy' => Auth::user()->name
	                           ]
	                       );

	            if (count($jsonData['Detail']) == 0) {
	            	$data['message'] = "Data Detail Tidak boleh kosong";
	            	$errorCount +=1;
	            	goto jump;
	            }

	            // Delete Existing Data
				$delete = DB::table('pengakuanbarangdetail')
	                ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();
	            if ($delete) {
	            	$NoUrut = 0;
		           	foreach ($jsonData['Detail'] as $key) {
		           		if ($key['Qty'] == 0) {
							goto skip;
						}

						$modelDetail = new PengakuanBarangDetail;
						$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->NoUrut = $NoUrut;
						$modelDetail->KodeItem = $key['KodeItem'];
						$modelDetail->Qty = $key['Qty'];
						$modelDetail->Satuan = $key['Satuan'];
						$modelDetail->Harga = $key['Harga'];
						$modelDetail->TotalTransaksi = $key['Qty'] * $key['Harga'];
						$modelDetail->KodeGudang = $key['KodeGudang'];
						$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
						$save = $modelDetail->save();

						if (!$save) {
							$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
							$errorCount += 1;
							goto jump;
						}

						$NoUrut +=1;
						skip:
		           	}
	            }
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
}
