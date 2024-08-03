<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Company;
use App\Models\Rekening;
use App\Models\BiayaHeader;
use App\Models\BiayaDetail;
use App\Models\DocumentNumbering;

use App\Models\AutoPosting;
use App\Models\SettingAccount;

class BiayaController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
	    $rekening = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	    				->where('Jenis',2)->get();

	    return view("Transaksi.Accounting.Biaya",[
	    	'rekening' => $rekening, 
	    ]);
    }

    public function ViewHeader(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array());

    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');

	   	$sql = "biayaheader.*, rekeningakutansi.NamaRekening, CASE WHEN biayaheader.Status = 'O' THEN 'OPEN' ELSE CASE WHEN biayaheader.Status = 'C' THEN 'CLOSE' ELSE CASE WHEN biayaheader.Status ='D' THEN 'CANCELED' ELSE '' END END  END StatusDocument ";

	   	$biaya = BiayaHeader::selectRaw($sql)
	   				->leftJoin('rekeningakutansi', function ($value){
    					$value->on('rekeningakutansi.KodeRekening','=','biayaheader.KodeRekening')
    					->on('rekeningakutansi.RecordOwnerID','=','biayaheader.RecordOwnerID');
    				})
    				->whereBetween('biayaheader.TglTransaksi',[$TglAwal, $TglAkhir])
    				->where('biayaheader.RecordOwnerID',Auth::user()->RecordOwnerID)
    				->orderBy('biayaheader.TglTransaksi','DESC');
        $data['data']= $biaya->get();
        return response()->json($data);
    }
    public function ViewDetail(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array());

    	$NoTransaksi = $request->input('NoTransaksi');

    	$sql = "biayadetail.*, rekeningakutansi.NamaRekening";
    	$biaya = BiayaDetail::selectRaw($sql)
    				->leftJoin('rekeningakutansi', function ($value){
    					$value->on('rekeningakutansi.KodeRekening','=','biayadetail.KodeRekening')
    					->on('rekeningakutansi.RecordOwnerID','=','biayadetail.RecordOwnerID');
    				})
    				->where('biayadetail.RecordOwnerID',Auth::user()->RecordOwnerID)
    				->where('biayadetail.NoTransaksi',$NoTransaksi)
    				->orderBy('biayadetail.NoUrut');

    	$data['data']= $biaya->get();
        return response()->json($data);
    }

    public function Form($NoTransaksi = null){
    	$rekeningasset = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	    			->where('Jenis',2)
	    			->where('KodeKelompok',1)->get();

	    $rekeningbiaya = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	    			->where('Jenis',2)
	    			->where('KodeKelompok',6)->get();

	    $biayaheader = BiayaHeader::where('NoTransaksi', $NoTransaksi)
	    				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
	    $biayadetail = BiayaDetail::where('NoTransaksi', $NoTransaksi)
	    				->where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();

	    return view("Transaksi.Accounting.Biaya-Input",[
	    	'rekeningasset' => $rekeningasset,
	    	'rekeningbiaya' => $rekeningbiaya,
	    	'biayaheader'	=> $biayaheader,
	    	'biayadetail'	=> $biayadetail
	    ]);
    }

    public function storeJson(Request $request)
    {
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
		Log::debug($request->all());
		DB::beginTransaction();

		$errorCount = 0;
		$jsonData = $request->json()->all();

		try {
			if ($jsonData['KodeRekening'] == "") {
				$data['message'] = "Kode Rekening Harus diisi";
				$errorCount +=1;
				goto jump;
			}

			$currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

			$numberingData = new DocumentNumbering();
	        $NoTransaksi = $numberingData->GetNewDoc("OBY","biayaheader","NoTransaksi");

	        $model = new BiayaHeader;
	        $model->NoTransaksi = $NoTransaksi;
			$model->Periode = $Year.$Month;
			$model->TglTransaksi = $jsonData['TglTransaksi'];
			$model->NoReff = $jsonData['NoReff'];
			$model->Keterangan = $jsonData['Keterangan'];
			$model->TotalTransaksi = $jsonData['TotalTransaksi'];
			$model->KodeRekening = $jsonData['KodeRekening'];
			$model->Status = $jsonData['Status'];
			$model->Posted = 0;
			$model->CreatedBy = Auth::user()->name;
			$model->RecordOwnerID = Auth::user()->RecordOwnerID;

			$save = $model->save();

			if (count($jsonData['Detail']) == 0) {
				$data['message'] = "Data Detail harus diisi";
				$errorCount +=1;
				goto jump;
			}

			foreach ($jsonData['Detail'] as $key) {
				if ($key['TotalTransaksi'] == 0) {
					goto skip;
				}

				if ($key['KodeRekening'] == "") {
					$data['message'] = "Kode Rekening Harus diisi";
					$errorCount +=1;
					goto jump;
				}

				$modelDetail = new BiayaDetail;
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $key['NoUrut'];
				$modelDetail->KodeRekening = $key['KodeRekening'];
				$modelDetail->TotalTransaksi = $key['TotalTransaksi'];
				$modelDetail->NoReff = $key['NoReff'];
				$modelDetail->Keterangan = $key['Keterangan'];
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

			// Auto Posting
			$arrHeader = array(
				'NoTransaksi' => "",
				'KodeTransaksi' => "OBY",
				'TglTransaksi' => $jsonData['TglTransaksi'],
				'NoReff' => $NoTransaksi,
				'StatusTransaksi' => "O",
				'RecordOwnerID' => Auth::user()->RecordOwnerID,
			);
			$arrDetail = array();

			$TotalRow = 0;
			foreach ($jsonData['Detail'] as $key) {
				if ($key['TotalTransaksi'] == 0) {
					goto xskip;
				}

				if ($key['KodeRekening'] == "") {
					goto xskip;
				}
				$temp = array(
					'KodeTransaksi' => "OBY", 
					'KodeRekening' => $key['KodeRekening'],
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $key['TotalTransaksi'],
					'Keterangan' => $key['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);
				$TotalRow += $key['TotalTransaksi'];

				xskip:
			}

			$temp = array(
				'KodeTransaksi' => "OBY", 
				'KodeRekening' => $jsonData['KodeRekening'],
				'KodeRekeningBukuBesar' => "",
				'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
				'KodeMataUang' => "",
				'Valas' => 0,
				'NilaiTukar' => 0,
				'Jumlah' => $TotalRow, 
				'Keterangan' => $jsonData['Keterangan'], 
				'HeaderKas' => "",
				'RecordOwnerID' =>  Auth::user()->RecordOwnerID
			);

			array_push($arrDetail, $temp);


			// Save Journal
			$autoPosting = new AutoPosting();

			// var_dump(json_encode($arrDetail));
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

    public function editJson(Request $request){
    	$data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

    	Log::debug($request->all());
    	DB::beginTransaction();

    	$errorCount = 0;
    	$jsonData = $request->json()->all();

    	try {

    		$model = BiayaHeader::where('NoTransaksi','=',$jsonData['NoTransaksi'])
           				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
    		
    		if ($model) {
    			$update = DB::table('biayaheader')
                           ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                           ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                           ->update(
                               	[
									'NoReff' => $jsonData['NoReff'],
									'Keterangan' => $jsonData['Keterangan'],
									'KodeRekening' => $jsonData['KodeRekening'],
									'TotalTransaksi' => $jsonData['TotalTransaksi'],
									'UpdatedBy' => Auth::user()->name
                               	]
                           	);
                if (count($jsonData['Detail']) == 0) {
					$data['message'] = "Data Detail harus diisi";
					$errorCount +=1;
					goto jump;
				}

				$delete = DB::table('biayadetail')
	                ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

                foreach ($jsonData['Detail'] as $key) {
                	if ($key['TotalTransaksi'] == 0) {
						goto skip;
					}

					if ($key['KodeRekening'] == "") {
						$data['message'] = "Kode Rekening Harus diisi";
						$errorCount +=1;
						goto jump;
					}

					$modelDetail = new BiayaDetail;
					$modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
					$modelDetail->NoUrut = $key['NoUrut'];
					$modelDetail->KodeRekening = $key['KodeRekening'];
					$modelDetail->TotalTransaksi = $key['TotalTransaksi'];
					$modelDetail->NoReff = $key['NoReff'];
					$modelDetail->Keterangan = $key['Keterangan'];
					$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
					$modelDetail->LineStatus = $key['LineStatus'];

					$save = $modelDetail->save();

					if (!$save) {
						$data['message'] = "Gagal Menyimpan Data Detail di Row ".$key->NoUrut;
						$errorCount += 1;
						goto jump;
					}

					skip:
                }

				// Auto Posting
				$arrHeader = array(
					'NoTransaksi' => "",
					'KodeTransaksi' => "OBY",
					'TglTransaksi' => $jsonData['TglTransaksi'],
					'NoReff' => $jsonData['NoTransaksi'],
					'StatusTransaksi' => "O",
					'RecordOwnerID' => Auth::user()->RecordOwnerID,
				);
				$arrDetail = array();

				$TotalRow = 0;
				foreach ($jsonData['Detail'] as $key) {
					if ($key['TotalTransaksi'] == 0) {
						goto xskip;
					}
	
					if ($key['KodeRekening'] == "") {
						goto xskip;
					}

					$temp = array(
						'KodeTransaksi' => "OBY", 
						'KodeRekening' => $key['KodeRekening'],
						'KodeRekeningBukuBesar' => "",
						'DK' => ($jsonData['Status'] == "D") ? 2 : 1, 
						'KodeMataUang' => "",
						'Valas' => 0,
						'NilaiTukar' => 0,
						'Jumlah' => $key['TotalTransaksi'],
						'Keterangan' => $key['Keterangan'], 
						'HeaderKas' => "",
						'RecordOwnerID' =>  Auth::user()->RecordOwnerID
					);

					array_push($arrDetail, $temp);
					$TotalRow += $key['TotalTransaksi'];
					xskip:
				}

				$temp = array(
					'KodeTransaksi' => "OBY", 
					'KodeRekening' => $jsonData['KodeRekening'],
					'KodeRekeningBukuBesar' => "",
					'DK' => ($jsonData['Status'] == "D") ? 1 : 2, 
					'KodeMataUang' => "",
					'Valas' => 0,
					'NilaiTukar' => 0,
					'Jumlah' => $TotalRow, 
					'Keterangan' => $jsonData['Keterangan'], 
					'HeaderKas' => "",
					'RecordOwnerID' =>  Auth::user()->RecordOwnerID
				);

				array_push($arrDetail, $temp);


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
}
