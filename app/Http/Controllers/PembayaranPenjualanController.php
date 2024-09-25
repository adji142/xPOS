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

use App\Models\Company;
use App\Models\AutoPosting;
use App\Models\SettingAccount;
use App\Models\Rekening;
use App\Models\ItemMaster;

use Midtrans\Config;
use Midtrans\Snap;

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
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$model = new PembayaranPenjualanHeader;
	           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("INPAY","pembayaranpenjualanheader","NoTransaksi");

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
					$data['message'] = "Nomor Faktur "+ $key['NoTransaksi'] +" Total Pembayaran Melebihi Nilai Piutang";
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

			// Auto Posting
			$arrHeader = array(
				'NoTransaksi' => "",
				'KodeTransaksi' => "INPAY",
				'TglTransaksi' => $jsonData['TglTransaksi'],
				'NoReff' => $NoTransaksi,
				'StatusTransaksi' => "O",
				'RecordOwnerID' => Auth::user()->RecordOwnerID,
			);
			$arrDetail = array();

			// Pembayaran
			$TotalLawanPembayaran = 0;
			foreach ($jsonData['Detail'] as $key) {
				// Get Pembayaran Account
				$metode = MetodePembayaran::selectRaw("COALESCE(metodepembayaran.AkunPembayaran, '') AkunPembayaran")
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('id', $key['KodeMetodePembayaran'])->first();

				if ($metode->AkunPembayaran == "" && $oCompany->isPostingAkutansi == 1) {
					$data['message'] = "Akun Rekening Akutansi Pembayaran Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Metode Pembayaran";
					$errorCount += 1;
					goto jump;
				}

				$temp = array(
					'KodeTransaksi' => "INPAY", 
					'KodeRekening' => $metode->AkunPembayaran,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $key['TotalPembayaran'], 
					'Keterangan' => $key['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				$TotalLawanPembayaran +=  $key['TotalPembayaran'];
			}
			// End Pembayaran

			// Piutang
			$Setting = new SettingAccount();
			$getSetting = $Setting->GetSetting("PjAcctPiutang");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				$data['message'] = "Akun Rekening Akutansi Piutang Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
				$errorCount +=1;
				goto jump;
			}

			$temp = array(
				'KodeTransaksi' => "INPAY", 
				'KodeRekening' => $getSetting,
				'KodeRekeningBukuBesar' => "",
				'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
				'KodeMataUang' => "",
				'Valas' => 0,
				'NilaiTukar' => 0,
				'Jumlah' => $TotalLawanPembayaran, 
				'Keterangan' => $jsonData['Keterangan'], 
				'HeaderKas' => "",
				'RecordOwnerID' =>  Auth::user()->RecordOwnerID
			);

			array_push($arrDetail, $temp);
			// End Piutang

			// Save Journal
			$autoPosting = new AutoPosting();

			if ($autoPosting->Auto($arrHeader, $arrDetail, ($jsonData['Status']== "D") ? true : false) != "OK") {
				$data["message"] = "Gagal Simpan Jurnal";
				$errorCount +=1;
				goto jump;
			}
			// End Save Jurnal
			// Auto Posting


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

                // Auto Posting
				$arrHeader = array(
					'NoTransaksi' => "",
					'KodeTransaksi' => "INPAY",
					'TglTransaksi' => $jsonData['TglTransaksi'],
					'NoReff' => $jsonData['NoTransaksi'],
					'StatusTransaksi' => "O",
					'RecordOwnerID' => Auth::user()->RecordOwnerID,
				);
				$arrDetail = array();

				// Pembayaran
				$TotalLawanPembayaran = 0;
				foreach ($jsonData['Detail'] as $key) {
					// Get Pembayaran Account
					$metode = MetodePembayaran::selectRaw("COALESCE(metodepembayaran.AkunPembayaran, '') AkunPembayaran")
								->where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('id', $key['KodeMetodePembayaran'])->first();

					if ($metode->AkunPembayaran == "" && $oCompany->isPostingAkutansi == 1) {
						$data['message'] = "Akun Rekening Akutansi Pembayaran Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Metode Pembayaran";
						$errorCount += 1;
						goto jump;
					}

					$temp = array(
						'KodeTransaksi' => "INPAY", 
						'KodeRekening' => $metode->AkunPembayaran,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalPembayaran'], 
						'Keterangan' => $key['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					$TotalLawanPembayaran +=  $key['TotalPembayaran'];
				}
				// End Pembayaran

				// Piutang
				$Setting = new SettingAccount();
				$getSetting = $Setting->GetSetting("PjAcctPiutang");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();

				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Piutang Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}

				$temp = array(
					'KodeTransaksi' => "INPAY", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $TotalLawanPembayaran, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				// End Piutang

				// Save Journal
				$autoPosting = new AutoPosting();

				if ($autoPosting->Auto($arrHeader, $arrDetail, ($jsonData['Status']== "D") ? true : false) != "OK") {
					$data["message"] = "Gagal Simpan Jurnal";
					$errorCount +=1;
					goto jump;
				}
				// End Save Jurnal
				// Auto Posting

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

	public function createMidTransTransaction(Request $request)
    {
		$jsonData = $request->json()->all();

		$MetodeBayar = $jsonData['MetodeBayar'];
		$KodePelanggan = $jsonData['KodePelanggan'];
		$TotalPembelian = $jsonData['TotalPembelian'];

		$GetSetting = MetodePembayaran::where('RecordOwnerID',  Auth::user()->RecordOwnerID)
						->where('id', $MetodeBayar)
						->get();
		$oCompany = Company::where('KodePartner','=',Auth::user()->RecordOwnerID)->first();
		
		if(count($GetSetting) > 0){
			Config::$serverKey = $GetSetting[0]['ServerKey'];
			Config::$isProduction = config('midtrans.is_production');
			Config::$isSanitized = config('midtrans.is_sanitized');
			Config::$is3ds = config('midtrans.is_3ds');

			// Get Customer

			$Pelanggan = Pelanggan::where('KodePelanggan', $KodePelanggan)
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->get();

			if($KodePelanggan == ""){
				return response()->json(['error' => "Pelanggan Belum diisi"]);
			}
			// Run Validation
			// Jumlah Detail
			if (count($jsonData['Detail']) == 0) {
				return response()->json(['error' => "Data Detail Tidak boleh Kosong"]);
			}

			foreach ($jsonData['Detail'] as $key) {
				$itemMaster = ItemMaster::where('KodeItem', $key['KodeItem'])
								->where('RecordOwnerID',Auth::user()->RecordOwnerID)
								->get();
				// Stock
				if ($oCompany) {
					if ($oCompany->AllowNegativeInventory == NULL || $oCompany->AllowNegativeInventory == 'N') {
						$oItem = ItemMaster::where('RecordOwnerID',Auth::user()->RecordOwnerID)
									->where('KodeItem',$key['KodeItem'])
									->where('Stock','>',0)
									->get();

						if (count($oItem) == 0) {
							return response()->json(['error' => "Stock Item ".$key['KodeItem'].' Tidak Cukup']);
						}
					}
				}
				else{
					return response()->json(['error' => "Partner Tidak ditemukan"]);
				}

				// Persediaan

				$Setting = NEW SettingAccount();
				$getSetting = $Setting->GetInventoryAccount($key["KodeItem"]);
				
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();

				if (count($validate) == 0) {
					return response()->json(['error' => "Akun Rekening Akutansi Inventory Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
				}

				if ($itemMaster[0]['TypeItem'] == 1) {
					// Akun Akutansi Penjualan
					$getSetting = $Setting->GetSetting("InvAcctPendapatanJual");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						return response()->json(['error' => "Akun Rekening Akutansi Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
					}
				}
				elseif ($itemMaster[0]['TypeItem'] == 4) {
					// Akun Akutansi Pendapatan Jasa
					$getSetting = $Setting->GetSetting("InvAcctPendapatanJasa");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						return response()->json(['error' => "Akun Rekening Akutansi Penjualan Jasa Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
					}
				}
				elseif ($itemMaster[0]['TypeItem'] == 5) {
					// Akun Akutansi Konsinyasi

					$getSetting = $Setting->GetSetting("KnAcctPenerimaanKonsinyasi");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						return response()->json(['error' => "Akun Rekening Akutansi Konsnyasi Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
					}

					// Akun Akutansi Hutang

					$getSetting = $Setting->GetSetting("KnAcctHutangKonsinyasi");
					$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
									->where('KodeRekening', $getSetting)->get();

					if (count($validate) == 0) {
						return response()->json(['error' => "Akun Rekening Akutansi Hutang Konsnyasi Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
					}
				}
			}

			// Akun Akutansi Piutang
			$Setting = NEW SettingAccount();
			$getSetting = $Setting->GetSetting("PjAcctPiutang");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				return response()->json(['error' => "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
			}

			// Akun Akutansi PPN
			$Setting = NEW SettingAccount();
			$getSetting = $Setting->GetSetting("PjAcctPajakPenjualan");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				return response()->json(['error' => "Akun Rekening Akutansi Piutang Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
			}

			// Harga Pokok
			$Setting = NEW SettingAccount();
			$getSetting = $Setting->GetSetting("InvAcctHargaPokokPenjualan");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				return response()->json(['error' => "Akun Rekening Akutansi Harga Pokok Penjualan Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account"]);
			}

			// Pembayaran
			$metode = MetodePembayaran::selectRaw("COALESCE(metodepembayaran.AkunPembayaran, '') AkunPembayaran")
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)
						->where('id', $jsonData['MetodeBayar'])->first();

			if ($metode->AkunPembayaran == "" && $oCompany->isPostingAkutansi == 1) {
				return response()->json(['error' => "Akun Rekening Akutansi Pembayaran Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Metode Pembayaran"]);
			}



			// Data transaksi yang akan dikirimkan ke Midtrans
			$transaction_details = [
				'order_id' => uniqid(),
				'gross_amount' => floatval($TotalPembelian), // Jumlah total transaksi
			];

			$customer_details = [
				'first_name' => $Pelanggan[0]['NamaPelanggan'],
			];

			$transaction = [
				'transaction_details' => $transaction_details,
            	'customer_details' => $customer_details,
				'payment_type' => 'qris',
            	'qris' => []
			];

			try {
				$snapToken = Snap::getSnapToken($transaction);
				return response()->json(['snap_token' => $snapToken]);
			} catch (\Exception $e) {
				return response()->json(['error' => $e->getMessage()]);
			}
		}
		else{
			return response()->json(['error' => "Metode Pembayaran Tidak Valid"]);
		}
    }
}
