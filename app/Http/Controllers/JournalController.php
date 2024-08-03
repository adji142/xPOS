<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DocumentNumbering;
use App\Models\DocumentType;
use App\Models\JournalHeader;
use App\Models\JournalDetail;
use App\Models\Rekening;

class JournalController extends Controller
{
    public function View(Request $request)
    {
    	$keyword = $request->input('keyword');
        $docType = DocumentType::all();

	    return view("Transaksi.Accounting.jurnal",[
            'doctype' => $docType
	    ]);
    }

    public function ViewHeader(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
    	$TglAwal = $request->input('TglAwal');
	   	$TglAkhir = $request->input('TglAkhir');
        $docType = $request->input('docType');

        $sql = "headerjurnal.*, documenttype.NamaDokumen";

        $model = JournalHeader::selectRaw($sql)
                    ->leftJoin('documenttype', 'headerjurnal.KodeTransaksi','documenttype.KodeDokumen')
                    ->whereBetween('headerjurnal.TglTransaksi', [$TglAwal, $TglAkhir]);
        if($docType != ""){
            $model->where('KodeTransaksi', $docType);
        }

        $model->orderBy('headerjurnal.TglTransaksi');
        $model->orderBy('headerjurnal.NoTransaksi');

        $data['data']= $model->get();
        return response()->json($data);
    }

    public function ViewDetail(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        $NoTransaksi = $request->input('NoTransaksi');

        $sql = "detailjurnal.*, CASE WHEN detailjurnal.DK = 1 THEN Jumlah ELSE 0 END Debit,
                    CASE WHEN detailjurnal.DK = 2 THEN Jumlah ELSE 0 END Kredit, rekeningakutansi.NamaRekening ";
        $model = JournalDetail::selectRaw($sql)
                    ->leftJoin('rekeningakutansi', function ($value){
                        $value->on('rekeningakutansi.Koderekening','=','detailjurnal.KodeRekening')
                        ->on('rekeningakutansi.RecordOwnerID','=','detailjurnal.RecordOwnerID');
                    })
                    ->where('detailjurnal.NoTransaksi', $NoTransaksi)
                    ->orderBy('detailjurnal.NoUrut');

        $data['data']= $model->get();
        return response()->json($data);
    }

    public function Form($NoTransaksi = null)
	{
    	$jurnalheader = JournalHeader::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('NoTransaksi', $NoTransaksi)
                            ->get();
        $sql = "detailjurnal.*, CASE WHEN detailjurnal.DK = 1 THEN Jumlah ELSE 0 END Debit,
                CASE WHEN detailjurnal.DK = 2 THEN Jumlah ELSE 0 END Kredit, rekeningakutansi.NamaRekening ";

        $jurnaldetail = JournalDetail::selectRaw($sql)
                    ->leftJoin('rekeningakutansi', function ($value){
                        $value->on('rekeningakutansi.Koderekening','=','detailjurnal.KodeRekening')
                        ->on('rekeningakutansi.RecordOwnerID','=','detailjurnal.RecordOwnerID');
                    })
                    ->where('detailjurnal.NoTransaksi', $NoTransaksi)
                    ->orderBy('detailjurnal.NoUrut')
                    ->get();
        $rekening = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->where('Jenis',2)
                        ->get();
        $docType = DocumentType::all();

	    return view("Transaksi.Accounting.jurnal-Input",[
	        'jurnalheader' => $jurnalheader,
	        'jurnaldetail' => $jurnaldetail,
	        'rekening' => $rekening,
            'doctype'  => $docType
	    ]);
	}

