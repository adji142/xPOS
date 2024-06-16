<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\FakturPembelianHeader;
use App\Models\FakturPembelianDetail;
use App\Models\OrderPembelianHeader;
use App\Models\OrderPembelianDetail;
use App\Models\Supplier;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;
use App\Models\ReturPembelianHeader;
use App\Models\ReturPembelianDetail;
use App\Models\PembayaranHeader;
use App\Models\PembayaranDetail;

class ReturPembelianController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Pembelian.ReturPembelian",[
	    	'supplier' => $supplier->get(), 
	    ]);
    }

    public function ViewHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
	   	$KodeVendor = $request->input('KodeVendor');
	   	$Status = $request->input('Status');

	   	$sql = "DISTINCT returpembelianheader.NoTransaksi, returpembelianheader.TglTransaksi, returpembelianheader.KodeSupplier, returpembelianheader.NoReff, returpembelianheader.Keterangan, returpembeliandetail.BaseReff AS NoFaktur, returpembelianheader.Posted, supplier.NamaSupplier, returpembelianheader.TotalTransaksi, 
	   		CASE WHEN returpembelianheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN returpembelianheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN returpembelianheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument";
	   	$model = ReturPembelianHeader::selectRaw($sql)
	   				->leftJoin('returpembeliandetail', function ($value){
						$value->on('returpembeliandetail.NoTransaksi','=','returpembelianheader.NoTransaksi')
						->on('returpembeliandetail.RecordOwnerID','=','returpembelianheader.RecordOwnerID');
					})
					->leftJoin('supplier', function ($value){
						$value->on('returpembelianheader.KodeSupplier','=','supplier.KodeSupplier')
						->on('returpembelianheader.RecordOwnerID','=','supplier.RecordOwnerID');
					})
					->whereBetween('returpembelianheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('returpembelianheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodeVendor != "") {
    		$model->where("returpembelianheader.KodeSupplier", $KodeVendor);
    	}
    	if ($Status != "") {
    		$model->where("returpembelianheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$NoTransaksi = $request->input('NoTransaksi');

    	$sql = "returpembeliandetail.NoUrut, returpembeliandetail.KodeItem, itemmaster.NamaItem, returpembeliandetail.Qty, returpembeliandetail.Harga, returpembeliandetail.HargaNet, returpembeliandetail.KodeGudang, returpembeliandetail.Satuan, fakturpembeliandetail.Qty AS QtyFaktur";
    	$model = ReturPembelianDetail::selectRaw($sql)
    				->leftJoin('itemmaster', function ($value){
						$value->on('returpembeliandetail.KodeItem','=','itemmaster.KodeItem')
						->on('returpembeliandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoin('fakturpembeliandetail', function ($value){
						$value->on('fakturpembeliandetail.NoTransaksi','=','returpembeliandetail.BaseReff')
						->on('fakturpembeliandetail.NoUrut','=','returpembeliandetail.BaseLine')
						->on('fakturpembeliandetail.RecordOwnerID','=','returpembeliandetail.RecordOwnerID');
					})
					->where('returpembeliandetail.NoTransaksi',$NoTransaksi)
					->where('returpembeliandetail.RecordOwnerID',Auth::user()->RecordOwnerID);

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
		$orderheader = OrderPembelianHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$orderdetail = OrderPembelianDetail::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$fakturheader = FakturPembelianHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = FakturPembelianDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "fakturpembeliandetail.*, fakturpembeliandetail.Qty AS QtyFaktur, orderpembeliandetail.Qty AS QtyOrder";
		$fakturdetail = FakturPembelianDetail::selectRaw($sql)
						->leftJoin('orderpembeliandetail', function ($value){
							$value->on('orderpembeliandetail.NoTransaksi','=','fakturpembeliandetail.BaseReff')
							->on('orderpembeliandetail.NoUrut','=','fakturpembeliandetail.BaseLine')
							->on('orderpembeliandetail.RecordOwnerID','=','fakturpembeliandetail.RecordOwnerID');
						})
						->where('fakturpembeliandetail.NoTransaksi',$NoTransaksi)
						->where('fakturpembeliandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

		$returheader = ReturPembelianHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
						->where('NoTransaksi','=', $NoTransaksi)->get();
		$returdetail = ReturPembelianDetail::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
						->where('NoTransaksi','=', $NoTransaksi)->get();

	    return view("Transaksi.Pembelian.ReturPembelian-Input2",[
	        'supplier' => $supplier,
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
			if ($jsonData['KodeSupplier'] == "") {
				$data['message'] = "Supplier Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}

			$currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("RTB","returpembelianheader","NoTransaksi");

	        $model = new ReturPembelianHeader;

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

				if ($key['KodeGudang'] == "") {
					$data['message'] = "Gudang Penerima tidak boleh kosong";
					$errorCount +=1;
					goto jump;
				}

				$Pembayaran = PembayaranDetail::selectRaw("pembayarandetail.*")
								->leftJoin('pembayaranheader', function ($value){
									$value->on('pembayaranheader.NoTransaksi','=','pembayarandetail.NoTransaksi')
									->on('pembayaranheader.RecordOwnerID','=','pembayarandetail.RecordOwnerID');
								})
								->Where('pembayarandetail.RecordOwnerID','=', Auth::user()->RecordOwnerID)
								->where('pembayarandetail.BaseReff','=', $key['BaseReff'])
								->where('pembayaranheader.Status','<>', 'D')
								->get();
				if (count($Pembayaran) > 0) {
					$data['message'] = "Dokumen Tidak Bisa Diretur, karena sudah dibayar atau Periode Sudah Di Close.";
					$errorCount += 1;
					goto jump;
				}


				$modelDetail = new ReturPembelianDetail;
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
			$model = ReturPembelianHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	        if ($model) {
	        	$update = DB::table('returpembelianheader')
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
				$delete = DB::table('returpembeliandetail')
	                ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	            if ($delete) {
	            	$NoUrut = 0 ;
	            	foreach ($jsonData['Detail'] as $key) {
		            	if ($key['Qty'] == 0) {
							goto skip;
						}

						$modelDetail = new ReturPembelianDetail;
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
