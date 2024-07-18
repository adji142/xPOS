<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DocumentNumbering;
use App\Models\PembayaranKonsinyasiHeader;
use App\Models\PembayaranKonsinyasiDetail;
use App\Models\Supplier;
use App\Models\MetodePembayaran;
use App\Models\Company;
use App\Models\AutoPosting;
use App\Models\SettingAccount;
use App\Models\Rekening;

class PembayaranKonsinyasiController extends Controller
{
    public function View(Request $request){
		$keyword = $request->input('keyword');
		$supplier = Supplier::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

		return view("Transaksi.Pembelian.PembayaranPembelianKonsinyasi",[
			'supplier' => $supplier->get(), 
		]);
	}

	public function ViewHeader(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$TglAwal = $request->input('TglAwal');
   		$TglAkhir = $request->input('TglAkhir');
   		$KodeVendor = $request->input('KodeVendor');

   		$sql = "pembayarankonsinyasiheader.*, supplier.NamaSupplier, 
   				CASE WHEN pembayarankonsinyasiheader.Status = 'O' THEN 'OPEN' ELSE 
	   				CASE WHEN pembayarankonsinyasiheader.Status = 'C' THEN 'CLOSE' ELSE 
	   					CASE WHEN pembayarankonsinyasiheader.Status = 'D' THEN 'CANCEL' ELSE '' END
	   				END
	   			END AS StatusDocument";
   		$model = PembayaranKonsinyasiHeader::selectRaw($sql)
   					->leftJoin('supplier', function ($value){
    					$value->on('pembayarankonsinyasiheader.KodeSupplier','=','supplier.KodeSupplier')
    					->on('supplier.RecordOwnerID','=','pembayarankonsinyasiheader.RecordOwnerID');
    				})
    				->whereBetween('pembayarankonsinyasiheader.TglTransaksi',[$TglAwal, $TglAkhir])
        			->where('pembayarankonsinyasiheader.RecordOwnerID',Auth::user()->RecordOwnerID);
        if ($KodeVendor != "") {
    		$model->where("pembayarankonsinyasiheader.KodeSupplier", $KodeVendor);
    	}
    	$data['data']= $model->get();
	    return response()->json($data);
	}

	public function ViewDetail(Request $request)
	{
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
	   		
   		$NoTransaksi = $request->input('NoTransaksi');

   		$sql = "pembayarankonsinyasidetail.*, fakturpembelianheader.TglTransaksi AS TglFaktur, fakturpembelianheader.TotalPembelian, metodepembayaran.NamaMetodePembayaran";
   		$model = PembayaranKonsinyasiDetail::selectRaw($sql)
   					->leftJoin('fakturpembelianheader', function ($value){
    					$value->on('fakturpembelianheader.NoTransaksi','=','pembayarankonsinyasidetail.BaseReff')
    					->on('fakturpembelianheader.RecordOwnerID','=','pembayarankonsinyasidetail.RecordOwnerID');
    				})
    				->leftJoin('metodepembayaran', function ($value){
    					$value->on('metodepembayaran.id','=','pembayarankonsinyasidetail.KodeMetodePembayaran')
    					->on('metodepembayaran.RecordOwnerID','=','pembayarankonsinyasidetail.RecordOwnerID');
    				})
    				->where('pembayarankonsinyasidetail.NoTransaksi','=', $NoTransaksi);
    	$data['data']= $model->get();
	    return response()->json($data);
	}

	function getKonsinyasiValue(Request $request) {
		$data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
		$TglAwal = $request->input('TglAwal');
   		$TglAkhir = $request->input('TglAkhir');
   		$KodeVendor = $request->input('KodeVendor');
		$RecordOwnerID = Auth::user()->RecordOwnerID;

		$transaksikonsinyasi = DB::select('CALL fsp_read_penjualan_konsinyasi(?, ?, ?, ?)', [$TglAwal, $TglAkhir,$RecordOwnerID, (empty($KodeVendor) ? "" : $KodeVendor)]);

		$data['data']= $transaksikonsinyasi;
	    return response()->json($data);
	}