    public function storeJson(Request $request){
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");
		Log::debug($request->all());
		DB::beginTransaction();

        $jsonData = $request->json()->all();
        $errorCount = 0;
        try {
            $currentDate = Carbon::now();
			$Year = $currentDate->format('Y');
			$Month = $currentDate->format('m');

            $numberingData = new DocumentNumbering();
		    $NoTransaksi = $numberingData->GetNewDoc("JE","headerjurnal","NoTransaksi");

            $model = new JournalHeader;
            $model->Periode = $Year.$Month;
            $model->KodeTransaksi = $jsonData['KodeTransaksi'];
            $model->NoTransaksi = $NoTransaksi;
            $model->TglTransaksi = $jsonData['TglTransaksi'];
            $model->NoReff = $jsonData['NoReff'];
            $model->StatusTransaksi = $jsonData['Status'];
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $model->save();

            if (count($jsonData['Detail']) == 0) {
                $nError = -0001;
                $sError = "Data Journal Detail tidak ditemukan";
                $errorCount += 1;
                goto jump;
            }

            $index = 0;
            $TotalDebit = 0;
            $TotalKredit = 0;
            foreach ($jsonData['Detail'] as $key) {
                $TotalDebit += $key["Debit"];
                $TotalKredit += $key["Kredit"];
            }

            if(round($TotalDebit,2) <> round($TotalKredit,2)){
                $nError = -0001;
                $sError = "Debit dan Kredit harus memiliki nilai yang sama";
                $errorCount += 1;
                goto jump;
            }

            foreach ($jsonData['Detail'] as $key) {

                if($jsonData['KodeTransaksi'] == "" || $key['Debit'] + $key['Kredit'] == 0){
                    goto skip;
                }

                $modelDetail = new JournalDetail;

                $modelDetail->KodeTransaksi = $jsonData['KodeTransaksi'];
                $modelDetail->NoTransaksi = $NoTransaksi;
                $modelDetail->NoUrut = $index;
                $modelDetail->KodeRekening = $key['KodeRekening'];
                $modelDetail->KodeRekeningBukuBesar = "";

                if($key["Debit"] <> 0){
                    $modelDetail->DK = 1;
                    $modelDetail->Jumlah = $key['Debit'];
                }
                else if($key["Kredit"] <> 0){
                    $modelDetail->DK = 2;
                    $modelDetail->Jumlah = $key['Kredit'];
                }

                $modelDetail->KodeMataUang = "";
                $modelDetail->Valas = 0;
                $modelDetail->NilaiTukar = 0;
                $modelDetail->Keterangan = $key['Keterangan'];
                $modelDetail->HeaderKas = "";
                $modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

                $save = $modelDetail->save();

                if (!$save) {
                    $nError = -0002;
                    $sError = "Journal Detail tidak dapat disimpan";
                    $errorCount += 1;
                    goto jump;
                }
                $index+=1;
                skip:
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
        $data = array('success' => false, 'message' => '', 'data' => array(), 'LastTRX' => '' ,'Kembalian' => "");

        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;
        $jsonData = $request->json()->all();

        try {
            $checkExists = JournalHeader::where('RecordOwnerID',Auth::user()->RecordOwnerID)
		    				->where('NoTransaksi', $jsonData['NoTransaksi'])
		    				->where('KodeTransaksi', $jsonData['KodeTransaksi'])
		    				->get();
            if(count($checkExists) > 0){
                $update = DB::table('headerjurnal')
                        ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
                        ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                        ->update(
                            [
                                'KodeTransaksi' => $jsonData['KodeTransaksi'],
                                'TglTransaksi' => $jsonData['TglTransaksi'],
                                'NoReff' => $jsonData['NoReff'],
                                'StatusTransaksi' => $jsonData['Status']
                            ]
                        );

                if(count($jsonData['Detail']) == 0){
                    $nError = -0002;
                    $sError = "Detail Jurnal tidak ditemukan";
                    $errorCount += 1;
                    goto jump;
                }

                $delete = DB::table('detailjurnal')
			                ->where('NoTransaksi','=', $checkExists[0]['NoTransaksi'])
			                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
			                ->delete();
                
                $index = 0;
                $TotalDebit = 0;
                $TotalKredit = 0;
                foreach ($jsonData['Detail'] as $key) {
                    $TotalDebit += $key["Debit"];
                    $TotalKredit += $key["Kredit"];
                }
    
                if(round($TotalDebit,2) <> round($TotalKredit,2)){
                    $nError = -0001;
                    $sError = "Debit dan Kredit harus memiliki nilai yang sama";
                    $errorCount += 1;
                    goto jump;
                }
    
                foreach ($jsonData['Detail'] as $key) {
                    if($jsonData['KodeTransaksi'] == "" || $key['Debit'] + $key['Kredit'] == 0){
                        goto skipx;
                    }

                    $modelDetail = new JournalDetail;
    
                    $modelDetail->KodeTransaksi = $jsonData['KodeTransaksi'];
                    $modelDetail->NoTransaksi = $jsonData['NoTransaksi'];
                    $modelDetail->NoUrut = $index;
                    $modelDetail->KodeRekening = $key['KodeRekening'];
                    $modelDetail->KodeRekeningBukuBesar = "";
    
                    if($key["Debit"] <> 0){
                        $modelDetail->DK = 1;
                        $modelDetail->Jumlah = $key['Debit'];
                    }
                    else if($key["Kredit"] <> 0){
                        $modelDetail->DK = 2;
                        $modelDetail->Jumlah = $key['Kredit'];
                    }
    
                    $modelDetail->KodeMataUang = "";
                    $modelDetail->Valas = 0;
                    $modelDetail->NilaiTukar = 0;
                    $modelDetail->Keterangan = $key['Keterangan'];
                    $modelDetail->HeaderKas = "";
                    $modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;
    
                    $save = $modelDetail->save();
    
                    if (!$save) {
                        $nError = -0002;
                        $sError = "Journal Detail tidak dapat disimpan";
                        $errorCount += 1;
                        goto jump;
                    }
                    $index+=1;
                    skipx:
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
}