<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\OrderPenjualanHeader;
use App\Models\OrderPenjualanDetail;
use App\Models\DeliveryNoteHeader;
use App\Models\DeliveryNoteDetail;
use App\Models\Pelanggan;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;
use App\Models\Company;
use App\Models\SettingAccount;
use App\Models\Rekening;

class DeliveryNoteController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $pelanggan = Pelanggan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	    return view("Transaksi.Penjualan.DeliveryNote",[
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

	   	$sql = "DISTINCT deliverynoteheader.NoTransaksi, DATE_FORMAT(deliverynoteheader.TglTransaksi, '%d-%m-%Y') TglTransaksi, deliverynoteheader.NoReff, deliverynoteheader.KodePelanggan, pelanggan.NamaPelanggan, deliverynoteheader.TotalPembelian, COALESCE(orderpenjualanheader.NoTransaksi, '') AS NoOrder, orderpenjualanheader.TglTransaksi TglOrder,
	   		CASE WHEN deliverynoteheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN deliverynoteheader.Status = 'T' THEN 'DRAFT' ELSE 
   					CASE WHEN deliverynoteheader.Status = 'D' THEN 'CANCEL' ELSE
   						CASE WHEN deliverynoteheader.Status = 'C' THEN 'CLOSE' ELSE '' END
   						END
   					END
   				END AS StatusDocument, CONCAT(deliverynoteheader.DeliveryStatus,' ', COALESCE(deliverynoteheader.KeteranganPengiriman,' ')) as DeliveryStatus,deliverynoteheader.Transaksi ";
	   	$deliverynote = DeliveryNoteHeader::selectRaw($sql)
   						->leftJoin('deliverynotedetail', function ($value){
	    					$value->on('deliverynotedetail.NoTransaksi','=','deliverynoteheader.NoTransaksi')
	    					->on('deliverynotedetail.RecordOwnerID','=','deliverynoteheader.RecordOwnerID');
	    				})
	    				->leftJoin('orderpenjualandetail', function ($value){
	    					$value->on('orderpenjualandetail.NoTransaksi','=','deliverynotedetail.BaseReff')
	    					->on('orderpenjualandetail.NoUrut','=','deliverynotedetail.BaseLine')
	    					->on('orderpenjualandetail.RecordOwnerID','=','deliverynotedetail.RecordOwnerID');
	    				})
	    				->leftJoin('orderpenjualanheader', function ($value){
	    					$value->on('orderpenjualanheader.NoTransaksi','=','orderpenjualandetail.NoTransaksi')
	    					->on('orderpenjualanheader.RecordOwnerID','=','deliverynotedetail.RecordOwnerID');
	    				})
	    				->leftJoin('pelanggan', function ($value){
	    					$value->on('deliverynoteheader.KodePelanggan','=','pelanggan.KodePelanggan')
	    					->on('pelanggan.RecordOwnerID','=','deliverynoteheader.RecordOwnerID');
	    				})
	    				->whereBetween('deliverynoteheader.TglTransaksi',[$TglAwal,$TglAkhir])
	    				->where('deliverynoteheader.RecordOwnerID',Auth::user()->RecordOwnerID);
	   	if ($KodePelanggan != "") {
    		$deliverynote->where("deliverynoteheader.KodePelanggan", $KodePelanggan);
    	}
    	if ($Status != "") {
    		$deliverynote->where("deliverynoteheader.Status", $Status);
    	}


    	$deliverynote->orderBy('deliverynoteheader.TglTransaksi','DESC');
        $data['data']= $deliverynote->get();
        return response()->json($data);
    }

    public function ViewDetail(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
			
			$NoTransaksi = $request->input('NoTransaksi');

			$sql = "deliverynotedetail.NoUrut, deliverynotedetail.KodeItem, itemmaster.NamaItem, deliverynotedetail.Qty, 
					deliverynotedetail.Harga, deliverynotedetail.Discount, deliverynotedetail.HargaNet, 
					deliverynotedetail.KodeGudang, deliverynotedetail.Satuan, COALESCE(ret.QtyRetur,0) QtyRetur, 
					deliverynotedetail.QtyKonversi, itemmaster.VatPercent, deliverynotedetail.HargaPokokPenjualan, deliverynotedetail.VatTotal ";
			$model = DeliveryNoteDetail::selectRaw($sql)
					->leftJoin('itemmaster', function ($value){
						$value->on('deliverynotedetail.KodeItem','=','itemmaster.KodeItem')
						->on('deliverynotedetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
					})
					->leftJoinSub(
        				DB::table('returpenjualandetail')
        					->leftJoin('returpenjualanheader', function ($value){
								$value->on('returpenjualanheader.NoTransaksi','=','returpenjualandetail.NoTransaksi')
								->on('returpenjualanheader.RecordOwnerID','=','returpenjualandetail.RecordOwnerID');
							})
        					->select('returpenjualandetail.BaseReff','returpenjualandetail.BaseLine','returpenjualandetail.BaseType','returpenjualandetail.KodeItem','returpenjualandetail.RecordOwnerID', DB::raw('SUM(Qty) as QtyRetur'))
        					->where('returpenjualanheader.Status','O')
        					->groupBy('returpenjualandetail.BaseReff','returpenjualandetail.BaseLine','returpenjualandetail.KodeItem','returpenjualandetail.RecordOwnerID','returpenjualandetail.BaseType'),
        				'ret',
        				function ($value){
        					$value->on('ret.KodeItem','=','deliverynotedetail.KodeItem')
        							->on('ret.BaseLine','=','deliverynotedetail.NoUrut')
        							->on('ret.BaseReff','=','deliverynotedetail.NoTransaksi')
        							->on('ret.BaseType','=', DB::raw("'ODLN'"))
        							->on('ret.RecordOwnerID','=','deliverynotedetail.RecordOwnerID');
        			})
					->where('deliverynotedetail.NoTransaksi',$NoTransaksi)
					->where('deliverynotedetail.RecordOwnerID',Auth::user()->RecordOwnerID)
					->orderBy('deliverynotedetail.NoUrut');

	    $data['data']= $model->get();
	    return response()->json($data);
    }

    public function FindHeader(Request $request)
   	{
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
   		
   		$NoTransaksi = $request->input('NoTransaksi');
   		$orderheader = DeliveryNoteHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$data['data']= $orderheader;
        return response()->json($data);
   	}

   	public function Form($NoTransaksi = null)
	{
		$pelanggan = Pelanggan::where('Status', 1)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();    
		$termin = Termin::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$oItem = new ItemMaster();
    	$item = $oItem->GetItemData(Auth::user()->RecordOwnerID,'', '', '','', 'Y', '',1)->get();
		$orderheader = OrderPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$orderdetail = OrderPenjualanDetail::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$deliveryheader = DeliveryNoteHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = FakturPenjualanDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "deliverynotedetail.*, deliverynotedetail.Qty AS QtyFaktur, orderpenjualandetail.Qty AS QtyOrder, itemmaster.NamaItem, deliverynotedetail.Qty AS QtyKirim";
		$deliverydetail = DeliveryNoteDetail::selectRaw($sql)
						->leftJoin('orderpenjualandetail', function ($value){
							$value->on('orderpenjualandetail.NoTransaksi','=','deliverynotedetail.BaseReff')
							->on('orderpenjualandetail.NoUrut','=','deliverynotedetail.BaseLine')
							->on('orderpenjualandetail.RecordOwnerID','=','deliverynotedetail.RecordOwnerID');
						})
						->leftJoin('itemmaster', function ($value){
							$value->on('itemmaster.KodeItem','=','deliverynotedetail.KodeItem')
							->on('itemmaster.RecordOwnerID','=','deliverynotedetail.RecordOwnerID');
						})
						->where('deliverynotedetail.NoTransaksi',$NoTransaksi)
						->where('deliverynotedetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

	    return view("Transaksi.Penjualan.DeliveryNote-Input2",[
	        'pelanggan' => $pelanggan,
	        'termin' => $termin,
	        'item' => $item,
	        'orderheader' => $orderheader,
	        'orderdetail' => $orderdetail,
	        'deliveryheader' => $deliveryheader,
	        'deliverydetail' => $deliverydetail,
	        'satuan' => $satuan,
	        'gudang' => $gudang,
			'ppnpercent' => $oCompany->PPN,
			'ppninclude' => $oCompany->isHargaJualIncludePPN,
	    ]);
	}

	public function storeJson(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
		Log::debug($request->all());
		DB::beginTransaction();

		$errorCount = 0;
		$jsonData = $request->json()->all();

		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
		try {
			if ($jsonData['KodePelanggan'] == "") {
				$data['message'] = "Pelanggan Tidak boleh kosong";
				$errorCount +=1;
				goto jump;
			}

			$currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("ODLN","deliverynoteheader","NoTransaksi");
	        $model = new DeliveryNoteHeader;
	        $model->Periode = $Year.$Month;
			$model->NoTransaksi = $NoTransaksi;
			$model->Transaksi = $jsonData['Transaksi'];
			$model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
			$model->KodeTermin = $jsonData['KodeTermin'];
			$model->Termin = $jsonData['Termin'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
			$model->TotalTransaksi = $jsonData['TotalTransaksi'];
			$model->Potongan = $jsonData['Potongan'];
			$model->Pajak = $jsonData['Pajak'];
			$model->TotalPembelian = $jsonData['TotalPembelian'];
			$model->Status = $jsonData['Status'];
			$model->DeliveryStatus = $jsonData['DeliveryStatus'];
			$model->KeteranganPengiriman = "Dokumen Pengiriman dibuat";
			$model->Keterangan = $jsonData['Keterangan'];
			$model->SyaratDanKetentuan = $jsonData['SyaratDanKetentuan'];
			$model->RecordOwnerID = Auth::user()->RecordOwnerID;
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";


			$save = $model->save();
			foreach ($jsonData['Detail'] as $key) {
				if ($key['QtyKirim'] == 0) {
					goto skip;
				}

				if ($key["KodeGudang"] == "") {
					$data['Gudang Harus diisi'];
					$errorCount +=1;
					goto jump;
				}

				if ($key['QtyOrder'] < $key['QtyKirim']) {
					$data['Qty Kirim tidak boleh melebihi Qty Order'];
					$errorCount +=1;
					goto jump;
				}

				if ($oCompany) {
					if ($oCompany->AllowNegativeInventory == NULL || $oCompany->AllowNegativeInventory == 'N') {
						$oItem = ItemMaster::where('RecordOwnerID',Auth::user()->RecordOwnerID)
									->where('KodeItem',$key['KodeItem'])
									->where('Stock','>',0)
									->get();

						if (count($oItem) == 0) {
							$data['message'] = "Stock Item ".$key['NamaItem'].' Tidak Cukup';
							$errorCount += 1;
							goto jump;		
						}
					}
				}
				else{
					$data['message'] = "Partner Tidak ditemukan";
					$errorCount += 1;
					goto jump;
				}

				$oItemMaster = ItemMaster::where('KodeItem', $key['KodeItem'])
								->where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->first();

				$modelDetail = new DeliveryNoteDetail;

				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->BaseReff = $key['BaseReff'];
				$modelDetail->BaseLine = $key['BaseLine'];
				$modelDetail->BaseType = $key['BaseType'];
				$modelDetail->NoUrut = $key['NoUrut'];
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['QtyKirim'];
				$modelDetail->QtyKonversi = $key['QtyKonversi'];
				$modelDetail->QtyRetur = 0;
				$modelDetail->Satuan = $key['Satuan'];
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->Discount = $key['Discount'];
				$modelDetail->HargaNet = $key['HargaNet'];
				$modelDetail->HargaPokokPenjualan = $oItemMaster->HargaPokokPenjualan;
				$modelDetail->LineStatus = 'O';
				$modelDetail->KodeGudang = $key['KodeGudang'];
				$modelDetail->Keterangan = "";
				$modelDetail->VatPercent = $key['VatPercent'];
				$modelDetail->VatTotal = $key['VatTotal'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				$save = $modelDetail->save();

				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
				skip:
			}

			// Auto Posting
			// Generate Header :

			$arrHeader = array(
						'NoTransaksi' => "",
						'KodeTransaksi' => "ODLN",
						'TglTransaksi' => $jsonData['TglTransaksi'],
						'NoReff' => $NoTransaksi,
						'StatusTransaksi' => "O",
						'RecordOwnerID' => Auth::user()->RecordOwnerID,
					);
			$arrDetail = array();

			$TotalHargaPokok = 0;
			foreach ($jsonData['Detail'] as $key) {
				$oItemMaster = ItemMaster::where('KodeItem', $key['KodeItem'])
								->where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->first();
				// Hutang
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
						'KodeTransaksi' => "ODLN", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $oItemMaster->HargaPokokPenjualan * $key['QtyKirim'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					$TotalHargaPokok += $oItemMaster->HargaPokokPenjualan * $key['QtyKirim'];
				}
				// End Hutang

				// GIT
				// GetAccount :
				$Setting = NEW SettingAccount();
				$getSetting = $Setting->GetSetting("PjAcctGoodsInTransit");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();

				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Goods In Transit Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}

				// Hutang

				$temp = array(
					'KodeTransaksi' => "ODLN", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $TotalHargaPokok, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				// End GIT

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
		        $data['LastTRX'] = $NoTransaksi;
	        }
		} catch (\Exception $e) {
			Log::debug($e->getMessage());
	        $data['message'] = $e->getMessage();
		}

		return response()->json($data);
	}

	public function editJson(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

       Log::debug($request->all());
       DB::beginTransaction();

       $errorCount = 0;
       $jsonData = $request->json()->all();
       $oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

       try {
       		$model = DeliveryNoteHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
           	if ($model) {
           		$update = DB::table('deliverynoteheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                           ->update(
                               	[
                                    'TglTransaksi' => $jsonData['TglTransaksi'],
									'NoReff' => $jsonData['NoReff'],
									'KodePelanggan' => $jsonData['KodePelanggan'],
									'TotalTransaksi' => $jsonData['TotalTransaksi'],
									'Potongan' => $jsonData['Potongan'],
									'Pajak' => $jsonData['Pajak'],
									'TotalPembelian' => $jsonData['TotalPembelian'],
									'Status' => $jsonData['Status'],
									'DeliveryStatus' => $jsonData['DeliveryStatus'],
									'Keterangan' => $jsonData['Keterangan'],
									'SyaratDanKetentuan' => $jsonData['SyaratDanKetentuan'],
									'RecordOwnerID' => Auth::user()->RecordOwnerID,
									'UpdatedBy' => Auth::user()->name
                               	]
                           	);
                if (count($jsonData['Detail']) > 0) {
                	// Delete Existing Data
		            $delete = DB::table('deliverynotedetail')
		                        ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
		                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                        ->delete();

		            foreach ($jsonData['Detail'] as $key) {
		            	if ($key['QtyKirim'] == 0) {
							goto skip;
						}

						if ($key["KodeGudang"] == "") {
							$data['Gudang Harus diisi'];
							$errorCount +=1;
							goto jump;
						}

						if ($key['QtyOrder'] < $key['QtyKirim']) {
							$data['Qty Kirim tidak boleh melebihi Qty Order'];
							$errorCount +=1;
							goto jump;
						}

						if ($oCompany) {
							if ($oCompany->AllowNegativeInventory == NULL || $oCompany->AllowNegativeInventory == 'N') {
								$oItem = ItemMaster::where('RecordOwnerID',Auth::user()->RecordOwnerID)
											->where('KodeItem',$key['KodeItem'])
											->where('Stock','>',0)
											->get();

								if (count($oItem) == 0) {
									$data['message'] = "Stock Item ".$key['NamaItem'].' Tidak Cukup';
									$errorCount += 1;
									goto jump;		
								}
							}
						}
						else{
							$data['message'] = "Partner Tidak ditemukan";
							$errorCount += 1;
							goto jump;
						}

						$oItemMaster = ItemMaster::where('KodeItem', $key['KodeItem'])
								->where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->first();

						$modelDetail = new DeliveryNoteDetail;

						$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->BaseReff = $key['BaseReff'];
						$modelDetail->BaseLine = $key['BaseLine'];
						$modelDetail->BaseType = $key['BaseType'];
						$modelDetail->NoUrut = $key['NoUrut'];
						$modelDetail->KodeItem = $key['KodeItem'];
						$modelDetail->Qty = $key['QtyKirim'];
						$modelDetail->QtyKonversi = $key['QtyKonversi'];
						$modelDetail->QtyRetur = 0;
						$modelDetail->Satuan = $key['Satuan'];
						$modelDetail->Harga = $key['Harga'];
						$modelDetail->Discount = $key['Discount'];
						$modelDetail->HargaNet = $key['HargaNet'];
						$modelDetail->VatPercent = $key['VatPercent'];
						$modelDetail->VatTotal = $key['VatTotal'];

						$modelDetail->HargaPokokPenjualan = $oItemMaster->HargaPokokPenjualan;
						$modelDetail->LineStatus = 'O';
						$modelDetail->KodeGudang = $key['KodeGudang'];
						$modelDetail->Keterangan = "";
						$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

						$save = $modelDetail->save();

						if (!$save) {
							$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
							$errorCount += 1;
							goto jump;
						}
						skip:
		            }
                }
                
                $data['success'] = true;
                

                // Auto Posting
				// Generate Header :

				$arrHeader = array(
							'NoTransaksi' => "",
							'KodeTransaksi' => "ODLN",
							'TglTransaksi' => $jsonData['TglTransaksi'],
							'NoReff' => $jsonData['NoTransaksi'],
							'StatusTransaksi' => "O",
							'RecordOwnerID' => Auth::user()->RecordOwnerID,
						);
				$arrDetail = array();

				$TotalHargaPokok = 0;
				foreach ($jsonData['Detail'] as $key) {
					$oItemMaster = ItemMaster::where('KodeItem', $key['KodeItem'])
									->where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->first();
					// Persediaan
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
							'KodeTransaksi' => "ODLN", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $oItemMaster->HargaPokokPenjualan * $key['QtyKirim'], 
							'Keterangan' => $jsonData['Keterangan'], 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);

						array_push($arrDetail, $temp);
						$TotalHargaPokok += $oItemMaster->HargaPokokPenjualan * $key['QtyKirim'];
					}
					// End Persediaan

					// GIT
					// GetAccount :
					$Setting = NEW SettingAccount();
					$getSetting = $Setting->GetSetting("PjAcctGoodsInTransit");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Goods In Transit Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					// Hutang

					$temp = array(
						'KodeTransaksi' => "ODLN", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $TotalHargaPokok, 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End GIT

					// Save Journal
					$autoPosting = new AutoPosting();

					if ($autoPosting->Auto($arrHeader, $arrDetail,($jsonData['Status']== "D") ? true : false) != "OK") {
						$data["message"] = "Gagal Simpan Jurnal";
						$errorCount +=1;
						goto jump;
					}
					// End Save Jurnal
           	}
           	else{
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
       } catch (\Exception $e) {
       		Log::debug($e->getMessage());
   
        	$data['message'] = $e->getMessage();
       }
       return response()->json($data);
	}

	public function EditTransactionStatus(Request $request)
   	{
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

   		$NoTransaksi = $request->input('NoTransaksi');
   		$Status = $request->input('Status');
   		
   		try {
   			$model = DeliveryNoteHeader::where('NoTransaksi','=',$NoTransaksi)
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
   
	       	if ($model) {
	           $update = DB::table('deliverynoteheader')
	                   ->where('NoTransaksi','=', $NoTransaksi)
	                   ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                   ->update(
	                       [
								'Status' => $Status,
								'UpdatedBy' => Auth::user()->name
	                       ]
	                   );
	            $data['success'] = true;
	        }
	        else{
	        	$data['message'] = "Data Penjualan Tidak ditemukan";
	        }	
   		} catch (\Exception $e) {
   			$data['message'] = "Gagal Menyimpan Data ".$e->getMessage();
   		}

   		return response()->json($data);
   	}

   	public function EditDeliveryStatus(Request $request)
   	{
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

   		$NoTransaksi = $request->input('NoTransaksi');
   		$DeliveryStatus = $request->input('DeliveryStatus');
   		$KeteranganPengiriman = $request->input('KeteranganPengiriman');
   		
   		try {
   			$model = DeliveryNoteHeader::where('NoTransaksi','=',$NoTransaksi)
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
   
	       	if ($model) {
	           $update = DB::table('deliverynoteheader')
	                   ->where('NoTransaksi','=', $NoTransaksi)
	                   ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                   ->update(
	                       [
								'DeliveryStatus' => $DeliveryStatus,
								'KeteranganPengiriman' => $KeteranganPengiriman,
								'UpdatedBy' => Auth::user()->name
	                       ]
	                   );
	            $data['success'] = true;
	        }
	        else{
	        	$data['message'] = "Data Penjualan Tidak ditemukan";
	        }	
   		} catch (\Exception $e) {
   			$data['message'] = "Gagal Menyimpan Data ".$e->getMessage();
   		}

   		return response()->json($data);
   	}

}
