<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\OrderPenjualanHeader;
use App\Models\OrderPenjualanDetail;
use App\Models\FakturPenjualanHeader;
use App\Models\FakturPenjualanDetail;
use App\Models\Pelanggan;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;

class FakturPenjualanController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $pelanggan = Pelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Penjualan.FakturPenjualan",[
	    	'pelanggan' => $pelanggan->get(), 
	    ]);
    }

    public function ViewHeader(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
	   	$KodePelanggan = $request->input('KodePelanggan');
	   	$Status = $request->input('Status');

	   	$sql = "DISTINCT fakturpenjualanheader.NoTransaksi, fakturpenjualanheader.TglTransaksi,fakturpenjualanheader.TglJatuhTempo, fakturpenjualanheader.NoReff, fakturpenjualanheader.KodePelanggan, pelanggan.NamaPelanggan, fakturpenjualanheader.Termin, terminpembayaran.NamaTermin, fakturpenjualanheader.TotalPembelian, fakturpenjualanheader.TotalPembayaran, fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur TotalHutang, COALESCE(orderpenjualanheader.NoTransaksi, '') AS NoOrder, orderpenjualanheader.TglTransaksi TglOrder, fakturpenjualanheader.TotalRetur,
	   		CASE WHEN fakturpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN fakturpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN fakturpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument ";
	   	$model = FakturPenjualanHeader::selectRaw($sql)
    				->leftJoin('terminpembayaran', function ($value){
    					$value->on('fakturpenjualanheader.KodeTermin','=','terminpembayaran.id')
    					->on('terminpembayaran.RecordOwnerID','=','fakturpenjualanheader.RecordOwnerID');
    				})
    				->leftJoin('pelanggan', function ($value){
    					$value->on('fakturpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
    					->on('pelanggan.RecordOwnerID','=','fakturpenjualanheader.RecordOwnerID');
    				})
    				->leftJoin('fakturpenjualandetail', function ($value){
    					$value->on('fakturpenjualandetail.NoTransaksi','=','fakturpenjualanheader.NoTransaksi')
    					->on('fakturpenjualandetail.RecordOwnerID','=','fakturpenjualanheader.RecordOwnerID');
    				})
    				->leftJoin('orderpenjualandetail', function ($value){
    					$value->on('orderpenjualandetail.NoTransaksi','=','fakturpenjualandetail.BaseReff')
    					->on('orderpenjualandetail.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
    				})
    				->leftJoin('orderpenjualanheader', function ($value){
    					$value->on('orderpenjualanheader.NoTransaksi','=','orderpenjualandetail.NoTransaksi')
    					->on('orderpenjualanheader.RecordOwnerID','=','orderpenjualandetail.RecordOwnerID');
    				})
    				->whereBetween('fakturpenjualanheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('fakturpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodePelanggan != "") {
    		$model->where("fakturpenjualanheader.KodePelanggan", $KodePelanggan);
    	}
    	if ($Status != "") {
    		$model->where("fakturpenjualanheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
			
			$NoTransaksi = $request->input('NoTransaksi');

			$sql = "fakturpenjualandetail.NoUrut, fakturpenjualandetail.KodeItem, itemmaster.NamaItem, fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.Discount, fakturpenjualandetail.HargaNet, fakturpenjualandetail.KodeGudang, fakturpenjualandetail.Satuan, COALESCE(ret.QtyRetur,0) QtyRetur ";
			$model = FakturPenjualanDetail::selectRaw($sql)
					->leftJoin('itemmaster', function ($value){
						$value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
						->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoin('orderpenjualandetail', function ($value){
						$value->on('orderpenjualandetail.NoTransaksi','=','fakturpenjualandetail.BaseReff')
						->on('orderpenjualandetail.NoUrut','=','fakturpenjualandetail.BaseLine')
						->on('orderpenjualandetail.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
					})
					->leftJoinSub(
        				DB::table('returpenjualandetail')
        					->leftJoin('returpenjualanheader', function ($value){
								$value->on('returpenjualanheader.NoTransaksi','=','returpenjualandetail.NoTransaksi')
								->on('returpenjualanheader.RecordOwnerID','=','returpenjualandetail.RecordOwnerID');
							})
        					->select('returpenjualandetail.BaseReff','returpenjualandetail.BaseLine','returpenjualandetail.KodeItem','returpenjualandetail.RecordOwnerID', DB::raw('SUM(Qty) as QtyRetur'))
        					->where('returpenjualanheader.Status','O')
        					->groupBy('returpenjualandetail.BaseReff','returpenjualandetail.BaseLine','returpenjualandetail.KodeItem','returpenjualandetail.RecordOwnerID'),
        				'ret',
        				function ($value){
        					$value->on('ret.KodeItem','=','fakturpenjualandetail.KodeItem')
        							->on('ret.BaseLine','=','fakturpenjualandetail.NoUrut')
        							->on('ret.BaseReff','=','fakturpenjualandetail.NoTransaksi')
        							->on('ret.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
        			})
					->where('fakturpenjualandetail.NoTransaksi',$NoTransaksi)
					->where('fakturpenjualandetail.RecordOwnerID',Auth::user()->RecordOwnerID)
					->orderBy('fakturpenjualandetail.NoUrut');

	    $data['data']= $model->get();
	    return response()->json($data);
	}

	public function FindHeader(Request $request)
   	{
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
   		
   		$NoTransaksi = $request->input('NoTransaksi');
   		$orderheader = FakturPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$data['data']= $orderheader;
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

	    return view("Transaksi.Penjualan.FakturPenjualan-Input",[
	        'pelanggan' => $pelanggan,
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

	public function storePoS(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => 0);
		Log::debug($request->all());
		DB::beginTransaction();

		$errorCount = 0;
		$jsonData = $request->json()->all();

		$oKembalian = 0;
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
	        $NoTransaksi = $numberingData->GetNewDoc("OINV","fakturpenjualanheader","NoTransaksi");

	        $data['LastTRX'] = $NoTransaksi;
	        $model = new FakturPenjualanHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;

	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
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
			$model->MetodeBayar = $jsonData['MetodeBayar'];
			$model->ReffPembayaran = $jsonData['ReffPembayaran'];
			$model->Posted = 0;
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
   
			$save = $model->save();


			$oKembalian = floatval($jsonData['TotalPembayaran']) - floatval($jsonData['TotalPembelian']);
			$data['Kembalian'] = $oKembalian;
			foreach ($jsonData['Detail'] as $key) {
				if ($key['Qty'] == 0) {
					goto skip;
				}

				$modelDetail = new FakturPenjualanDetail;
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

				$HargaGros = $key['Qty'] * $key['Harga'];
				$modelDetail->HargaNet = $HargaGros - floatval($key['Discount']);
				$modelDetail->LineStatus = $key['LineStatus'];
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

	public function storeJson(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
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

			if ($jsonData['KodeTermin'] == "") {
				$data['message'] = "Termin Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}
			
			$currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("OINV","fakturpenjualanheader","NoTransaksi");

	        $model = new FakturPenjualanHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;

	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
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

				$modelDetail = new FakturPenjualanDetail;
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
   
           $model = FakturPenjualanHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
   
           if ($model) {
               $update = DB::table('fakturpenjualanheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                           ->update(
                               [
                                    'TglTransaksi' => $jsonData['TglTransaksi'],
									'TglJatuhTempo' => $jsonData['TglJatuhTempo'],
									'NoReff' => $jsonData['NoReff'],
									'KodePelanggan' => $jsonData['KodePelanggan'],
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


					$checkExists = FakturPenjualanHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
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
           				$update = DB::table('fakturpenjualandetail')
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
           				$modelDetail = new FakturPenjualanDetail;
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
