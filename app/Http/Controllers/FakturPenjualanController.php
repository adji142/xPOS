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
use App\Models\DeliveryNoteDetail;
use App\Models\DeliveryNoteHeader;
use App\Models\PembayaranPenjualanDetail;
use App\Models\PembayaranPenjualanHeader;
use App\Models\Pelanggan;
use App\Models\Termin;
use App\Models\ItemMaster;
use App\Models\Satuan;
use App\Models\MetodePembayaran;
use App\Models\DocumentNumbering;
use App\Models\Gudang;
use App\Models\AutoPosting;
use App\Models\SettingAccount;
use App\Models\Rekening;
use App\Models\Company;
use App\Models\Printer;

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

	   	$sql = "DISTINCT fakturpenjualanheader.NoTransaksi, DATE_FORMAT(fakturpenjualanheader.TglTransaksi, '%d-%m-%Y %H:%i') TglTransaksi,fakturpenjualanheader.TglJatuhTempo, fakturpenjualanheader.NoReff, fakturpenjualanheader.KodePelanggan, pelanggan.NamaPelanggan, fakturpenjualanheader.Termin, terminpembayaran.NamaTermin, fakturpenjualanheader.TotalPembelian, fakturpenjualanheader.TotalPembayaran, fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur TotalHutang, COALESCE(orderpenjualanheader.NoTransaksi, '') AS NoOrder, orderpenjualanheader.TglTransaksi TglOrder, fakturpenjualanheader.TotalRetur,
	   		CASE WHEN fakturpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN fakturpenjualanheader.Status = 'T' THEN 'DRAFT' ELSE 
   					CASE WHEN fakturpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE
   						CASE WHEN  fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur <= 0 && fakturpenjualanheader.TotalRetur = 0 THEN 'LUNAS' ELSE
   							CASE WHEN  fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur > 0 THEN 'BELUM LUNAS' ELSE 
   								CASE WHEN fakturpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE '' END
   							END
   						END
   					END
   				END
   			END AS StatusDocument, fakturpenjualanheader.Transaksi, COUNT(*) TotalItems ";
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
    				->whereBetween(DB::raw('DATE(fakturpenjualanheader.TglTransaksi)'),[$TglAwal, $TglAkhir])
    				->where('fakturpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID);

    	if ($KodePelanggan != "") {
    		$model->where("fakturpenjualanheader.KodePelanggan", $KodePelanggan);
    	}
    	if ($Status != "") {
    		$model->where("fakturpenjualanheader.Status", $Status);
    	}
    	$model->groupBy('fakturpenjualanheader.NoTransaksi', 'fakturpenjualanheader.TglTransaksi', 'fakturpenjualanheader.TglJatuhTempo', 'fakturpenjualanheader.NoReff', 'fakturpenjualanheader.KodePelanggan', 'pelanggan.NamaPelanggan', 'fakturpenjualanheader.Termin', 'terminpembayaran.NamaTermin', 'fakturpenjualanheader.TotalPembelian', 'fakturpenjualanheader.TotalPembayaran', 'fakturpenjualanheader.TotalRetur', 'orderpenjualanheader.NoTransaksi', 'orderpenjualanheader.TglTransaksi', 'fakturpenjualanheader.Status', 'fakturpenjualanheader.Transaksi');
   		$model->orderBy('fakturpenjualanheader.TglTransaksi','DESC');
        $data['data']= $model->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
			
			$NoTransaksi = $request->input('NoTransaksi');

			$sql = "fakturpenjualandetail.NoUrut, fakturpenjualandetail.KodeItem, itemmaster.NamaItem, 
			fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.Discount, 
			fakturpenjualandetail.HargaNet, fakturpenjualandetail.KodeGudang, fakturpenjualandetail.Satuan, 
			COALESCE(ret.QtyRetur,0) QtyRetur, fakturpenjualandetail.QtyKonversi, fakturpenjualandetail.VatPercent, 
			fakturpenjualandetail.HargaPokokPenjualan ";
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
		// $item = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
		// 			->where('Active','Y')
		// 			->whereIn('TypeItem',[1,3,4])->get();


		$oItem = new ItemMaster();
    	$item = $oItem->GetItemData(Auth::user()->RecordOwnerID,'', '', '','1,3,4', 'Y', '',1)->get();
		$orderheader = OrderPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$orderdetail = OrderPenjualanDetail::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$fakturheader = FakturPenjualanHeader::where('NoTransaksi', $NoTransaksi)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		// $fakturdetail = FakturPenjualanDetail::where('NoTransaksi', $NoTransaksi)
		// 				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		$sql = "fakturpenjualandetail.*, fakturpenjualandetail.Qty AS QtyFaktur, deliverynotedetail.Qty AS QtyOrder, itemmaster.NamaItem";
		$fakturdetail = FakturPenjualanDetail::selectRaw($sql)
						->leftJoin('deliverynotedetail', function ($value){
							$value->on('deliverynotedetail.NoTransaksi','=','fakturpenjualandetail.BaseReff')
							->on('deliverynotedetail.NoUrut','=','fakturpenjualandetail.BaseLine')
							->on('deliverynotedetail.RecordOwnerID','=','fakturpenjualandetail.RecordOwnerID');
						})
						->leftJoin('itemmaster', function ($value){
	                      $value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
	                      ->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
	                    })
						->where('fakturpenjualandetail.NoTransaksi',$NoTransaksi)
						->where('fakturpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();

		$satuan = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
		$gudang = Gudang::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

	    return view("Transaksi.Penjualan.FakturPenjualan-Input2",[
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

		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

		$oKembalian = 0;
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
			// if ($jsonData['Status'] == 'T') {
			// 	$NoTransaksi = $numberingData->GetNewDoc("POSDRF","fakturpenjualanheader","NoTransaksi");
			// 	if ($jsonData['NoTransaksi'] != '') {
			// 		DB::table('fakturpenjualanheader')
	  //       			->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	  //                   ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	  //       			->update(
	  //       				[
	  //       					'Status'=> 'C',
	  //       					'UpdatedBy' => Auth::user()->name
	  //       				]
	  //       			);
			// 	}
			// }else{
			// 	$NoTransaksi = $numberingData->GetNewDoc("POS","fakturpenjualanheader","NoTransaksi");
			// }
			$NoTransaksi = $numberingData->GetNewDoc("POS","fakturpenjualanheader","NoTransaksi");

	        $data['LastTRX'] = $NoTransaksi;
	        $model = new FakturPenjualanHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;
	        $model->Transaksi= 'POS';
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
			$model->Pembulatan = $jsonData['Pembulatan'];
			$model->Status = $jsonData['Status'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->MetodeBayar = $jsonData['MetodeBayar'];
			$model->ReffPembayaran = $jsonData['ReffPembayaran'];
			$model->KodeSales = $jsonData['KodeSales'];
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

				if ($oCompany) {
					if ($oCompany->AllowNegativeInventory == NULL || $oCompany->AllowNegativeInventory == 'N') {
						$oItem = ItemMaster::where('RecordOwnerID',Auth::user()->RecordOwnerID)
									->where('KodeItem',$key['KodeItem'])
									->where('Stock','>',0)
									->get();

						if (count($oItem) == 0) {
							$data['message'] = "Stock Item ".$key['KodeItem'].' Tidak Cukup';
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

				$modelDetail = new FakturPenjualanDetail;
           		$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $key['NoUrut'];
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['Qty'];
				$modelDetail->QtyKonversi = $key['QtyKonversi'];
				$modelDetail->QtyRetur = 0;
				$modelDetail->Satuan = $key['Satuan'];
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->Discount = $key['Discount'];

				$modelDetail->BaseReff = $key['BaseReff'];
				$modelDetail->BaseLine = $key['BaseLine'];
				$modelDetail->KodeGudang = $key['KodeGudang'];

				$HargaGros = $key['Qty'] * $key['Harga'];
				$modelDetail->HargaNet = $HargaGros - floatval($key['Discount']);
				$modelDetail->LineStatus = $key['LineStatus'];
				$modelDetail->VatPercent = $key['VatPercent'];
				$modelDetail->HargaPokokPenjualan = $key['HargaPokokPenjualan'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				$save = $modelDetail->save();

				if (!$save) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
				skip:
			}

			// Append Pembayaran
			if($jsonData['TotalPembayaran'] > 0){
				// Header
				$modelBayar = new PembayaranPenjualanHeader;
	           	
				$numberingDataBayar = new DocumentNumbering();
				$NoTransaksiBayar = $numberingDataBayar->GetNewDoc("INPAY","pembayaranpenjualanheader","NoTransaksi");

				$modelBayar->Periode = $Year.$Month;
				$modelBayar->NoTransaksi = $NoTransaksiBayar;
				$modelBayar->TglTransaksi = $jsonData['TglTransaksi'];
				$modelBayar->KodePelanggan = $jsonData['KodePelanggan'];
				$modelBayar->TotalPembelian = $jsonData['TotalPembelian'];
				$modelBayar->TotalPembayaran = $jsonData['TotalPembayaran'];
				$modelBayar->KodeMetodePembayaran = $jsonData['MetodeBayar'];
				$modelBayar->NoReff = $jsonData['ReffPembayaran'];
				$modelBayar->Keterangan = $jsonData['Keterangan'];
				$modelBayar->RecordOwnerID = Auth::user()->RecordOwnerID;
				$modelBayar->CreatedBy = Auth::user()->name;
				$modelBayar->UpdatedBy = "";
				$modelBayar->Posted = 0;
				$modelBayar->Status = $jsonData['Status'];

				$saveBayar = $modelBayar->save();

				if (!$saveBayar) {
					$data['message'] = "Gagal Menyimpan Data Pembayaran Penjualan";
					$errorCount += 1;
					goto jump;
				}
				// Detail
				$modelDetailBayar = new PembayaranPenjualanDetail;
				$modelDetailBayar->NoTransaksi = $NoTransaksiBayar;
				$modelDetailBayar->NoUrut = 0;
				$modelDetailBayar->BaseReff = $NoTransaksi;
				$modelDetailBayar->TotalPembayaran = $jsonData['TotalPembayaran'];
				$modelDetailBayar->RecordOwnerID = Auth::user()->RecordOwnerID;
				$modelDetailBayar->KodeMetodePembayaran = $jsonData['MetodeBayar'];
				$modelDetailBayar->Keterangan = $jsonData['Keterangan'];

				$saveBayar = $modelDetailBayar->save();
				if (!$saveBayar) {
					$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
					$errorCount += 1;
					goto jump;
				}
			}

			// Auto Journal

			// Generate Header :

			if($jsonData['Status'] != "T"){
				$arrHeader = array(
					'NoTransaksi' => "",
					'KodeTransaksi' => "OINV",
					'TglTransaksi' => $jsonData['TglTransaksi'],
					'NoReff' => $NoTransaksi,
					'StatusTransaksi' => "O",
					'RecordOwnerID' => Auth::user()->RecordOwnerID,
				);
				$arrDetail = array();
	
				// CalculateTotal
				$JurnalTotalTransaksi = 0;
				$JurnalPotongan = 0;
				$JurnalPajak = 0;
				$JurnalTotalPembelian =0;
				$JurnalKonsinyasi = 0;
	
				foreach ($jsonData['Detail'] as $key) {
	
					if ($key['Discount'] ==0) {
						$JurnalTotalTransaksi += $key['Qty'] * $key['Harga'];
					}
					else{
						$JurnalTotalTransaksi += $key['Qty'] * $key['Harga'];
	
						$HargaGros = $key['Qty'] * $key['Harga'];
	
						$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
						$JurnalPotongan += $diskon;
					}
	
					if ($key['VatPercent'] > 0) {
						$HargaGros = $key['Qty'] * $key['Harga'];
						$JurnalPajak += ($key['VatPercent'] / 100) * $HargaGros;
					}
				}
				$JurnalTotalPembelian = $JurnalTotalTransaksi - $JurnalPotongan + $JurnalPajak;
				// End CalculateTotal
				// GetAccount :
				$Setting = NEW SettingAccount();
				$getSetting = $Setting->GetSetting("PjAcctPiutang");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();
	
				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}
	
				// Piutang
	
				$temp = array(
					'KodeTransaksi' => "OINV", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $JurnalTotalPembelian, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);
	
				array_push($arrDetail, $temp);
				// End Piutang
	
				if ($JurnalPajak > 0) {
					// GetAccount :
					$Setting = NEW SettingAccount();
					$getSetting = $Setting->GetSetting("PjAcctPajakPenjualan");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();
	
					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}
	
					// PPN
	
					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $JurnalPajak, 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);
	
					array_push($arrDetail, $temp);
					// End PPN
				}
	
				// Penjualan
	
				$getPenjualanvalue = FakturPenjualanDetail::selectRaw("itemmaster.KodeItem,itemmaster.TypeItem, SUM(fakturpenjualandetail.HargaNet) TotalPenjualan, SUM(fakturpenjualandetail.HargaPokokPenjualan * fakturpenjualandetail.Qty) TotalHPP")
						->leftJoin('itemmaster', function ($value){
							$value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
							->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
						})
						->where('fakturpenjualandetail.NoTransaksi', $NoTransaksi)
						->where('fakturpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)
						->groupBy('itemmaster.TypeItem','itemmaster.KodeItem')
						->get();
				// var_dump($getPenjualanvalue);
	
				
				foreach ($getPenjualanvalue as $key) {
					if ($key['TypeItem'] == 1) {
						$getSetting = $Setting->GetSetting("InvAcctPendapatanJual");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();
	
						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}
	
						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $key['TotalPenjualan'], 
							'Keterangan' => $jsonData['Keterangan'], 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);
	
						array_push($arrDetail, $temp);
					}
					else if ($key['TypeItem'] == 4) {
						$getSetting = $Setting->GetSetting("InvAcctPendapatanJasa");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();
	
						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Penjualan Jasa Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}
	
						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $key['TotalPenjualan'], 
							'Keterangan' => $jsonData['Keterangan'], 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);
	
						array_push($arrDetail, $temp);
					}
					else if ($key['TypeItem'] == 5) {
						// Penjualan
						$getSetting = $Setting->GetSetting("InvAcctPendapatanJual");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();
	
						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}
	
						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $key['TotalPenjualan'], 
							'Keterangan' => $jsonData['Keterangan'], 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);
	
						array_push($arrDetail, $temp);
						// Penjualan
						// Hutang Dagang Belum diakui
						$getSetting = $Setting->GetSetting("KnAcctPenerimaanKonsinyasi");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();

						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Konsnyasi Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}
	
						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $key['TotalHPP'], 
							'Keterangan' => "Hutang Konsinyasi", 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);
	
						array_push($arrDetail, $temp);
						// Hutang Dagang Belum diakui

						// Hutang
						$getSetting = $Setting->GetSetting("KnAcctHutangKonsinyasi");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();

						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Hutang Konsnyasi Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}
	
						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $key['TotalHPP'], 
							'Keterangan' => "Hutang Konsinyasi", 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);
	
						array_push($arrDetail, $temp);
						// Hutang
					}
					else{
						$data['message'] = "Akun Rekening Akutansi Tidak Valid ";
						$errorCount +=1;
						goto jump;
					}
	
					// GIT
					// GetAccount :
					$Setting = NEW SettingAccount();
					// $getSetting = $Setting->GetSetting("InvAcctPersediaan");
					$getSetting = $Setting->GetInventoryAccount($key["KodeItem"]);
					
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Inventory Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					// Hutang

					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalHPP'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End GIT
	
					// HPP
					// GetAccount :
					$Setting = NEW SettingAccount();
					$getSetting = $Setting->GetSetting("InvAcctHargaPokokPenjualan");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();
	
					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Harga Pokok Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}
	
					// Hutang
	
					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalHPP'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);
	
					array_push($arrDetail, $temp);
					// End HPP
				}
	
				// Pembayaran $jsonData['MetodeBayar']
				// GetAccount :
				$Setting = NEW SettingAccount();
				$getSetting = $Setting->GetSetting("PjAcctPiutang");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();
	
				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}
	
				// Piutang
	
				$temp = array(
					'KodeTransaksi' => "OINV", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 1 : 2,  
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $JurnalTotalPembelian, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);
	
				array_push($arrDetail, $temp);
				// End Piutang
	
				// Pembayaran
				$metode = MetodePembayaran::selectRaw("COALESCE(metodepembayaran.AkunPembayaran, '') AkunPembayaran")
								->where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('id', $jsonData['MetodeBayar'])->first();
	
				if ($metode->AkunPembayaran == "" && $oCompany->isPostingAkutansi == 1) {
					$data['message'] = "Akun Rekening Akutansi Pembayaran Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Metode Pembayaran";
					$errorCount += 1;
					goto jump;
				}
	
				$temp = array(
					'KodeTransaksi' => "OINV", 
					'KodeRekening' => $metode->AkunPembayaran,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $jsonData['TotalPembayaran'], 
					'Keterangan' => $jsonData['ReffPembayaran'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);
	
				array_push($arrDetail, $temp);
				// End Pembayran

				// Kembalian
				$JurnalKembalian = $jsonData['TotalPembayaran'] - $JurnalTotalPembelian;
				if($oKembalian > 0){
					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $metode->AkunPembayaran,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $JurnalKembalian, 
						'Keterangan' => "Kembalian Pembayaran", 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);
		
					array_push($arrDetail, $temp);
				}
				// End Kembalian

				// Konsinyasi

				// End Konsinyasi
				// Save Journal
				$autoPosting = new AutoPosting();
	
				if ($autoPosting->Auto($arrHeader, $arrDetail,($jsonData['Status']== "D") ? true : false) != "OK") {
					$data["message"] = "Gagal Simpan Jurnal";
					$errorCount +=1;
					goto jump;
				}
				// End Save Jurnal
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

	public function storeJson(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
		Log::debug($request->all());
		DB::beginTransaction();

		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
		
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
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("OINV","fakturpenjualanheader","NoTransaksi");

	        $model = new FakturPenjualanHeader;

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;
	        $model->Transaksi= 'TRX';

	        $model->Periode = $Year.$Month;
	        $model->NoTransaksi= $NoTransaksi;
	        $model->Transaksi= 'PJL';
	        $model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->TglJatuhTempo = $jsonData['TglJatuhTempo'];
			$model->NoReff = $jsonData['NoReff'];
			$model->KodePelanggan = $jsonData['KodePelanggan'];
			$model->KodeTermin = $jsonData['KodeTermin'];
			$model->Termin = $jsonData['Termin'];
			$model->Status = $jsonData['Status'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->MetodeBayar = empty($jsonData['MetodeBayar']) ? "" : $jsonData['MetodeBayar'];
			$model->ReffPembayaran = empty($jsonData['ReffPembayaran']) ? "" : $jsonData['ReffPembayaran'];
			$model->KodeSales = empty($jsonData['KodeSales']) ? "" : $jsonData['KodeSales'];
			$model->Posted = 0;
			$model->CreatedBy = Auth::user()->name;
			$model->UpdatedBy = "";
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;
   			
            // CalculateTotal
            $TotalTransaksi = 0;
            $Potongan = 0;
            $Pajak = 0;
            $TotalPembelian =0;
            $TotalRetur = 0;
            $TotalPembayaran = 0;

            foreach ($jsonData['Detail'] as $key) {

            	if ($key['Discount'] ==0) {
					$TotalTransaksi += $key['Qty'] * $key['Harga'];
				}
				else{
					$TotalTransaksi += $key['Qty'] * $key['Harga'];

					$HargaGros = $key['Qty'] * $key['Harga'];

					$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
					$Potongan += $diskon;
				}

				if ($key['VatPercent'] > 0) {
					$HargaGros = $key['Qty'] * $key['Harga'];
					$Pajak += ($key['VatPercent'] / 100) * $HargaGros;
				}
            }

            $model->TotalTransaksi = $TotalTransaksi;
			$model->Potongan = $Potongan;
			$model->Pajak = $Pajak;
			$model->TotalPembelian = $TotalTransaksi - $Potongan + $Pajak;
			$model->TotalRetur = $TotalRetur;
			$model->TotalPembayaran = $TotalPembayaran;
            // End CalculateTotal

			$save = $model->save();

			$BaseReff = "";

			foreach ($jsonData['Detail'] as $key) {
				$BaseReff = empty($key['BaseReff']) ? "" : $key['BaseReff'];
				if ($key['Qty'] == 0) {
					goto skip;
				}

				if ($oCompany) {
					if ($key['BaseReff'] == "") {
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

						if ($key['KodeGudang'] == "") {
							$data['message'] = "Gudang Harus diisi";
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

				$modelDetail = new FakturPenjualanDetail;
           		$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $key['NoUrut'];
				$modelDetail->KodeItem = $key['KodeItem'];
				$modelDetail->Qty = $key['Qty'];
				$modelDetail->QtyKonversi = $key['QtyKonversi'];
				$modelDetail->Satuan = $key['Satuan'];
				$modelDetail->Harga = $key['Harga'];
				$modelDetail->VatPercent = $key['VatPercent'];
				$modelDetail->Discount = $key['Discount'];

				$modelDetail->BaseReff = empty($key['BaseReff']) ? "" : $key['BaseReff'];
				$modelDetail->BaseLine = $key['BaseLine'];
				$modelDetail->KodeGudang = $key['KodeGudang'];
				$modelDetail->VatPercent = $key['VatPercent'];
				$modelDetail->HargaPokokPenjualan = $key['HargaPokokPenjualan'];

				$HargaGros = $key['Qty'] * $key['Harga'];
				$modelDetail->HargaNet = $HargaGros - floatval($key['Discount']);
				$modelDetail->LineStatus = $key['LineStatus'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				if ($key['Discount'] ==0) {
					$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
				}
				else{
					$HargaGros = $key['Qty'] * $key['Harga'];
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
				skip:
			}

			// Auto Journal

			// Generate Header :

			$arrHeader = array(
						'NoTransaksi' => "",
						'KodeTransaksi' => "OINV",
						'TglTransaksi' => $jsonData['TglTransaksi'],
						'NoReff' => $NoTransaksi,
						'StatusTransaksi' => "O",
						'RecordOwnerID' => Auth::user()->RecordOwnerID,
					);
			$arrDetail = array();

			// CalculateTotal
            $JurnalTotalTransaksi = 0;
            $JurnalPotongan = 0;
            $JurnalPajak = 0;
            $JurnalTotalPembelian =0;

            foreach ($jsonData['Detail'] as $key) {
		
				if ($key['Discount'] ==0) {
					$JurnalTotalTransaksi += $key['Qty'] * $key['Harga'];
				}
				else{
					$JurnalTotalTransaksi += $key['Qty'] * $key['Harga'];

					$HargaGros = $key['Qty'] * $key['Harga'];

					$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
					$JurnalPotongan += $diskon;
				}

				if ($key['VatPercent'] > 0) {
					$HargaGros = $key['Qty'] * $key['Harga'];
					$JurnalPajak += ($key['VatPercent'] / 100) * $HargaGros;
				}
			}
			$JurnalTotalPembelian = $JurnalTotalTransaksi - $JurnalPotongan + $JurnalPajak;
            // End CalculateTotal
			// GetAccount :
			$Setting = NEW SettingAccount();
			$getSetting = $Setting->GetSetting("PjAcctPiutang");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
				$errorCount +=1;
				goto jump;
			}

			// Piutang

			$temp = array(
				'KodeTransaksi' => "OINV", 
				'KodeRekening' => $getSetting,
				'KodeRekeningBukuBesar' => "",
				'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
				'KodeMataUang' => "",
				'Valas' => 0,
				'NilaiTukar' => 0,
				'Jumlah' => $JurnalTotalPembelian, 
				'Keterangan' => $jsonData['Keterangan'], 
				'HeaderKas' => "",
				'RecordOwnerID' =>  Auth::user()->RecordOwnerID
			);

			array_push($arrDetail, $temp);
			// End Piutang

			if ($JurnalPajak > 0) {
				// GetAccount :
				$Setting = NEW SettingAccount();
				$getSetting = $Setting->GetSetting("PjAcctPajakPenjualan");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();

				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}

				// PPN

				$temp = array(
					'KodeTransaksi' => "OINV", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $JurnalPajak, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				// End PPN
			}

			// Penjualan

			$getPenjualanvalue = DeliveryNoteDetail::selectRaw('itemmaster.TypeItem, SUM(deliverynotedetail.HargaNet) TotalPenjualan, SUM(deliverynotedetail.HargaPokokPenjualan * deliverynotedetail.Qty) TotalHPP')
					->leftJoin('itemmaster', function ($value){
    					$value->on('deliverynotedetail.KodeItem','=','itemmaster.KodeItem')
    					->on('deliverynotedetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
    				})
    				->where('deliverynotedetail.NoTransaksi', $BaseReff)
    				->where('deliverynotedetail.RecordOwnerID', Auth::user()->RecordOwnerID)
    				->groupBy('itemmaster.TypeItem')
    				->get();
    		// var_dump($BaseReff);

    		if ($BaseReff == "") {
    			$getPenjualanvalue = FakturPenjualanDetail::selectRaw("itemmaster.KodeItem,itemmaster.TypeItem, SUM(fakturpenjualandetail.HargaNet) TotalPenjualan, SUM(fakturpenjualandetail.HargaPokokPenjualan * fakturpenjualandetail.Qty) TotalHPP")
    				->leftJoin('itemmaster', function ($value){
    					$value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
    					->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
    				})
    				->where('fakturpenjualandetail.NoTransaksi', $jsonData['NoTransaksi'])
    				->where('fakturpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)
    				->groupBy('itemmaster.TypeItem','itemmaster.KodeItem')
    				->get();
    		}
			foreach ($getPenjualanvalue as $key) {
				if ($key['TypeItem'] == 1) {
					$getSetting = $Setting->GetSetting("InvAcctPendapatanJual");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalPenjualan'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
				}
				else if ($key['TypeItem'] == 4) {
					$getSetting = $Setting->GetSetting("InvAcctPendapatanJasa");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Penjualan Jasa Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalPenjualan'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
				}
				else{
					$data['message'] = "Akun Rekening Akutansi Tidak Valid ";
					$errorCount +=1;
					goto jump;
				}

				if ($BaseReff != "") {
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
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalHPP'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End GIT
				}
				else{
					// GIT
					// GetAccount :
					$Setting = NEW SettingAccount();
					// $getSetting = $Setting->GetSetting("InvAcctPersediaan");
					$getSetting = $Setting->GetInventoryAccount($key["KodeItem"]);
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Inventory Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					// Hutang

					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalHPP'], 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End GIT
				}

				// HPP
				// GetAccount :
				$Setting = NEW SettingAccount();
				$getSetting = $Setting->GetSetting("InvAcctHargaPokokPenjualan");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();

				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Harga Pokok Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}

				// Hutang

				$temp = array(
					'KodeTransaksi' => "OINV", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $key['TotalHPP'], 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				// End HPP
			}

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

	public function editJson(Request $request)
   {
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

       Log::debug($request->all());
       DB::beginTransaction();

       $errorCount = 0;
       $jsonData = $request->json()->all();

       $oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();

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

                if (count($jsonData['Detail']) > 0) {
                	$delete = DB::table('fakturpenjualandetail')
		                        ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
		                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
		                        ->delete();

		            $BaseReff="";
		            foreach ($jsonData['Detail'] as $key) {
		            	$BaseReff = empty($key['BaseReff']) ? "" : $key['BaseReff'];
		            	if ($key['Qty'] == 0) {
							goto skip;
						}

						if ($oCompany) {
							if ($key['BaseReff'] == "") {
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

								if ($key['KodeGudang'] == "") {
									$data['message'] = "Gudang Harus diisi";
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

						$modelDetail = new FakturPenjualanDetail;
		           		$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->NoUrut = $key['NoUrut'];
						$modelDetail->KodeItem = $key['KodeItem'];
						$modelDetail->Qty = $key['Qty'];
						$modelDetail->QtyKonversi = $key['QtyKonversi'];
						$modelDetail->Satuan = $key['Satuan'];
						$modelDetail->Harga = $key['Harga'];
						$modelDetail->VatPercent = $key['VatPercent'];
						$modelDetail->Discount = $key['Discount'];

						$modelDetail->BaseReff = empty($key['BaseReff']) ? "" : $key['BaseReff'];
						$modelDetail->BaseLine = $key['BaseLine'];
						$modelDetail->KodeGudang = $key['KodeGudang'];
						$modelDetail->VatPercent = $key['VatPercent'];
						$modelDetail->HargaPokokPenjualan = $key['HargaPokokPenjualan'];

						$HargaGros = $key['Qty'] * $key['Harga'];
						$modelDetail->HargaNet = $HargaGros - floatval($key['Discount']);
						$modelDetail->LineStatus = $key['LineStatus'];
						$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

						if ($key['Discount'] ==0) {
							$modelDetail->HargaNet = $key['Qty'] * $key['Harga'];
						}
						else{
							$HargaGros = $key['Qty'] * $key['Harga'];
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
						skip:
		            }

		            // Auto Journal

					// Generate Header :

					// CalculateTotal
					$JurnalTotalTransaksi = 0;
					$JurnalPotongan = 0;
					$JurnalPajak = 0;
					$JurnalTotalPembelian =0;
		
					foreach ($jsonData['Detail'] as $key) {
		
						if ($key['Discount'] ==0) {
							$JurnalTotalTransaksi += $key['Qty'] * $key['Harga'];
						}
						else{
							$JurnalTotalTransaksi += $key['Qty'] * $key['Harga'];
		
							$HargaGros = $key['Qty'] * $key['Harga'];
		
							$diskon = $HargaGros - ($HargaGros * $key['Discount'] / 100);
							$JurnalPotongan += $diskon;
						}
		
						if ($key['VatPercent'] > 0) {
							$HargaGros = $key['Qty'] * $key['Harga'];
							$JurnalPajak += ($key['VatPercent'] / 100) * $HargaGros;
						}
					}

					$JurnalTotalPembelian = $JurnalTotalTransaksi - $JurnalPotongan + $JurnalPajak;
					// End CalculateTotal
					
					$arrHeader = array(
								'NoTransaksi' => "",
								'KodeTransaksi' => "OINV",
								'TglTransaksi' => $jsonData['TglTransaksi'],
								'NoReff' => $jsonData['NoTransaksi'],
								'StatusTransaksi' => "O",
								'RecordOwnerID' => Auth::user()->RecordOwnerID,
							);
					$arrDetail = array();

					// GetAccount :
					$Setting = NEW SettingAccount();
					$getSetting = $Setting->GetSetting("PjAcctPiutang");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
						$errorCount +=1;
						goto jump;
					}

					// Piutang

					$temp = array(
						'KodeTransaksi' => "OINV", 
						'KodeRekening' => $getSetting,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $JurnalTotalPembelian, 
						'Keterangan' => $jsonData['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					// End Piutang

					if ($JurnalPajak > 0) {
						// GetAccount :
						$Setting = NEW SettingAccount();
						$getSetting = $Setting->GetSetting("PjAcctPajakPenjualan");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();

						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}

						// PPN

						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $JurnalPajak, 
							'Keterangan' => $jsonData['Keterangan'], 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);

						array_push($arrDetail, $temp);
						// End PPN
					}

					// Penjualan

					$getPenjualanvalue = DeliveryNoteDetail::selectRaw('itemmaster.TypeItem, SUM(deliverynotedetail.HargaNet) TotalPenjualan, SUM(deliverynotedetail.HargaPokokPenjualan * deliverynotedetail.Qty) TotalHPP')
							->leftJoin('itemmaster', function ($value){
	        					$value->on('deliverynotedetail.KodeItem','=','itemmaster.KodeItem')
	        					->on('deliverynotedetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
	        				})
	        				->where('deliverynotedetail.NoTransaksi', $BaseReff)
	        				->where('deliverynotedetail.RecordOwnerID', Auth::user()->RecordOwnerID)
	        				->groupBy('itemmaster.TypeItem')
	        				->get();
	        		// var_dump($getPenjualanvalue);

	        		if ($BaseReff == "") {
	        			$getPenjualanvalue = FakturPenjualanDetail::selectRaw("itemmaster.KodeItem,itemmaster.TypeItem, SUM((fakturpenjualandetail.Qty * fakturpenjualandetail.Harga) - fakturpenjualandetail.Discount) TotalPenjualan, SUM(fakturpenjualandetail.HargaPokokPenjualan * fakturpenjualandetail.Qty) TotalHPP")
	        				->leftJoin('itemmaster', function ($value){
	        					$value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
	        					->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
	        				})
	        				->where('fakturpenjualandetail.NoTransaksi', $jsonData['NoTransaksi'])
	        				->where('fakturpenjualandetail.RecordOwnerID', Auth::user()->RecordOwnerID)
	        				->groupBy('itemmaster.TypeItem','itemmaster.KodeItem')
	        				->get();
	        		}
					foreach ($getPenjualanvalue as $key) {
						if ($key['TypeItem'] == 1) {
							$getSetting = $Setting->GetSetting("InvAcctPendapatanJual");
							$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
											->where('KodeRekening', $getSetting)->get();

							if (count($validate) == 0) {
								$data['message'] = "Akun Rekening Akutansi Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
								$errorCount +=1;
								goto jump;
							}

							$temp = array(
								'KodeTransaksi' => "OINV", 
								'KodeRekening' => $getSetting,
								'KodeRekeningBukuBesar' => "",
								'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
								'KodeMataUang' => "",
								'Valas' => 0,
								'NilaiTukar' => 0,
								'Jumlah' => $key['TotalPenjualan'], 
								'Keterangan' => $jsonData['Keterangan'], 
								'HeaderKas' => "",
								'RecordOwnerID' =>  Auth::user()->RecordOwnerID
							);

							array_push($arrDetail, $temp);
						}
						else if ($key['TypeItem'] == 4) {
							$getSetting = $Setting->GetSetting("InvAcctPendapatanJasa");
							$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
											->where('KodeRekening', $getSetting)->get();

							if (count($validate) == 0) {
								$data['message'] = "Akun Rekening Akutansi Penjualan Jasa Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
								$errorCount +=1;
								goto jump;
							}

							$temp = array(
								'KodeTransaksi' => "OINV", 
								'KodeRekening' => $getSetting,
								'KodeRekeningBukuBesar' => "",
								'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
								'KodeMataUang' => "",
								'Valas' => 0,
								'NilaiTukar' => 0,
								'Jumlah' => $key['TotalPenjualan'], 
								'Keterangan' => $jsonData['Keterangan'], 
								'HeaderKas' => "",
								'RecordOwnerID' =>  Auth::user()->RecordOwnerID
							);

							array_push($arrDetail, $temp);
						}
						else{
							$data['message'] = "Akun Rekening Akutansi Tidak Valid ";
							$errorCount +=1;
							goto jump;
						}

						if ($BaseReff != "") {
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
								'KodeTransaksi' => "OINV", 
								'KodeRekening' => $getSetting,
								'KodeRekeningBukuBesar' => "",
								'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
								'KodeMataUang' => "",
								'Valas' => 0,
								'NilaiTukar' => 0,
								'Jumlah' => $key['TotalHPP'], 
								'Keterangan' => $jsonData['Keterangan'], 
								'HeaderKas' => "",
								'RecordOwnerID' =>  Auth::user()->RecordOwnerID
							);

							array_push($arrDetail, $temp);
							// End GIT
						}
						else{
							// GIT
							// GetAccount :
							$Setting = NEW SettingAccount();
							// $getSetting = $Setting->GetSetting("InvAcctPersediaan");
							$getSetting = $Setting->GetInventoryAccount($key["KodeItem"]);
							$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
											->where('KodeRekening', $getSetting)->get();

							if (count($validate) == 0) {
								$data['message'] = "Akun Rekening Akutansi Inventory Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
								$errorCount +=1;
								goto jump;
							}

							// Hutang

							$temp = array(
								'KodeTransaksi' => "OINV", 
								'KodeRekening' => $getSetting,
								'KodeRekeningBukuBesar' => "",
								'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
								'KodeMataUang' => "",
								'Valas' => 0,
								'NilaiTukar' => 0,
								'Jumlah' => $key['TotalHPP'], 
								'Keterangan' => $jsonData['Keterangan'], 
								'HeaderKas' => "",
								'RecordOwnerID' =>  Auth::user()->RecordOwnerID
							);

							array_push($arrDetail, $temp);
							// End GIT
						}

						// HPP
						// GetAccount :
						$Setting = NEW SettingAccount();
						$getSetting = $Setting->GetSetting("InvAcctHargaPokokPenjualan");
						$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
										->where('KodeRekening', $getSetting)->get();

						if (count($validate) == 0) {
							$data['message'] = "Akun Rekening Akutansi Harga Pokok Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
							$errorCount +=1;
							goto jump;
						}

						// Hutang

						$temp = array(
							'KodeTransaksi' => "OINV", 
							'KodeRekening' => $getSetting,
							'KodeRekeningBukuBesar' => "",
							'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
							'KodeMataUang' => "",
							'Valas' => 0,
							'NilaiTukar' => 0,
							'Jumlah' => $key['TotalHPP'], 
							'Keterangan' => $jsonData['Keterangan'], 
							'HeaderKas' => "",
							'RecordOwnerID' =>  Auth::user()->RecordOwnerID
						);

						array_push($arrDetail, $temp);
						// End HPP
					}

					// Save Journal
					$autoPosting = new AutoPosting();

					if ($autoPosting->Auto($arrHeader, $arrDetail,($jsonData['Status']== "D") ? true : false) != "OK") {
						$data["message"] = "Gagal Simpan Jurnal";
						$errorCount +=1;
						goto jump;
					}
					// End Save Jurnal
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

   public function EditTransactionStatus(Request $request)
   {
   		$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

   		$NoTransaksi = $request->input('NoTransaksi');
   		$Status = $request->input('Status');
   		
   		try {
   			$model = FakturPenjualanHeader::where('NoTransaksi','=',$NoTransaksi)
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
   
	       	if ($model) {
	           $update = DB::table('fakturpenjualanheader')
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

   function CetakFaktur($NoTransaksi = null) {
	$sql = "DISTINCT fakturpenjualanheader.NoTransaksi, DATE_FORMAT(fakturpenjualanheader.TglTransaksi, '%d-%m-%Y %H:%i') TglTransaksi,
			fakturpenjualanheader.TglJatuhTempo, fakturpenjualanheader.NoReff, 
			fakturpenjualanheader.KodePelanggan, pelanggan.NamaPelanggan, fakturpenjualanheader.Termin, 
			terminpembayaran.NamaTermin, fakturpenjualanheader.TotalPembelian, fakturpenjualanheader.Pajak,
			fakturpenjualanheader.TotalPembayaran, fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur TotalHutang, 
			fakturpenjualanheader.TotalRetur,fakturpenjualandetail.NoUrut, fakturpenjualandetail.KodeItem,
			itemmaster.NamaItem,fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.Discount,
			fakturpenjualandetail.HargaNet, fakturpenjualandetail.VatPercent,  COALESCE(pelanggan.Alamat,'') Alamat, 
			coalesce(pelanggan.NoTlp1) NoTlpPelanggan,COALESCE(pelanggan.Email,'') Email,
	   		CASE WHEN fakturpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
   				CASE WHEN fakturpenjualanheader.Status = 'T' THEN 'DRAFT' ELSE 
   					CASE WHEN fakturpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE
   						CASE WHEN  fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur <= 0 && fakturpenjualanheader.TotalRetur = 0 THEN 'LUNAS' ELSE
   							CASE WHEN  fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur > 0 THEN 'BELUM LUNAS' ELSE 
   								CASE WHEN fakturpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE '' END
   							END
   						END
   					END
   				END
   			END AS StatusDocument, fakturpenjualanheader.Transaksi, company.NamaPartner, company.AlamatTagihan,
			company.NoTlp, company.NoHP, company.icon,fakturpenjualanheader.TotalTransaksi, 
			fakturpenjualanheader.Potongan, company.NPWP, '' CompanyEmail ";
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
					->leftJoin('itemmaster', function ($value){
    					$value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
    					->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
    				})
					->leftJoin('company', 'company.KodePartner', 'fakturpenjualanheader.RecordOwnerID')
    				->where('fakturpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID)
					->where('fakturpenjualanheader.NoTransaksi',$NoTransaksi)->get();
	$oCompany = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
	return view("Transaksi.Penjualan.slip.".$oCompany['DefaultSlip'],[
		'faktur'=> $model
	]);
   }

   function PrintThermalReciept($NoTransaksi = null){
	$sql = "DISTINCT fakturpenjualanheader.NoTransaksi, DATE_FORMAT(fakturpenjualanheader.TglTransaksi, '%d-%m-%Y %H:%i') TglTransaksi,
		fakturpenjualanheader.TglJatuhTempo, fakturpenjualanheader.NoReff, 
		fakturpenjualanheader.KodePelanggan, pelanggan.NamaPelanggan, fakturpenjualanheader.Termin, 
		terminpembayaran.NamaTermin, fakturpenjualanheader.TotalPembelian, fakturpenjualanheader.Pajak,
		fakturpenjualanheader.TotalPembayaran, fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur TotalHutang, 
		fakturpenjualanheader.TotalRetur,fakturpenjualandetail.NoUrut, fakturpenjualandetail.KodeItem,
		itemmaster.NamaItem,fakturpenjualandetail.Qty, fakturpenjualandetail.Harga, fakturpenjualandetail.Discount,
		fakturpenjualandetail.HargaNet, fakturpenjualandetail.VatPercent,  COALESCE(pelanggan.Alamat,'') Alamat, 
		coalesce(pelanggan.NoTlp1) NoTlpPelanggan,COALESCE(pelanggan.Email,'') Email,
		CASE WHEN fakturpenjualanheader.Status = 'O' THEN 'OPEN' ELSE 
			CASE WHEN fakturpenjualanheader.Status = 'T' THEN 'DRAFT' ELSE 
				CASE WHEN fakturpenjualanheader.Status = 'D' THEN 'CANCEL' ELSE
					CASE WHEN  fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur <= 0 && fakturpenjualanheader.TotalRetur = 0 THEN 'LUNAS' ELSE
						CASE WHEN  fakturpenjualanheader.TotalPembelian - COALESCE(fakturpenjualanheader.TotalPembayaran,0) - fakturpenjualanheader.TotalRetur > 0 THEN 'BELUM LUNAS' ELSE 
							CASE WHEN fakturpenjualanheader.Status = 'C' THEN 'CLOSE' ELSE '' END
						END
					END
				END
			END
		END AS StatusDocument, fakturpenjualanheader.Transaksi, company.NamaPartner, company.AlamatTagihan,
		company.NoTlp, company.NoHP, company.icon,fakturpenjualanheader.TotalTransaksi, 
		fakturpenjualanheader.Potongan, company.NPWP, '' CompanyEmail, fakturpenjualanheader.CreatedBy AS Cashier,
		metodepembayaran.NamaMetodePembayaran, fakturpenjualanheader.ReffPembayaran ";
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
				->leftJoin('itemmaster', function ($value){
					$value->on('fakturpenjualandetail.KodeItem','=','itemmaster.KodeItem')
					->on('fakturpenjualandetail.RecordOwnerID','=','itemmaster.RecordOwnerID');
				})
				->leftJoin('company', 'company.KodePartner', 'fakturpenjualanheader.RecordOwnerID')
				->leftJoin('metodepembayaran', function ($value){
					$value->on('fakturpenjualanheader.MetodeBayar','=','metodepembayaran.id')
					->on('fakturpenjualanheader.RecordOwnerID','=','metodepembayaran.RecordOwnerID');
				})
				->where('fakturpenjualanheader.RecordOwnerID',Auth::user()->RecordOwnerID)
				->where('fakturpenjualanheader.NoTransaksi',$NoTransaksi)->get();
	$oCompany = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
	$oPrinter = Printer::where('RecordOwnerID', Auth::user()->RecordOwnerID)
					->where('DeviceAddress', $oCompany['NamaPosPrinter'])
					->first();

	if($oPrinter['PrinterInterface'] == "USB"){
		// Masuk USB
		return view("Transaksi.Penjualan.slip.thermal".$oCompany['LebarKertas']."usb",[
			'faktur'=> $model,
			'company' => $oCompany,
			'printer' => $oPrinter
		]);
	}
	elseif ($oPrinter['PrinterInterface'] == "Bluetooth") {
		// Bluethod
	}
	
   }
}
