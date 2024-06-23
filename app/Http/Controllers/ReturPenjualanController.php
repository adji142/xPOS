<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\OrderPenjualanHeader;
use App\Models\OrderPenjualanDetail;
use App\Models\Pelanggan;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;
use App\Models\ReturPenjualanHeader;
use App\Models\ReturPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\PembayaranPenjualanDetail;

class ReturPenjualanController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $pelanggan = Pelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Penjualan.ReturPenjualan",[
	    	'pelanggan' => $pelanggan->get(), 
	    ]);
    }

    public function ViewHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
	   	$KodeVendor = $request->input('KodeVendor');
	   	$Status = $request->input('Status');

	   	$sql = "DISTINCT returpenjualanheader.NoTransaksi, returpenjualanheader.TglTransaksi, returpenjualanheader.KodePelanggan, returpenjualanheader.NoReff, returpenjualanheader.Keterangan, returpenjualandetail.BaseReff AS NoFaktur, returpenjualanheader.Posted, pelanggan.NamaPelanggan, returpenjualanheader.TotalTransaksi, 
	   		CASE WHEN returpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN returpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN returpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument";
	   	$model = ReturPenjualanHeader::selectRaw($sql)
	   				->leftJoin('returpenjualandetail', function ($value){
						$value->on('returpenjualandetail.NoTransaksi','=','returpenjualanheader.NoTransaksi')
						->on('returpenjualandetail.RecordOwnerID','=','returpenjualanheader.RecordOwnerID');
					})
					->leftJoin('pelanggan', function ($value){
						$value->on('returpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
						->on('returpenjualanheader.RecordOwnerID','=','pelanggan.RecordOwnerID');
					})
					->whereBetween('returpenjualanheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('returpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodeVendor != "") {
    		$model->where("returpenjualanheader.KodePelanggan", $KodeVendor);
    	}
    	if ($Status != "") {
    		$model->where("returpenjualanheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$NoTransaksi = $request->input('NoTransaksi');

    	$sql = "returpenjualandetail.NoUrut, returpenjualandetail.KodeItem, itemmaster.NamaItem, returpenjualandetail.Qty, returpenjualandetail.Harga, returpenjualandetail.HargaNet, returpenjualandetail.KodeGudang, returpenjualandetail.Satuan, fakturpenjualandetail.Qty AS QtyFaktur";
    	$model = ReturPenjualanDetail::selectRaw($sql)
    				->leftJoin('itemmaster', function ($value){
						$value->on('returpenjualandetail.KodeItem','=','itemmaster.KodeItem')
						->on('returpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoin('fakturpenjualandetail', function ($value){
						$value->on('fakturpenjualandetail.NoTransaksi','=','returpenjualandetail.BaseReff')
						->on('fakturpenjualandetail.NoUrut','=','returpenjualandetail.BaseLine')
						->on('fakturpenjualandetail.RecordOwnerID','=','returpenjualandetail.RecordOwnerID');
					})
					->where('returpenjualandetail.NoTransaksi',$NoTransaksi)
					->where('returpenjualandetail.RecordOwnerID',Auth::user()->RecordOwnerID);

	    $data['data']= $model->get();
	    return response()->json($data);
    }

    public function Form($NoTransaksi = null)
	{
		$pelanggan = Pelanggan::where('Status', 1)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();    
		$termin = Termin::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$item = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
					->where('Active','Y')->get();
		$orderheader = OrderPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$orderdetail = OrderPenjualanDetail::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$fakturheader = FakturPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = FakturPenjualanDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "fakturpenjualandetail.*, fakturpenjualandetail.Qty AS QtyFaktur, orderpenjualandetail.Qty AS QtyOrder";
		$fakturdetail = FakturPenjualanDetail::selectRaw($sql)
						->leftJoin('orderpenjualandetail', function ($value){
							$value->on('orderpenjualandetail.NoTransaksi','=','fakturpenjualandetail.BaseReff')
							->on('orderpenjualandetail.NoUrut','=','fakturpenjualandetail.BaseLine')
							->on('orderpenjualandetail.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
						})
						->where('fakturpenjualandetail.NoTransaksi',$NoTransaksi)
						->where('fakturpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

		$returheader = ReturPenjualanHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
						->where('NoTransaksi','=', $NoTransaksi)->get();
		$returdetail = ReturPenjualanDetail::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
						->where('NoTransaksi','=', $NoTransaksi)->get();

	    return view("Transaksi.Penjualan.ReturPenjualan-Input",[
	        'pelanggan' => $pelanggan,
	        'termin' => $termin,
	        'item' => $item,
	        'fakturheader' => $fakturheader,
	        'fakturdetail' => $fakturdetail,
	        'satuan' => $satuan,
	        'gudang' => $gudang,
	        'returheader' => $returheader,
	        'returdetail' => $returdetail
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
			if ($jsonData['KodePelanggan'] == "") {
				$data['message'] = "Pelanggan Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}

			$currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("RPJ","returpenjualanheader","NoTransaksi");

	        $model = new ReturPenjualanHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;

	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
			$model->TotalTransaksi = $jsonData['TotalTransaksi'];
			$model->Status = $jsonData['Status'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->Posted = 0;
			$model->RecordOwnerID = Auth::user()->RecordOwnerID;
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";

			$save = $model->save();

			if (count($jsonData['Detail']) == 0) {
				$data['message'] = "Data Detail Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}


			$NoUrut = 0 ;
			foreach ($jsonData['Detail'] as $key) {
				if ($key['Qty'] == 0) {
					goto skip;
				}

				$Pembayaran = PembayaranPenjualanDetail::selectRaw("pembayaranpenjualandetail.*")
								->leftJoin('pembayaranpenjualanheader', function ($value){
									$value->on('pembayaranpenjualanheader.NoTransaksi','=','pembayaranpenjualandetail.NoTransaksi')
									->on('pembayaranpenjualanheader.RecordOwnerID','=','pembayaranpenjualandetail.RecordOwnerID');
								})
								->Where('pembayaranpenjualandetail.RecordOwnerID','=', Auth::user()->RecordOwnerID)
								->where('pembayaranpenjualandetail.BaseReff','=', $key['BaseReff'])
								->where('pembayaranpenjualanheader.Status','<>', 'D')
								->get();
				if (count($Pembayaran) > 0) {
					$data['message'] = "Dokumen Tidak Bisa Diretur, karena sudah dibayar atau Periode Sudah Di Close.";
					$errorCount += 1;
					goto jump;
				}


				$modelDetail = new ReturPenjualanDetail;
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->BaseReff = $key['BaseReff'];
				$modelDetail->NoUrut = $NoUrut;
				$modelDetail->BaseType = $key['BaseType'];
				$modelDetail->BaseLine = $key['BaseLine'];
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['Qty'];
				$modelDetail->Satuan = $key['Satuan'];
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
				$modelDetail->LineStatus = $key['LineStatus'];
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
			$model = ReturPenjualanHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	        if ($model) {
	        	$update = DB::table('returpenjualanheader')
	                       ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                       ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                       ->update(
	                           [
	                                'TglTransaksi' => $jsonData['TglTransaksi'],
									'KodePelanggan' => $jsonData['KodePelanggan'],
									'TotalTransaksi' => $jsonData['TotalTransaksi'],
									'Status' => $jsonData['Status'],
									'Keterangan' => $jsonData['Keterangan'],
									'NoReff' => $jsonData['NoReff'],
									'UpdatedBy' => Auth::user()->name
	                           ]
	                       );

	            if (count($jsonData['Detail']) == 0) {
	            	$data['message'] = "Data Detail Tidak boleh kosong";
	            	$errorCount +=1;
	            	goto jump;
	            }

	            // Delete Existing Data
				$delete = DB::table('returpenjualandetail')
	                ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	            if ($delete) {
	            	$NoUrut = 0 ;
	            	foreach ($jsonData['Detail'] as $key) {
		            	if ($key['Qty'] == 0) {
							goto skip;
						}

						$modelDetail = new ReturPenjualanDetail;
						$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->BaseReff = $key['BaseReff'];
						$modelDetail->NoUrut = $NoUrut;
						$modelDetail->BaseLine = $key['BaseLine'];
						$modelDetail->KodeItem = $key['KodeItem'];
						$modelDetail->Qty = $key['Qty'];
						$modelDetail->Satuan = $key['Satuan'];
						$modelDetail->Harga = $key['Harga'];
						$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
						$modelDetail->LineStatus = $key['LineStatus'];
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
