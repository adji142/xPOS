<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\OrderPenjualanHeader;
use App\Models\OrderPenjualanDetail;
use App\Models\Pelanggan;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;

class OrderPenjualanController extends Controller
{
    public function View(Request $request){
    	$keyword = $request->input('keyword');
    	$pelanggan = Pelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
    					->where('Status',1);

    	return view("Transaksi.Penjualan.OrderPenjualan",[
			'pelanggan' => $pelanggan->get(), 
    	]);
    }

    public function ViewHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$TglAwal = $request->input('TglAwal');
   		$TglAkhir = $request->input('TglAkhir');
   		$KodePelanggan = $request->input('KodePelanggan');
   		$Status = $request->input('Status');

   		$sql = "orderpenjualanheader.NoTransaksi, orderpenjualanheader.TglTransaksi,orderpenjualanheader.TglJatuhTempo, orderpenjualanheader.NoReff, orderpenjualanheader.KodePelanggan, pelanggan.NamaPelanggan, orderpenjualanheader.Termin, terminpembayaran.NamaTermin, orderpenjualanheader.TotalPenjualan, orderpenjualanheader.TotalPembayaran, orderpenjualanheader.TotalPenjualan - COALESCE(orderpenjualanheader.TotalPembayaran,0) TotalHutang, 
   			CASE WHEN orderpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN orderpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE 
   					CASE WHEN orderpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE '' END
   				END
   			END AS StatusDocument";
   		$model = OrderPenjualanHeader::selectRaw($sql)
    				->leftJoin('terminpembayaran', function ($value){
    					$value->on('orderpenjualanheader.KodeTermin','=','terminpembayaran.id')
    					->on('terminpembayaran.RecordOwnerID','=','orderpenjualanheader.RecordOwnerID');
    				})
    				->leftJoin('pelanggan', function ($value){
    					$value->on('orderpenjualanheader.KodePelanggan','=','pelanggan.KodePelanggan')
    					->on('pelanggan.RecordOwnerID','=','orderpenjualanheader.RecordOwnerID');
    				})
    				->whereBetween('orderpenjualanheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('orderpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodePelanggan != "") {
    		$model->where("orderpenjualanheader.KodePelanggan", $KodePelanggan);
    	}

    	if ($Status != "") {
    		$model->where("orderpenjualanheader.Status", $Status);
    	}
   
