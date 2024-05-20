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
use App\Models\AutoPosting;

class PenerimaanKonsinyasiController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Pembelian.Konsinyasi",[
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

	   	$sql = "DISTINCT penerimaankonsinyasiheader.NoTransaksi, penerimaankonsinyasiheader.TglTransaksi,penerimaankonsinyasiheader.TglJatuhTempo, penerimaankonsinyasiheader.NoReff, penerimaankonsinyasiheader.KodeSupplier, supplier.NamaSupplier, penerimaankonsinyasiheader.Termin, terminpembayaran.NamaTermin, penerimaankonsinyasiheader.TotalPembelian, penerimaankonsinyasiheader.TotalPembayaran, penerimaankonsinyasiheader.TotalPembelian - COALESCE(penerimaankonsinyasiheader.TotalPembayaran,0) - penerimaankonsinyasiheader.TotalRetur TotalHutang, penerimaankonsinyasiheader.TotalRetur,
	   		CASE WHEN penerimaankonsinyasiheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN penerimaankonsinyasiheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN penerimaankonsinyasiheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument ";
	   	$model = PenerimaanKonsinyasiHeader::selectRaw($sql)
    				->leftJoin('terminpembayaran', function ($value){
    					$value->on('penerimaankonsinyasiheader.KodeTermin','=','terminpembayaran.id')
    					->on('terminpembayaran.RecordOwnerID','=','penerimaankonsinyasiheader.RecordOwnerID');
    				})
    				->leftJoin('supplier', function ($value){
    					$value->on('penerimaankonsinyasiheader.KodeSupplier','=','supplier.KodeSupplier')
    					->on('supplier.RecordOwnerID','=','penerimaankonsinyasiheader.RecordOwnerID');
    				})
    				->leftJoin('penerimaankonsinyasidetail', function ($value){
    					$value->on('penerimaankonsinyasidetail.NoTransaksi','=','penerimaankonsinyasiheader.NoTransaksi')
    					->on('penerimaankonsinyasidetail.RecordOwnerID','=','penerimaankonsinyasiheader.RecordOwnerID');
    				})
    				->whereBetween('penerimaankonsinyasiheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('penerimaankonsinyasiheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodeVendor != "") {
    		$model->where("penerimaankonsinyasiheader.KodeSupplier", $KodeVendor);
    	}
    	if ($Status != "") {
    		$model->where("penerimaankonsinyasiheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
			
			$NoTransaksi = $request->input('NoTransaksi');

			$sql = "penerimaankonsinyasidetail.NoUrut, penerimaankonsinyasidetail.KodeItem, itemmaster.NamaItem, penerimaankonsinyasidetail.Qty, penerimaankonsinyasidetail.Harga, penerimaankonsinyasidetail.Discount, penerimaankonsinyasidetail.HargaNet, penerimaankonsinyasidetail.KodeGudang, penerimaankonsinyasidetail.Satuan, COALESCE(ret.QtyRetur,0) QtyRetur ";
			$model = PenerimaanKonsinyasiDetail::selectRaw($sql)
					->leftJoin('itemmaster', function ($value){
						$value->on('penerimaankonsinyasidetail.KodeItem','=','itemmaster.KodeItem')
						->on('penerimaankonsinyasidetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoin('orderpembeliandetail', function ($value){
						$value->on('orderpembeliandetail.NoTransaksi','=','penerimaankonsinyasidetail.BaseReff')
						->on('orderpembeliandetail.NoUrut','=','penerimaankonsinyasidetail.BaseLine')
						->on('orderpembeliandetail.RecordOwnerID','=','penerimaankonsinyasidetail.RecordOwnerID');
					})
					->leftJoinSub(
        				DB::table('returkonsinyasidetail')
        					->leftJoin('returkonsinyasiheader', function ($value){
								$value->on('returkonsinyasiheader.NoTransaksi','=','returkonsinyasidetail.NoTransaksi')
								->on('returkonsinyasiheader.RecordOwnerID','=','returkonsinyasidetail.RecordOwnerID');
							})
        					->select('returkonsinyasidetail.BaseReff','returkonsinyasidetail.BaseLine','returkonsinyasidetail.KodeItem','returkonsinyasidetail.RecordOwnerID', DB::raw('SUM(Qty) as QtyRetur'))
        					->where('returkonsinyasiheader.Status','O')
        					->groupBy('returkonsinyasidetail.BaseReff','returkonsinyasidetail.BaseLine','returkonsinyasidetail.KodeItem','returkonsinyasidetail.RecordOwnerID'),
        				'ret',
        				function ($value){
        					$value->on('ret.KodeItem','=','penerimaankonsinyasidetail.KodeItem')
        							->on('ret.BaseLine','=','penerimaankonsinyasidetail.NoUrut')
        							->on('ret.BaseReff','=','penerimaankonsinyasidetail.NoTransaksi')
        							->on('ret.RecordOwnerID','=','penerimaankonsinyasidetail.RecordOwnerID');
        			})
					->where('penerimaankonsinyasidetail.NoTransaksi',$NoTransaksi)
					->where('penerimaankonsinyasidetail.RecordOwnerID',Auth::user()->RecordOwnerID)
					->orderBy('penerimaankonsinyasidetail.NoUrut');

	    $data['data']= $model->get();
	    return response()->json($data);
	}

	public function FindHeader(Request $request)
   	{
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
   		
   		$NoTransaksi = $request->input('NoTransaksi');
   		$orderheader = PenerimaanKonsinyasiHeader::where('NoTransaksi', $NoTransaksi)
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

		$konsinyasiheader = PenerimaanKonsinyasiHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = PenerimaanKonsinyasiDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "penerimaankonsinyasidetail.*, penerimaankonsinyasidetail.Qty AS QtyFaktur, orderpembeliandetail.Qty AS QtyOrder";
		$konsinyasidetail = PenerimaanKonsinyasiDetail::selectRaw($sql)
						->leftJoin('orderpembeliandetail', function ($value){
							$value->on('orderpembeliandetail.NoTransaksi','=','penerimaankonsinyasidetail.BaseReff')
							->on('orderpembeliandetail.NoUrut','=','penerimaankonsinyasidetail.BaseLine')
							->on('orderpembeliandetail.RecordOwnerID','=','penerimaankonsinyasidetail.RecordOwnerID');
						})
						->where('penerimaankonsinyasidetail.NoTransaksi',$NoTransaksi)
						->where('penerimaankonsinyasidetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

	    return view("Transaksi.Pembelian.Konsinyasi-Input",[
	        'supplier' => $supplier,
	        'termin' => $termin,
	        'item' => $item,
	        'konsinyasiheader' => $konsinyasiheader,
	        'konsinyasidetail' => $konsinyasidetail,
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
	        $NoTransaksi = $numberingData->GetNewDoc("CONS","penerimaankonsinyasiheader","NoTransaksi");

	        $model = new PenerimaanKonsinyasiHeader;

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

				$modelDetail = new PenerimaanKonsinyasiDetail;
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
	   
	           $model = PenerimaanKonsinyasiHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	   
	           if ($model) {
	               $update = DB::table('penerimaankonsinyasiheader')
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


						$checkExists = PenerimaanKonsinyasiHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
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
	           				$update = DB::table('penerimaankonsinyasidetail')
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
	           				$modelDetail = new PenerimaanKonsinyasiDetail;
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
