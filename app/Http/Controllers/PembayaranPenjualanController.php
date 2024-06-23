<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DocumentNumbering;
use App\Models\PembayaranPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\Pelanggan;
use App\Models\MetodePembayaran;

class PembayaranPenjualanController extends Controller
{
    public function View(Request $request){
		$keyword = $request->input('keyword');
		$pelanggan = Pelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

		return view("Transaksi.Penjualan.PembayaranPenjualan",[
			'pelanggan' => $pelanggan->get(), 
		]);
	}

	public function ViewHeader(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$TglAwal = $request->input('TglAwal');
   		$TglAkhir = $request->input('TglAkhir');
   		$KodeVendor = $request->input('KodeVendor');

   		$sql = "pembayaranpenjualanheader.*, pelanggan.NamaPelanggan, 
   				CASE WHEN pembayaranpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
	   				CASE WHEN pembayaranpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE 
	   					CASE WHEN pembayaranpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE '' END
	   				END
	   			END AS StatusDocument";
   		$model = PembayaranPenjualanHeader::selectRaw($sql)
   					->leftJoin('pelanggan', function ($value){
    					$value->on('pembayaranpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
    					->on('pelanggan.RecordOwnerID','=','pembayaranpenjualanheader.RecordOwnerID');
    				})
    				->whereBetween('pembayaranpenjualanheader.TglTransaksi',[$TglAwal, $TglAkhir])
        			->where('pembayaranpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID);
        if ($KodeVendor != "") {
    		$model->where("pembayaranpenjualanheader.KodePelanggan", $KodeVendor);
    	}
    	$data['data']= $model->get();
	    return response()->json($data);
	}

	public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$NoTransaksi = $request->input('NoTransaksi');

   		$sql = "pembayaranpenjualandetail.*, fakturpenjualanheader.TglTransaksi AS TglFaktur, fakturpenjualanheader.TotalPembelian, metodepembayaran.NamaMetodePembayaran";
   		$model = PembayaranPenjualanDetail::selectRaw($sql)
   					->leftJoin('fakturpenjualanheader', function ($value){
    					$value->on('fakturpenjualanheader.NoTransaksi','=','pembayaranpenjualandetail.BaseReff')
    					->on('fakturpenjualanheader.RecordOwnerID','=','pembayaranpenjualandetail.RecordOwnerID');
    				})
    				->leftJoin('metodepembayaran', function ($value){
    					$value->on('metodepembayaran.id','=','pembayaranpenjualandetail.KodeMetodePembayaran')
    					->on('metodepembayaran.RecordOwnerID','=','pembayaranpenjualandetail.RecordOwnerID');
    				})
    				->where('pembayaranpenjualandetail.NoTransaksi','=', $NoTransaksi);
    	$data['data']= $model->get();
	    return response()->json($data);
	}

	public function Form($NoTransaksi = null)
	   {
			$pelanggan = Pelanggan::where('Status', 1)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$pembayaranpenjualanheader = PembayaranPenjualanHeader::where('NoTransaksi', $NoTransaksi)
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

			$sql = "pembayaranpenjualandetail.*, fakturpenjualanheader.TglTransaksi, fakturpenjualanheader.TotalPembelian";
			$pembayaranpenjualandetail = PembayaranPenjualanDetail::selectRaw($sql)
								->leftJoin('fakturpenjualanheader', function ($value){
			    					$value->on('fakturpenjualanheader.NoTransaksi','=','pembayaranpenjualandetail.BaseReff')
			    					->on('fakturpenjualanheader.RecordOwnerID','=','pembayaranpenjualandetail.RecordOwnerID');
			    				})
								->where('pembayaranpenjualandetail.NoTransaksi', $NoTransaksi)
								->where('pembayaranpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$metodepembayaran = MetodePembayaran::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		    return view("Transaksi.Penjualan.PembayaranPenjualan-Input",[
		        'pelanggan' => $pelanggan,
		        'pembayaranpenjualanheader' => $pembayaranpenjualanheader,
		        'pembayaranpenjualandetail' => $pembayaranpenjualandetail,
		        'metodepembayaran' => $metodepembayaran
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

			$model = new PembayaranPenjualanHeader;
	           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("OUTPAY","pembayaranpenjualanheader","NoTransaksi");

           	$model->Periode = $Year.$Month;
			$model->NoTransaksi = $NoTransaksi;
			$model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
			$model->TotalPembelian = $jsonData['TotalPembelian'];
			$model->TotalPembayaran = $jsonData['TotalPembayaran'];
			$model->KodeMetodePembayaran = $jsonData['KodeMetodePembayaran'];
			$model->NoReff = $jsonData['NoReff'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->RecordOwnerID = Auth::user()->RecordOwnerID;
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";
			$model->Posted = 0;
			$model->Status = $jsonData['Status'];

			$save = $model->save();

			if (!$save) {
           		$data['message'] = "Gagal Menyimpan Data Pembayaran Pembelian";
           		$errorCount += 1;
           		goto jump;
			}

			if (count($jsonData['Detail']) == 0) {
           		$data['message'] = "Data Faktur Pembelian Harus diisi";
           		$errorCount += 1;
           		goto jump;
			}
			$NoUrut = 0;
			foreach ($jsonData['Detail'] as $key) {
				if ($key['TotalPembayaran'] == 0) {
					goto skip;
				}

				if ($key['TotalPembayaran'] > $key['TotalPiutang']) {
					$data['message'] = "Nomor Faktur "+ $key['NoTransaksi'] +" Total Pembayaran Melebihi Nilai Hutang";
	           		$errorCount += 1;
	           		goto jump;
				}

				$modelDetail = new PembayaranPenjualanDetail;
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $NoUrut;
				$modelDetail->BaseReff = $key['NoTransaksi'];
				$modelDetail->TotalPembayaran = $key['TotalPembayaran'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
				$modelDetail->KodeMetodePembayaran = $key['KodeMetodePembayaran'];
				$modelDetail->Keterangan = $key['Keterangan'];

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

	public function editJson(Request $request)
	{
		Log::debug($request->all());
		DB::beginTransaction();

		$errorCount = 0;
		$jsonData = $request->json()->all();

		try {
			$model = PembayaranPenjualanHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	        if ($model) {
	        	$update = DB::table('pembayaranpenjualanheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                           ->update(
                               [
                                    'TglTransaksi' => $jsonData['TglTransaksi'],
									'KodePelanggan' => $jsonData['KodePelanggan'],
									'TotalPembelian' => $jsonData['TotalPembelian'],
									'TotalPembayaran' => $jsonData['TotalPembayaran'],
									'KodeMetodePembayaran' => $jsonData['KodeMetodePembayaran'],
									'NoReff' => $jsonData['NoReff'],
									'Keterangan' => $jsonData['Keterangan'],
									'Status' => $jsonData['Status'],
									'UpdatedBy' => Auth::user()->name
                               ]
                           );
                // var_dump(count($jsonData['Detail']));
                if (count($jsonData['Detail']) == 0) {
	           		$data['message'] = "Data Faktur Pembelian Harus diisi";
	           		$errorCount += 1;
	           		goto jump;
				}

				$NoUrut = 0;
                foreach ($jsonData['Detail'] as $key) {
                	if ($key['TotalPembayaran'] == 0) {
						goto skip;
					}

					$checkExists = PembayaranPenjualanDetail::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           							->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
           							->where('BaseReff','=', $key['NoTransaksi']);
           			if ($checkExists) {
           				$update = DB::table('pembayaranpenjualandetail')
	                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                           ->where('BaseReff','=', $key['NoTransaksi'])
	                           ->update(
									[
										'TotalPembayaran' => $key['TotalPembayaran'],
										'KodeMetodePembayaran' => $key['KodeMetodePembayaran'],
										'Keterangan' => $key['Keterangan'],
									]
	                           );
           			}
           			else{
           				$NoUrut = 

           				$modelDetail = new PembayaranPenjualanDetail;
						$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->NoUrut = PembayaranPenjualanDetail::max('NoUrut') + 1;
						$modelDetail->BaseReff = $key['NoTransaksi'];
						$modelDetail->TotalPembayaran = $key['TotalPembayaran'];
						$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
						$modelDetail->KodeMetodePembayaran = $key['KodeMetodePembayaran'];
						$modelDetail->Keterangan = $key['Keterangan'];

						$save = $modelDetail->save();

						if (!$save) {
							$data['message'] = "Gagal Menambah Data Detail di Row ".$key->NoUrut;
							$errorCount += 1;
							goto jump;
						}
           			}
           			skip:
                }

                // if (!$update) {
                // 	$data['message'] = 'Edit Models Gagal';
                // 	$errorCount +=1;
                // }

	        }
	        else{
	        	$data['message'] = 'Data Pembayaran Tidak Valid';
               	$errorCount +=1;
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
