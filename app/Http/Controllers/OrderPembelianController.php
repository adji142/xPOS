<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\OrderPembelianHeader;
use App\Models\OrderPembelianDetail;
use App\Models\Supplier;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;

class OrderPembelianController extends Controller
{
	public function View(Request $request)
	   {
	       $keyword = $request->input('keyword');
	       $supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	       return view("Transaksi.Pembelian.OrderPembelian",[
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

	   		$sql = "orderpembelianheader.NoTransaksi, orderpembelianheader.TglTransaksi,orderpembelianheader.TglJatuhTempo, orderpembelianheader.NoReff, orderpembelianheader.KodeSupplier, supplier.NamaSupplier, orderpembelianheader.Termin, terminpembayaran.NamaTermin, orderpembelianheader.TotalPembelian, orderpembelianheader.TotalPembayaran, orderpembelianheader.TotalPembelian - COALESCE(orderpembelianheader.TotalPembayaran,0) TotalHutang";
	   		$model = OrderPembelianHeader::selectRaw($sql)
        				->leftJoin('terminpembayaran', function ($value){
        					$value->on('orderpembelianheader.KodeTermin','=','terminpembayaran.id')
        					->on('terminpembayaran.RecordOwnerID','=','orderpembelianheader.RecordOwnerID');
        				})
        				->leftJoin('supplier', function ($value){
        					$value->on('orderpembelianheader.KodeSupplier','=','supplier.KodeSupplier')
        					->on('supplier.RecordOwnerID','=','orderpembelianheader.RecordOwnerID');
        				})
        				->whereBetween('orderpembelianheader.TglTransaksi',[$TglAwal, $TglAkhir])
        				->where('orderpembelianheader.RecordOwnerID',Auth::user()->RecordOwnerID);

        	if ($KodeVendor != "") {
        		$model->where("orderpembelianheader.KodeSupplier", $KodeVendor);
        	}

        	if ($Status != "") {
        		$model->where("orderpembelianheader.Status", $Status);
        	}
	   
	        $data['data']= $model->get();
	        return response()->json($data);
	   }

	   public function ViewDetail(Request $request)
	   {
	    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
	   		$NoTransaksi = $request->input('NoTransaksi');

	   		$sql = "orderpembeliandetail.NoUrut, orderpembeliandetail.KodeItem, itemmaster.NamaItem, orderpembeliandetail.Qty, orderpembeliandetail.Harga, orderpembeliandetail.Discount, orderpembeliandetail.HargaNet, orderpembeliandetail.Satuan";
	   		$model = OrderPembelianDetail::selectRaw($sql)
        				->leftJoin('itemmaster', function ($value){
        					$value->on('orderpembeliandetail.KodeItem','=','itemmaster.KodeItem')
        					->on('orderpembeliandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
        				})
        				->where('orderpembeliandetail.NoTransaksi',$NoTransaksi)
        				->where('orderpembeliandetail.RecordOwnerID',Auth::user()->RecordOwnerID);
	   
	        $data['data']= $model->get();
	        return response()->json($data);
	   }

	   public function FindHeader(Request $request)
	   {
	   		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
	   		$NoTransaksi = $request->input('NoTransaksi');
	   		$orderheader = OrderPembelianHeader::where('NoTransaksi', $NoTransaksi)
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
			$orderdetail = OrderPembelianDetail::where('NoTransaksi', $NoTransaksi)
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

		    return view("Transaksi.Pembelian.OrderPembelian-Input",[
		        'supplier' => $supplier,
		        'termin' => $termin,
		        'item' => $item,
		        'orderheader' => $orderheader,
		        'orderdetail' => $orderdetail,
		        'satuan' => $satuan
		    ]);
	   }
	   
	   public function store(Request $request)
	   {
	   	Log::debug($request->all());
	       try {
	           $this->validate($request, [
	               'KodeModels'=>'required',
	               'NamaModels'=>'required'
	           ]);

	        	$DocumentNumbering = new DocumentNumbering();
		   		$Numbering = $DocumentNumbering->GetNewDoc('PBL', 'orderpembelianheader', 'NoTransaksi');
	   
	           $model = new Models;
	           $model->RecordOwnerID = Auth::user()->RecordOwnerID;
	   
	           $save = $model->save();
	   
	           if ($save) {
	               alert()->success('Success','Data Models Berhasil disimpan.');
	               return redirect('model');
	               
	           }else{
	               throw new \Exception('Penambahan Data Models Gagal');
	           }
	       } catch (\Exception $e) {
	           Log::debug($e->getMessage());
	   
	           alert()->error('Error',$e->getMessage());
	           return redirect()->back();
	       }
	   }
	   
	   public function edit(Request $request)
	   {
	       Log::debug($request->all());
	       try {
	           $this->validate($request, [
	               'KodeModels'=>'required',
	               'NamaModels'=>'required'
	           ]);
	   
	           $model = Models::where('KodeModels','=',$request->input('KodeModels'));
	   
	           if ($model) {
	               $update = DB::table('model')
	                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	               			->update(
	               				[
	               					'NamaModels'=>$request->input('NamaModels'),
	               				]
	               			);
	   
	               if ($update) {
	                   alert()->success('Success','Data Models berhasil disimpan.');
	                   return redirect('model');
	               }else{
	                   throw new \Exception('Edit Models Gagal');
	               }
	           } else{
	               throw new \Exception('Models not found.');
	           }
	       } catch (Exception $e) {
	           Log::debug($e->getMessage());
	   
	           alert()->error('Error',$e->getMessage());
	           return redirect()->back();
	       }
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

	            $model = new OrderPembelianHeader;
	           	
	           	$numberingData = new DocumentNumbering();
	           	$NoTransaksi = $numberingData->GetNewDoc("PBL","orderpembelianheader","NoTransaksi");
	           	
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
				$model->CreatedBy = Auth::user()->name;
				$model->UpdatedBy = "";
	            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
	   
	           $save = $model->save();
	   
	           if (!$save) {
	           		$data['message'] = "Gagal Menyimpan Data Pembelian";
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

	           		$modelDetail = new OrderPembelianDetail;
	           		$modelDetail->NoTransaksi = $NoTransaksi;
					$modelDetail->NoUrut = $key['NoUrut'];
					$modelDetail->KodeItem = $key['KodeItem'];
					$modelDetail->Qty = $key['Qty'];
					$modelDetail->Satuan = $key['Satuan'];
					$modelDetail->Harga = $key['Harga'];
					$modelDetail->Discount = $key['Discount'];

					if ($key['Discount'] ==0) {
						$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
					}
					else{
						$HargaGros = $key->Qty * $key->Harga;
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
	   
	           $model = OrderPembelianHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
	   
	           if ($model) {
	               $update = DB::table('orderpembelianheader')
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


						$checkExists = OrderPembelianDetail::where('NoTransaksi','=',$jsonData['NoTransaksi'])
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
	           				$update = DB::table('orderpembeliandetail')
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
										'HargaNet' =>$HargaNet
									]
	                           );
	                        // if (!$update) {
	                        // 	$data['message'] = "Update Row Data Failed";
	                        // 	$errorCount +=1;
	                        // 	goto jump;
	                        // }
	           			}
	           			else{
	           				$modelDetail = new OrderPembelianDetail;
			           		$modelDetail->NoTransaksi = $NoTransaksi;
							$modelDetail->NoUrut = $key['NoUrut'];
							$modelDetail->KodeItem = $key['KodeItem'];
							$modelDetail->Qty = $key['Qty'];
							$modelDetail->Satuan = $key['Satuan'];
							$modelDetail->Harga = $key['Harga'];
							$modelDetail->Discount = $key['Discount'];

							if ($key['Discount'] ==0) {
								$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
							}
							else{
								$HargaGros = $key->Qty * $key->Harga;
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
	   
	   public function deletedata(Request $request)
	   {
	   	try {
	   		$model = DB::table('model')
	                   ->where('KodeModels','=', $request->id)
	                   ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                   ->delete();
	   
	           if ($model) {
	           	alert()->success('Success','Delete Models berhasil.');
	           }
	           else{
	           	alert()->error('Error','Delete Models Gagal.');
	           }
	           return redirect('model');
	   	} catch (Exception $e) {
	   		Log::debug($e->getMessage());
	   
	           alert()->error('Error',$e->getMessage());
	   	}
	   }   
}
