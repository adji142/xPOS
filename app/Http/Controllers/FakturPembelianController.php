<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\OrderPembelianHeader;
use App\Models\OrderPembelianDetail;
use App\Models\FakturPembelianHeader;
use App\Models\FakturPembelianDetail;
use App\Models\Supplier;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;

class FakturPembelianController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Pembelian.FakturPembelian",[
	    	'supplier' => $supplier->get(), 
	    ]);
    }

    public function ViewHeader(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
	   	$KodeVendor = $request->input('KodeVendor');
	   	$Status = $request->input('Status');

	   	$sql = "DISTINCT fakturpembelianheader.NoTransaksi, fakturpembelianheader.TglTransaksi,fakturpembelianheader.TglJatuhTempo, fakturpembelianheader.NoReff, fakturpembelianheader.KodeSupplier, supplier.NamaSupplier, fakturpembelianheader.Termin, terminpembayaran.NamaTermin, fakturpembelianheader.TotalPembelian, fakturpembelianheader.TotalPembayaran, fakturpembelianheader.TotalPembelian - COALESCE(fakturpembelianheader.TotalPembayaran,0) - fakturpembelianheader.TotalRetur TotalHutang, COALESCE(orderpembelianheader.NoTransaksi, '') AS NoOrder, orderpembelianheader.TglTransaksi TglOrder, fakturpembelianheader.TotalRetur,
	   		CASE WHEN fakturpembelianheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN fakturpembelianheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN fakturpembelianheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument ";
	   	$model = FakturPembelianHeader::selectRaw($sql)
    				->leftJoin('terminpembayaran', function ($value){
    					$value->on('fakturpembelianheader.KodeTermin','=','terminpembayaran.id')
    					->on('terminpembayaran.RecordOwnerID','=','fakturpembelianheader.RecordOwnerID');
    				})
    				->leftJoin('supplier', function ($value){
    					$value->on('fakturpembelianheader.KodeSupplier','=','supplier.KodeSupplier')
    					->on('supplier.RecordOwnerID','=','fakturpembelianheader.RecordOwnerID');
    				})
    				->leftJoin('fakturpembeliandetail', function ($value){
    					$value->on('fakturpembeliandetail.NoTransaksi','=','fakturpembelianheader.NoTransaksi')
    					->on('fakturpembeliandetail.RecordOwnerID','=','fakturpembelianheader.RecordOwnerID');
    				})
    				->leftJoin('orderpembeliandetail', function ($value){
    					$value->on('orderpembeliandetail.NoTransaksi','=','fakturpembeliandetail.BaseReff')
    					->on('orderpembeliandetail.RecordOwnerID','=','fakturpembeliandetail.RecordOwnerID');
    				})
    				->leftJoin('orderpembelianheader', function ($value){
    					$value->on('orderpembelianheader.NoTransaksi','=','orderpembeliandetail.NoTransaksi')
    					->on('orderpembelianheader.RecordOwnerID','=','orderpembeliandetail.RecordOwnerID');
    				})
    				->whereBetween('fakturpembelianheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('fakturpembelianheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodeVendor != "") {
    		$model->where("fakturpembelianheader.KodeSupplier", $KodeVendor);
    	}
    	if ($Status != "") {
    		$model->where("fakturpembelianheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
			
			$NoTransaksi = $request->input('NoTransaksi');

			$sql = "fakturpembeliandetail.NoUrut, fakturpembeliandetail.KodeItem, itemmaster.NamaItem, fakturpembeliandetail.Qty, fakturpembeliandetail.Harga, fakturpembeliandetail.Discount, fakturpembeliandetail.HargaNet, fakturpembeliandetail.KodeGudang, fakturpembeliandetail.Satuan, COALESCE(ret.QtyRetur,0) QtyRetur ";
			$model = FakturPembelianDetail::selectRaw($sql)
					->leftJoin('itemmaster', function ($value){
						$value->on('fakturpembeliandetail.KodeItem','=','itemmaster.KodeItem')
						->on('fakturpembeliandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoin('orderpembeliandetail', function ($value){
						$value->on('orderpembeliandetail.NoTransaksi','=','fakturpembeliandetail.BaseReff')
						->on('orderpembeliandetail.NoUrut','=','fakturpembeliandetail.BaseLine')
						->on('orderpembeliandetail.RecordOwnerID','=','fakturpembeliandetail.RecordOwnerID');
					})
					->leftJoinSub(
        				DB::table('returpembeliandetail')
        					->leftJoin('returpembelianheader', function ($value){
								$value->on('returpembelianheader.NoTransaksi','=','returpembeliandetail.NoTransaksi')
								->on('returpembelianheader.RecordOwnerID','=','returpembeliandetail.RecordOwnerID');
							})
        					->select('returpembeliandetail.BaseReff','returpembeliandetail.BaseLine','returpembeliandetail.KodeItem','returpembeliandetail.RecordOwnerID', DB::raw('SUM(Qty) as QtyRetur'))
        					->where('returpembelianheader.Status','O')
        					->groupBy('returpembeliandetail.BaseReff','returpembeliandetail.BaseLine','returpembeliandetail.KodeItem','returpembeliandetail.RecordOwnerID'),
        				'ret',
        				function ($value){
        					$value->on('ret.KodeItem','=','fakturpembeliandetail.KodeItem')
        							->on('ret.BaseLine','=','fakturpembeliandetail.NoUrut')
        							->on('ret.BaseReff','=','fakturpembeliandetail.NoTransaksi')
        							->on('ret.RecordOwnerID','=','fakturpembeliandetail.RecordOwnerID');
        			})
					->where('fakturpembeliandetail.NoTransaksi',$NoTransaksi)
					->where('fakturpembeliandetail.RecordOwnerID',Auth::user()->RecordOwnerID)
					->orderBy('fakturpembeliandetail.NoUrut');

	    $data['data']= $model->get();
	    return response()->json($data);
	}

	public function FindHeader(Request $request)
   	{
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
   		
   		$NoTransaksi = $request->input('NoTransaksi');
   		$orderheader = FakturPembelianHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$data['data']= $orderheader;
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
		$orderdetail = OrderPembelianDetail::selectRaw("orderpembeliandetail.*, itemmaster.NamaItem")
							->leftJoin('itemmaster', function ($value){
	        					$value->on('orderpembeliandetail.KodeItem','=','itemmaster.KodeItem')
	        					->on('orderpembeliandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
	        				})
							->where('orderpembeliandetail.NoTransaksi', $NoTransaksi)
							->where('orderpembeliandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$fakturheader = FakturPembelianHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = FakturPembelianDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "fakturpembeliandetail.*, fakturpembeliandetail.Qty AS QtyFaktur, orderpembeliandetail.Qty AS QtyOrder, itemmaster.NamaItem";
		$fakturdetail = FakturPembelianDetail::selectRaw($sql)
						->leftJoin('orderpembeliandetail', function ($value){
							$value->on('orderpembeliandetail.NoTransaksi','=','fakturpembeliandetail.BaseReff')
							->on('orderpembeliandetail.NoUrut','=','fakturpembeliandetail.BaseLine')
							->on('orderpembeliandetail.RecordOwnerID','=','fakturpembeliandetail.RecordOwnerID');
						})
						->leftJoin('itemmaster', function ($value){
        					$value->on('fakturpembeliandetail.KodeItem','=','itemmaster.KodeItem')
        					->on('fakturpembeliandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
        				})
						->where('fakturpembeliandetail.NoTransaksi',$NoTransaksi)
						->where('fakturpembeliandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

	    return view("Transaksi.Pembelian.FakturPembelian-Input2",[
	        'supplier' => $supplier,
	        'termin' => $termin,
	        'item' => $item,
	        'orderheader' => $orderheader,
	        'orderdetail' => $orderdetail,
	        'fakturheader' => $fakturheader,
	        'fakturdetail' => $fakturdetail,
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

			if ($jsonData['KodeSupplier'] == "") {
				$data['message'] = "Supplier Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}

			if ($jsonData['KodeTermin'] == "") {
				$data['message'] = "Termin Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}
			
			$currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("FPB","fakturpembelianheader","NoTransaksi");

	        $model = new FakturPembelianHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;

	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodeSupplier = $jsonData['KodeSupplier'];
			$model->KodeTermin = $jsonData['KodeTermin'];
			$model->Termin = $jsonData['Termin'];
			$model->TotalTransaksi = $jsonData['TotalTransaksi'];
			$model->Potongan = $jsonData['Potongan'];
			$model->Pajak = $jsonData['Pajak'];
			$model->TotalPembelian = $jsonData['TotalPembelian'];
			$model->TotalRetur = $jsonData['TotalRetur'];
			$model->TotalPembayaran = $jsonData['TotalPembayaran'];
			$model->Status = $jsonData['Status'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->Posted = 0;
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
   
			$save = $model->save();

			foreach ($jsonData['Detail'] as $key) {
				if ($key['Qty'] == 0) {
					goto skip;
				}

				if ($key['Qty'] > $key['QtyOrder']) {
					$data["message"] = "Qty Faktur Item " . $key['NamaItem']." Melebihi Qty Order";
					$errorCount +=1;
					goto jump;
				}

				if ($key['KodeGudang'] == "") {
					$data["message"] = "Gudang Penerima Belum ditentukan";
					$errorCount +=1;
					goto jump;
				}

				$modelDetail = new FakturPembelianDetail;
           		$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $key['NoUrut'];
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['Qty'];
				$modelDetail->Satuan = $key['Satuan'];
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->Discount = $key['Discount'];

				$modelDetail->BaseReff = $key['BaseReff'];
				$modelDetail->BaseLine = $key['BaseLine'];
				$modelDetail->KodeGudang = $key['KodeGudang'];

				if ($key['Discount'] ==0) {
					$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
				}
				else{
					$HargaGros = $key['Qty'] * $key['Harga'];
					$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
					$modelDetail->HargaNet = $HargaGros - $diskon;
				}
				$modelDetail->LineStatus = 'O';
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				$save = $modelDetail->save();

				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
				skip:
			}

			// Auto Journal

			// Generate Header :



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
	   
	           $model = FakturPembelianHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	   
	           if ($model) {
	               $update = DB::table('fakturpembelianheader')
	                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                           ->update(
	                               [
	                                    'TglTransaksi' => $jsonData['TglTransaksi'],
										'TglJatuhTempo' => $jsonData['TglJatuhTempo'],
										'NoReff' => $jsonData['NoReff'],
										'KodeSupplier' => $jsonData['KodeSupplier'],
										'KodeTermin' => $jsonData['KodeTermin'],
										'Termin' => $jsonData['Termin'],
										'TotalTransaksi' => $jsonData['TotalTransaksi'],
										'Potongan' => $jsonData['Potongan'],
										'Pajak' => $jsonData['Pajak'],
										'TotalPembelian' => $jsonData['TotalPembelian'],
										'TotalRetur' => $jsonData['TotalRetur'],
										'TotalPembayaran' => $jsonData['TotalPembayaran'],
										'Status' => $jsonData['Status'],
										'Keterangan' => $jsonData['Keterangan'],
										'UpdatedBy' => Auth::user()->name
	                               ]
	                           );

	                foreach ($jsonData['Detail'] as $key) {
		           		if ($key['Qty'] == 0) {
							$data['message'] = "Quantity Harus lebih dari 0";
							$errorCount += 1;
							goto jump;
						}

						if ($key['LineStatus'] == "C") {
							goto skip;
						}


						$checkExists = FakturPembelianHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           							->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	           							->where('KodeItem','=', $key['KodeItem']);
	           			if ($checkExists) {
	           				$HargaNet= 0;
	           				if ($key['Discount'] ==0) {
								$HargaNet = $key['Qty'] * $key['Harga'];
							}
							else{
								$HargaGros = $key->Qty * $key->Harga;
								$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
								$HargaNet = $HargaGros - $diskon;
							}
	           				$update = DB::table('fakturpembeliandetail')
	                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                           ->where('KodeItem','=', $key['KodeItem'])
	                           ->update(
									[
										'NoUrut' => $key['NoUrut'],
										'Qty' => $key['Qty'],
										'Satuan' => $key['Satuan'],
										'Harga' => $key['Harga'],
										'Discount' => $key['Discount'],
										'HargaNet' =>$HargaNet,
										'KodeGudang' => $key['KodeGudang'],
										'BaseReff' => $key['BaseReff'],
										'BaseLine' => $key['BaseLine'],
									]
	                           );
	           			}
	           			else{
	           				$modelDetail = new FakturPembelianDetail;
			           		$modelDetail->NoTransaksi = $NoTransaksi;
							$modelDetail->NoUrut = $key['NoUrut'];
							$modelDetail->KodeItem = $key['KodeItem'];
							$modelDetail->Qty = $key['Qty'];
							$modelDetail->Satuan = $key['Satuan'];
							$modelDetail->Harga = $key['Harga'];
							$modelDetail->Discount = $key['Discount'];

							$modelDetail->BaseReff = $key['BaseReff'];
							$modelDetail->BaseLine = $key['BaseLine'];
							$modelDetail->KodeGudang = $key['KodeGudang'];

							if ($key['Discount'] ==0) {
								$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
							}
							else{
								$HargaGros = $key['Qty'] * $key['Harga'];
								$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
								$modelDetail->HargaNet = $HargaGros - $diskon;
							}
							$modelDetail->LineStatus = 'O';
							$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

							$save = $modelDetail->save();

							if (!$save) {
								$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
								$errorCount += 1;
								goto jump;
							}
	           			}
	           			skip:
		           }
	               if ($update) {
	                   $data['success'] = true;
	               }else{
	                   $data['message'] = 'Edit Models Gagal';
	               }
	           } else{
	               $data['message'] = 'Models not found.';
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
	       } catch (Exception $e) {
	           Log::debug($e->getMessage());
	   
	           $data['message'] = $e->getMessage();
	       }
	       return response()->json($data);
	   }

}
