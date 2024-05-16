<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DocumentNumbering;
use App\Models\PembayaranHeader;
use App\Models\PembayaranDetail;
use App\Models\Supplier;
use App\Models\MetodePembayaran;

class PembayaranController extends Controller
{
	public function View(Request $request){
		$keyword = $request->input('keyword');
		$supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

		return view("Transaksi.Pembelian.PembayaranPembelian",[
			'supplier' => $supplier->get(), 
		]);
	}

	public function ViewHeader(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$TglAwal = $request->input('TglAwal');
   		$TglAkhir = $request->input('TglAkhir');
   		$KodeVendor = $request->input('KodeVendor');

   		$sql = "pembayaranheader.*, supplier.NamaSupplier, 
   				CASE WHEN pembayaranheader.Status = 'O' THEN 'OPEN' ELSE 
	   				CASE WHEN pembayaranheader.Status = 'C' THEN 'CLOSE' ELSE 
	   					CASE WHEN pembayaranheader.Status = 'D' THEN 'CANCEL' ELSE '' END
	   				END
	   			END AS StatusDocument";
   		$model = PembayaranHeader::selectRaw($sql)
   					->leftJoin('supplier', function ($value){
    					$value->on('pembayaranheader.KodeSupplier','=','supplier.KodeSupplier')
    					->on('supplier.RecordOwnerID','=','pembayaranheader.RecordOwnerID');
    				})
    				->whereBetween('pembayaranheader.TglTransaksi',[$TglAwal, $TglAkhir])
        			->where('pembayaranheader.RecordOwnerID',Auth::user()->RecordOwnerID);
        if ($KodeVendor != "") {
    		$model->where("pembayaranheader.KodeSupplier", $KodeVendor);
    	}
    	$data['data']= $model->get();
	    return response()->json($data);
	}

	public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$NoTransaksi = $request->input('NoTransaksi');

   		$sql = "pembayarandetail.*, fakturpembelianheader.TglTransaksi AS TglFaktur, fakturpembelianheader.TotalPembelian, metodepembayaran.NamaMetodePembayaran";
   		$model = PembayaranDetail::selectRaw($sql)
   					->leftJoin('fakturpembelianheader', function ($value){
    					$value->on('fakturpembelianheader.NoTransaksi','=','pembayarandetail.BaseReff')
    					->on('fakturpembelianheader.RecordOwnerID','=','pembayarandetail.RecordOwnerID');
    				})
    				->leftJoin('metodepembayaran', function ($value){
    					$value->on('metodepembayaran.id','=','pembayarandetail.KodeMetodePembayaran')
    					->on('metodepembayaran.RecordOwnerID','=','pembayarandetail.RecordOwnerID');
    				})
    				->where('pembayarandetail.NoTransaksi','=', $NoTransaksi);
    	$data['data']= $model->get();
	    return response()->json($data);
	}

	public function Form($NoTransaksi = null)
	   {
			$supplier = Supplier::where('Status', 1)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$pembayaranheader = PembayaranHeader::where('NoTransaksi', $NoTransaksi)
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

			$sql = "pembayarandetail.*, fakturpembelianheader.TglTransaksi, fakturpembelianheader.TotalPembelian";
			$pembayarandetail = PembayaranDetail::selectRaw($sql)
								->leftJoin('fakturpembelianheader', function ($value){
			    					$value->on('fakturpembelianheader.NoTransaksi','=','pembayarandetail.BaseReff')
			    					->on('fakturpembelianheader.RecordOwnerID','=','pembayarandetail.RecordOwnerID');
			    				})
								->where('pembayarandetail.NoTransaksi', $NoTransaksi)
								->where('pembayarandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$metodepembayaran = MetodePembayaran::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		    return view("Transaksi.Pembelian.PembayaranPembelian-Input",[
		        'supplier' => $supplier,
		        'pembayaranheader' => $pembayaranheader,
		        'pembayarandetail' => $pembayarandetail,
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

			$model = new PembayaranHeader;
	           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("OUTPAY","pembayaranheader","NoTransaksi");

           	$model->Periode = $Year.$Month;
			$model->NoTransaksi = $NoTransaksi;
			$model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->KodeSupplier = $jsonData['KodeSupplier'];
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

				$modelDetail = new PembayaranDetail;
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
			$model = PembayaranHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	        if ($model) {
	        	$update = DB::table('pembayaranheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                           ->update(
                               [
                                    'TglTransaksi' => $jsonData['TglTransaksi'],
									'KodeSupplier' => $jsonData['KodeSupplier'],
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

					$checkExists = PembayaranDetail::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           							->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
           							->where('BaseReff','=', $key['NoTransaksi']);
           			if ($checkExists) {
           				$update = DB::table('pembayarandetail')
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

           				$modelDetail = new PembayaranDetail;
						$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->NoUrut = PembayaranDetail::max('NoUrut') + 1;
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
