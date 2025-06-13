<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\PenerimaanKonsinyasiHeader;
use App\Models\PenerimaanKonsinyasiDetail;
use App\Models\Supplier;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\ReturKonsinyasiHeader;
use App\Models\ReturKonsinyasiDetail;
use App\Models\PembayaranKonsinyasiHeader;
use App\Models\PembayaranKonsinyasiDetail;

use App\Models\AutoPosting;
use App\Models\SettingAccount;
use App\Models\Rekening;

class ReturKonsinyasiController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Pembelian.ReturKonsinyasi",[
	    	'supplier' => $supplier->get(), 
	    ]);
    }

    public function ViewHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
	   	$KodeVendor = $request->input('KodeVendor');
	   	$Status = $request->input('Status');

	   	$sql = "DISTINCT returkonsinyasiheader.NoTransaksi, returkonsinyasiheader.TglTransaksi, returkonsinyasiheader.KodeSupplier, returkonsinyasiheader.NoReff, returkonsinyasiheader.Keterangan, returkonsinyasidetail.BaseReff AS NoFaktur, returkonsinyasiheader.Posted, supplier.NamaSupplier, returkonsinyasiheader.TotalTransaksi, 
	   		CASE WHEN returkonsinyasiheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN returkonsinyasiheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN returkonsinyasiheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument";
	   	$model = ReturKonsinyasiHeader::selectRaw($sql)
	   				->leftJoin('returkonsinyasidetail', function ($value){
						$value->on('returkonsinyasidetail.NoTransaksi','=','returkonsinyasiheader.NoTransaksi')
						->on('returkonsinyasidetail.RecordOwnerID','=','returkonsinyasiheader.RecordOwnerID');
					})
					->leftJoin('supplier', function ($value){
						$value->on('returkonsinyasiheader.KodeSupplier','=','supplier.KodeSupplier')
						->on('returkonsinyasiheader.RecordOwnerID','=','supplier.RecordOwnerID');
					})
					->whereBetween('returkonsinyasiheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('returkonsinyasiheader.RecordOwnerID',Auth::user()->RecordOwnerID);
		
		$model->where("returkonsinyasiheader.Status", '<>' ,'D');

    	if ($KodeVendor != "") {
    		$model->where("returkonsinyasiheader.KodeSupplier", $KodeVendor);
    	}
    	if ($Status != "") {
    		$model->where("returkonsinyasiheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$NoTransaksi = $request->input('NoTransaksi');

    	$sql = "returkonsinyasidetail.NoUrut, returkonsinyasidetail.KodeItem, itemmaster.NamaItem, returkonsinyasidetail.Qty, returkonsinyasidetail.Harga, returkonsinyasidetail.HargaNet, returkonsinyasidetail.KodeGudang, returkonsinyasidetail.Satuan, penerimaankonsinyasidetail.Qty AS QtyFaktur";
    	$model = ReturKonsinyasiDetail::selectRaw($sql)
    				->leftJoin('itemmaster', function ($value){
						$value->on('returkonsinyasidetail.KodeItem','=','itemmaster.KodeItem')
						->on('returkonsinyasidetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoin('penerimaankonsinyasidetail', function ($value){
						$value->on('penerimaankonsinyasidetail.NoTransaksi','=','returkonsinyasidetail.BaseReff')
						->on('penerimaankonsinyasidetail.NoUrut','=','returkonsinyasidetail.BaseLine')
						->on('penerimaankonsinyasidetail.RecordOwnerID','=','returkonsinyasidetail.RecordOwnerID');
					})
					->where('returkonsinyasidetail.NoTransaksi',$NoTransaksi)
					->where('returkonsinyasidetail.RecordOwnerID',Auth::user()->RecordOwnerID);

	    $data['data']= $model->get();
	    return response()->json($data);
    }

    public function Form($NoTransaksi = null)
	{
		$supplier = Supplier::where('Status', 1)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();    
		$termin = Termin::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$item = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
					->where('Active','Y')->get();

		$konsinyasiheader = PenerimaanKonsinyasiHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = FakturPembelianDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "penerimaankonsinyasidetail.*";
		$konsinyasidetail = PenerimaanKonsinyasiDetail::where('penerimaankonsinyasidetail.NoTransaksi',$NoTransaksi)
						->where('penerimaankonsinyasidetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

		$returheader = ReturKonsinyasiHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
						->where('NoTransaksi','=', $NoTransaksi)->get();
		$returdetail = ReturKonsinyasiDetail::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
						->where('NoTransaksi','=', $NoTransaksi)->get();

	    return view("Transaksi.Pembelian.ReturKonsinyasi-Input",[
	        'supplier' => $supplier,
	        'termin' => $termin,
	        'item' => $item,
	        'konsinyasiheader' => $konsinyasiheader,
	        'konsinyasidetail' => $konsinyasidetail,
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
			if ($jsonData['KodeSupplier'] == "") {
				$data['message'] = "Supplier Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}

			$currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("RTB","returkonsinyasiheader","NoTransaksi");

	        $model = new ReturKonsinyasiHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;

	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodeSupplier = $jsonData['KodeSupplier'];
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

				$Pembayaran = PembayaranKonsinyasiDetail::selectRaw("pembayarankonsinyasidetail.*")
								->leftJoin('pembayarankonsinyasiheader', function ($value){
									$value->on('pembayarankonsinyasiheader.NoTransaksi','=','pembayarankonsinyasidetail.NoTransaksi')
									->on('pembayarankonsinyasiheader.RecordOwnerID','=','pembayarankonsinyasidetail.RecordOwnerID');
								})
								->Where('pembayarankonsinyasidetail.RecordOwnerID','=', Auth::user()->RecordOwnerID)
								->where('pembayarankonsinyasidetail.BaseReff','=', $key['BaseReff'])
								->where('pembayarankonsinyasiheader.Status','<>', 'D')
								->get();
				if (count($Pembayaran) > 0) {
					$data['message'] = "Dokumen Tidak Bisa Diretur, karena sudah dibayar atau Periode Sudah Di Close.";
					$errorCount += 1;
					goto jump;
				}


				$modelDetail = new ReturKonsinyasiDetail;
				$modelDetail->NoTransaksi = $NoTransaksi;
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
				$modelDetail->VatPercent = $key['VatPercent'];
				$modelDetail->HargaPokokPenjualan = $key['HargaPokokPenjualan'];
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

			// Auto Journal

			// Generate Header :
			$arrHeader = array(
				'NoTransaksi' => "",
				'KodeTransaksi' => "RTC",
				'TglTransaksi' => $jsonData['TglTransaksi'],
				'NoReff' => $NoTransaksi,
				'StatusTransaksi' => "O",
				'RecordOwnerID' => Auth::user()->RecordOwnerID,
			);
			$arrDetail = array();

			// GetAccount :
			$Setting = NEW SettingAccount();
			$getSetting = $Setting->GetSetting("KnAcctPenerimaanKonsinyasi");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				$data['message'] = "Akun Rekening Akutansi Penerimaan Konsinyasi Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
				$errorCount +=1;
				goto jump;
			}

			// Hutang

			$temp = array(
				'KodeTransaksi' => "RTC", 
				'KodeRekening' => $getSetting,
				'KodeRekeningBukuBesar' => "",
				'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
				'KodeMataUang' => "",
				'Valas' => 0,
				'NilaiTukar' => 0,
				'Jumlah' => $jsonData['TotalTransaksi'], 
				'Keterangan' => $jsonData['Keterangan'], 
				'HeaderKas' => "",
				'RecordOwnerID' =>  Auth::user()->RecordOwnerID
			);

			array_push($arrDetail, $temp);
			// End Hutang

			// Inventory
			// GetAccount :
			$Setting = NEW SettingAccount();
			$getSetting = $Setting->GetSetting("InvAcctPersediaan");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				$data['message'] = "Akun Rekening Akutansi Inventory Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
				$errorCount +=1;
				goto jump;
			}
			$temp = array(
				'KodeTransaksi' => "RTC", 
				'KodeRekening' => $getSetting,
				'KodeRekeningBukuBesar' => "",
				'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
				'KodeMataUang' => "",
				'Valas' => 0,
				'NilaiTukar' => 0,
				'Jumlah' => $jsonData['TotalTransaksi'], 
				'Keterangan' => $jsonData['Keterangan'], 
				'HeaderKas' => "",
				'RecordOwnerID' =>  Auth::user()->RecordOwnerID
			);

			array_push($arrDetail, $temp);
			// End Inventory

			// Save Journal
			$autoPosting = new AutoPosting();

			if ($autoPosting->Auto($arrHeader, $arrDetail,($jsonData['Status']== "D") ? true : false) != "OK") {
				$data["message"] = "Gagal Simpan Jurnal";
				$errorCount +=1;
				goto jump;
			}
			// End Save Jurnal

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
			$model = ReturKonsinyasiHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	        if ($model) {
	        	$update = DB::table('returkonsinyasiheader')
	                       ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                       ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                       ->update(
	                           [
	                                'TglTransaksi' => $jsonData['TglTransaksi'],
									'KodeSupplier' => $jsonData['KodeSupplier'],
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
				$delete = DB::table('returkonsinyasidetail')
	                ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	            if ($delete) {
	            	$NoUrut = 0 ;
	            	foreach ($jsonData['Detail'] as $key) {
		            	if ($key['Qty'] == 0) {
							goto skip;
						}

						$modelDetail = new ReturKonsinyasiDetail;
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
						$modelDetail->VatPercent = $key['VatPercent'];
						$modelDetail->HargaPokokPenjualan = $key['HargaPokokPenjualan'];

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

					// Auto Journal

					// Generate Header :
					$arrHeader = array(
						'NoTransaksi' => "",
						'KodeTransaksi' => "RTC",
						'TglTransaksi' => $jsonData['TglTransaksi'],
						'NoReff' => $jsonData['NoTransaksi'],
						'StatusTransaksi' => "O",
						'RecordOwnerID' => Auth::user()->RecordOwnerID,
					);
					$arrDetail = array();

					// GetAccount :
					$Setting = NEW SettingAccount();
					$getSetting = $Setting->GetSetting("KnAcctPenerimaanKonsinyasi");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Penerimaan Konsinyasi Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					// Hutang

					$temp = array(
						'KodeTransaksi' => "RTC", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $jsonData['TotalTransaksi'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End Hutang

					// Inventory
					// GetAccount :
					$Setting = NEW SettingAccount();
					$getSetting = $Setting->GetSetting("InvAcctPersediaan");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Inventory Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}
					$temp = array(
						'KodeTransaksi' => "RTC", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $jsonData['TotalTransaksi'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End Inventory

					// Save Journal
					$autoPosting = new AutoPosting();

					if ($autoPosting->Auto($arrHeader, $arrDetail,($jsonData['Status']== "D") ? true : false) != "OK") {
						$data["message"] = "Gagal Simpan Jurnal";
						$errorCount +=1;
						goto jump;
					}
					// End Save Jurnal

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