	public function Form($NoTransaksi = null)
	   {
			$supplier = Supplier::where('Status', 1)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$pembayarankonsinyasiheader = PembayaranKonsinyasiHeader::where('NoTransaksi', $NoTransaksi)
							->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			

			$sql = "fakturpembelianheader.NoTransaksi, fakturpembelianheader.TglTransaksi, pembayarankonsinyasidetail.KodeMetodePembayaran, pembayarankonsinyasidetail.Keterangan, fakturpembelianheader.TotalPembelian AS TotalHutang, pembayarankonsinyasidetail.TotalPembayaran";
			$pembayarankonsinyasidetail = PembayaranKonsinyasiDetail::selectRaw($sql)
								->leftJoin('fakturpembelianheader', function ($value){
			    					$value->on('fakturpembelianheader.NoTransaksi','=','pembayarankonsinyasidetail.BaseReff')
			    					->on('fakturpembelianheader.RecordOwnerID','=','pembayarankonsinyasidetail.RecordOwnerID');
			    				})
								->where('pembayarankonsinyasidetail.NoTransaksi', $NoTransaksi)
								->where('pembayarankonsinyasidetail.RecordOwnerID', Auth::user()->RecordOwnerID)->get();
			$metodepembayaran = MetodePembayaran::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
		    return view("Transaksi.Pembelian.PembayaranPembelianKonsinyasi-Input",[
		        'supplier' => $supplier,
		        'pembayarankonsinyasiheader' => $pembayarankonsinyasiheader,
		        'pembayarankonsinyasidetail' => $pembayarankonsinyasidetail,
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
	    	$oCompany = Company::where('KodePartner',Auth::user()->RecordOwnerID)->first();

	    	$currentDate = Carbon::now();
			$Year = $currentDate->format('y');
			$Month = $currentDate->format('m');

			$model = new PembayaranKonsinyasiHeader;
	           	
           	$numberingData = new DocumentNumbering();
           	$NoTransaksi = $numberingData->GetNewDoc("OUTPAY","pembayarankonsinyasiheader","NoTransaksi");

           	$model->Periode = $Year.$Month;
			$model->NoTransaksi = $NoTransaksi;
			$model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->KodeSupplier = $jsonData['KodeSupplier'];
			$model->TotalPembelian = $jsonData['TotalPembayaran'];
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

				$modelDetail = new PembayaranKonsinyasiDetail;
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $NoUrut;
				$modelDetail->BaseReff = $key['BaseReff'];
				$modelDetail->BaseLine = $key['BaseLine'];
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
				'KodeTransaksi' => "OUTPAY",
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
					'KodeTransaksi' => "OUTPAY", 
					'KodeRekening' => $metode->AkunPembayaran,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
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

			// Hutang
			$Setting = new SettingAccount();
			$getSetting = $Setting->GetSetting("PbAcctHutang");
			$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
							->where('KodeRekening', $getSetting)->get();

			if (count($validate) == 0) {
				$data['message'] = "Akun Rekening Akutansi Hutang Pembelian Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
				$errorCount +=1;
				goto jump;
			}

			$temp = array(
				'KodeTransaksi' => "OUTPAY", 
				'KodeRekening' => $getSetting,
				'KodeRekeningBukuBesar' => "",
				'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
				'KodeMataUang' => "",
				'Valas' => 0,
				'NilaiTukar' => 0,
				'Jumlah' => $TotalLawanPembayaran, 
				'Keterangan' => $jsonData['Keterangan'], 
				'HeaderKas' => "",
				'RecordOwnerID' =>  Auth::user()->RecordOwnerID
			);

			array_push($arrDetail, $temp);
			// End Hutang

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
			$model = PembayaranKonsinyasiHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
	           		->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

	        if ($model) {
	        	$update = DB::table('pembayarankonsinyasiheader')
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

					$checkExists = PembayaranKonsinyasiDetail::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           							->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
           							->where('BaseReff','=', $key['NoTransaksi'])->get();
           			// var_dump($checkExists);
           			if (count($checkExists) > 0) {
           				$update = DB::table('pembayarankonsinyasidetail')
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
           				$NoUrut = 0;

           				$modelDetail = new PembayaranKonsinyasiDetail;
						$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
						$modelDetail->NoUrut = PembayaranKonsinyasiDetail::max('NoUrut') + 1;
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

                // Auto Posting
				$arrHeader = array(
					'NoTransaksi' => "",
					'KodeTransaksi' => "OUTPAY",
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
						'KodeTransaksi' => "OUTPAY", 
						'KodeRekening' => $metode->AkunPembayaran,
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D" ) ? 1 : 2, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalPembayaran'], 
						'Keterangan' => $key['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					$TotalLawanPembayaran += $key['TotalPembayaran'];
				}
				// End Pembayaran

				// Hutang
				$Setting = new SettingAccount();
				$getSetting = $Setting->GetSetting("PbAcctHutang");
				$validate = Rekening::where('RecordOwnerID', Auth::user()->RecordOwnerID)
								->where('KodeRekening', $getSetting)->get();

				if (count($validate) == 0) {
					$data['message'] = "Akun Rekening Akutansi Hutang Pembelian Tidak Valid / Tidak Ada silahkan Setting Akun di menu Master->Finance->Setting Account";
					$errorCount +=1;
					goto jump;
				}

				$temp = array(
					'KodeTransaksi' => "OUTPAY", 
					'KodeRekening' => $getSetting,
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2: 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $TotalLawanPembayaran, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				// End Hutang

				// Save Journal
				$autoPosting = new AutoPosting();

				if ($autoPosting->Auto($arrHeader, $arrDetail, ($jsonData['Status']== "D") ? true : false) != "OK") {
					$data["message"] = "Gagal Simpan Jurnal";
					$errorCount +=1;
					goto jump;
				}
				// End Save Jurnal
				// Auto Posting

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