        $data['data']= $model->get();
        return response()->json($data);
    }

    public function ViewDetail(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$NoTransaksi = $request->input('NoTransaksi');

   		$sql = "orderpenjualandetail.NoUrut, orderpenjualandetail.KodeItem, itemmaster.NamaItem, 
		orderpenjualandetail.Qty,orderpenjualandetail.QtyKonversi, orderpenjualandetail.Harga, 
		orderpenjualandetail.Discount, orderpenjualandetail.HargaNet, orderpenjualandetail.Satuan, 
		orderpenjualandetail.VatPercent, itemmaster.HargaPokokPenjualan,
        orderpenjualandetail.Qty - SUM(COALESCE(faktur.Qty,0)) OutStanding";
   		$model = OrderPenjualanDetail::selectRaw($sql)
    				->leftJoin('itemmaster', function ($value){
    					$value->on('orderpenjualandetail.KodeItem','=','itemmaster.KodeItem')
    					->on('orderpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
    				})
            ->leftJoinSub(
                DB::table('deliverynotedetail')
                  ->select('deliverynotedetail.NoTransaksi', 'deliverynotedetail.Basereff','deliverynotedetail.RecordOwnerID','deliverynotedetail.KodeItem','deliverynotedetail.BaseLine','deliverynoteheader.Status', 'deliverynotedetail.Qty')
                  ->leftJoin('deliverynoteheader', function ($value){
                    $value->on('deliverynoteheader.NoTransaksi','=','deliverynotedetail.NoTransaksi')
                    ->on('deliverynoteheader.RecordOwnerID','=','deliverynotedetail.RecordOwnerID');
                  })
                  ->where('deliverynoteheader.Status','<>', 'D'),
                  'faktur',
                function($value){
                  $value->on('faktur.Basereff','orderpenjualandetail.NoTransaksi')
                  ->on('faktur.RecordOwnerID','=','orderpenjualandetail.RecordOwnerID')
                  ->on('faktur.KodeItem','=','orderpenjualandetail.KodeItem')
                  ->on('faktur.BaseLine','=','orderpenjualandetail.NoUrut');
              })
    				->where('orderpenjualandetail.NoTransaksi',$NoTransaksi)
    				->where('orderpenjualandetail.RecordOwnerID',Auth::user()->RecordOwnerID)
            ->groupBy("orderpenjualandetail.NoUrut", "orderpenjualandetail.KodeItem", "itemmaster.NamaItem", "orderpenjualandetail.Qty",'orderpenjualandetail.QtyKonversi', "orderpenjualandetail.Harga", "orderpenjualandetail.Discount", "orderpenjualandetail.HargaNet", 'orderpenjualandetail.Satuan', "orderpenjualandetail.VatPercent","orderpenjualandetail.Qty", "itemmaster.HargaPokokPenjualan");
        $data['data']= $model->get();
        return response()->json($data);
    }

    public function FindHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$NoTransaksi = $request->input('NoTransaksi');
   		$orderheader = OrderPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$data['data']= $orderheader;
        return response()->json($data);
    }

    public function Form($NoTransaksi = null){
    	$pelanggan = Pelanggan::where('Status', 1)
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();    
		$termin = Termin::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

    $oItem = new ItemMaster();
    $item = $oItem->GetItemData(Auth::user()->RecordOwnerID,'', '', '','', 'Y', '',1)->get();

		// $item = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
		// 			->where('Active','Y')->get();
		$orderheader = OrderPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$orderdetail = OrderPenjualanDetail::selectRaw("orderpenjualandetail.*, itemmaster.NamaItem")
                    ->leftJoin('itemmaster', function ($value){
                      $value->on('orderpenjualandetail.KodeItem','=','itemmaster.KodeItem')
                      ->on('orderpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
                    })
                    ->where('orderpenjualandetail.NoTransaksi', $NoTransaksi)
						        ->where('orderpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

	    return view("Transaksi.Penjualan.OrderPenjualan-Input2",[
	        'pelanggan' => $pelanggan,
	        'termin' => $termin,
	        'item' => $item,
	        'orderheader' => $orderheader,
	        'orderdetail' => $orderdetail,
	        'satuan' => $satuan
	    ]);
    }


  public function storeJson(Request $request){
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
       Log::debug($request->all());
       DB::beginTransaction();

       $errorCount = 0;
       $jsonData = $request->json()->all();
       try {
   			$currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

            $model = new OrderPenjualanHeader;
           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("ORDR","orderpenjualanheader","NoTransaksi");
           	
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
			$model->TotalPenjualan = $jsonData['TotalPenjualan'];
			$model->TotalRetur = $jsonData['TotalRetur'];
			$model->TotalPembayaran = $jsonData['TotalPembayaran'];
			$model->Status = $jsonData['Status'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
   
           $save = $model->save();
   
           if (!$save) {
           		$data['message'] = "Gagal Menyimpan Data Order Penjualan";
           		$errorCount += 1;
           		goto jump;
           }

           if (count($jsonData['Detail']) == 0) {
           		$data['message'] = "Data Detail Item Harus diisi";
           		$errorCount += 1;
           		goto jump;
           }

           foreach ($jsonData['Detail'] as $key) {
           		if ($key['Qty'] == 0) {
    					$data['message'] = "Quantity Harus lebih dari 0";
    					$errorCount += 1;
    					goto jump;
    				}

           		$modelDetail = new OrderPenjualanDetail;
           		$modelDetail->NoTransaksi = $NoTransaksi;
      				$modelDetail->NoUrut = $key['NoUrut'];
      				$modelDetail->KodeItem = $key['KodeItem'];
      				$modelDetail->Qty = $key['Qty'];
              $modelDetail->QtyKonversi = $key['QtyKonversi'];
      				$modelDetail->Satuan = $key['Satuan'];
      				$modelDetail->Harga = $key['Harga'];
              $modelDetail->VatPercent = $key['VatPercent'];
      				$modelDetail->Discount = $key['Discount'];

				if ($key['Discount'] ==0) {
					$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
				}
				else{
					$HargaGros = $key->Qty * $key->Harga;
					$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
					$modelDetail->HargaNet = $HargaGros - $diskon;
				}

        if ($key['VatPercent'] > 0) {
          $NilaiTax = (100 + $key['VatPercent']) / 100;
          $modelDetail->HargaNet *= $NilaiTax;
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
   
           $model = OrderPenjualanHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
   
           if ($model) {
               $update = DB::table('orderpenjualanheader')
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
                									'TotalPenjualan' => $jsonData['TotalPenjualan'],
                									'TotalRetur' => $jsonData['TotalRetur'],
                									'TotalPembayaran' => $jsonData['TotalPembayaran'],
                									'Status' => $jsonData['Status'],
                									'Keterangan' => $jsonData['Keterangan'],
                									'UpdatedBy' => Auth::user()->name
                               ]
                           );
              if (count($jsonData['Detail']) == 0) {
                $data['message'] = "Data Detail Tidak boleh kosong";
                $errorCount +=1;
                goto jump;
              }

              // Delete Existing Data
              $delete = DB::table('orderpenjualandetail')
                        ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->delete();
              foreach ($jsonData['Detail'] as $key) {
                if ($key['Qty'] == 0) {
                  $data['message'] = "Quantity Harus lebih dari 0";
                  $errorCount += 1;
                  goto jump;
                }

                $modelDetail = new OrderPenjualanDetail;
                $modelDetail->NoTransaksi =$jsonData['NoTransaksi'];
                $modelDetail->NoUrut = $key['NoUrut'];
                $modelDetail->KodeItem = $key['KodeItem'];
                $modelDetail->Qty = $key['Qty'];
                $modelDetail->QtyKonversi = $key['QtyKonversi'];
                $modelDetail->Satuan = $key['Satuan'];
                $modelDetail->Harga = $key['Harga'];
                $modelDetail->VatPercent = $key['VatPercent'];
                $modelDetail->Discount = $key['Discount'];

                if ($key['Discount'] ==0) {
                  $modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
                }
                else{
                  $HargaGros = $key->Qty * $key->Harga;
                  $diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
                  $modelDetail->HargaNet = $HargaGros - $diskon;
                }

                if ($key['VatPercent'] > 0) {
                  $NilaiTax = (100 + $key['VatPercent']) / 100;
                  $modelDetail->HargaNet *= $NilaiTax;
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

              $data['success'] = true;
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
