<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\DocumentType;
use App\Models\DocumentNumbering;
use App\Models\JournalHeader;
use App\Models\JournalDetail;

class AutoPosting extends Model
{
    use HasFactory;

    public function Auto($Header, $Detail)
    {
    	// var_dump($Header['NoReff']);
    	$nError = 0;
    	$sError = "";

    	$currentDate = Carbon::now();
		$Year = $currentDate->format('Y');
		$Month = $currentDate->format('m');

    	$numberingData = new DocumentNumbering();
	    $NoTransaksi = $numberingData->GetNewDoc("JE","headerjurnal","NoTransaksi");

	    $checkExists = JournalHeader::where('RecordOwnerID',Auth::user()->RecordOwnerID)
	    				->where('NoReff', $Header['NoReff'])
	    				->get();

	    if (count($checkExists) > 0) {
	    	$update = DB::table('headerjurnal')
                       ->where('NoTransaksi','=', $Header['NoTransaksi'])
                       ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                       ->update(
                           	[
								'KodeTransaksi' => $Header['KodeTransaksi'],
								'TglTransaksi' => $Header['TglTransaksi'],
								'NoReff' => $Header['NoReff'],
								'StatusTransaksi' => $StatusTransaksi	
                           	]
                       	);
            $delete = DB::table('jurnaldetail')
	                ->where('NoTransaksi','=', $jsonData['NoTransaksi'])
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        $index = 0;
			foreach ($Detail as $key) {
				$modelDetail = new JournalDetail;

				$modelDetail->KodeTransaksi = $key['KodeTransaksi'];
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $index;
				$modelDetail->KodeRekening = $key['KodeRekening'];
				$modelDetail->KodeRekeningBukuBesar = $key['KodeRekeningBukuBesar'];
				$modelDetail->DK = $key['DK'];
				$modelDetail->KodeMataUang = $key['KodeMataUang'];
				$modelDetail->Valas = $key['Valas'];
				$modelDetail->NilaiTukar = $key['NilaiTukar'];
				$modelDetail->Jumlah = $key['Jumlah'];
				$modelDetail->Keterangan = $key['Keterangan'];
				$modelDetail->HeaderKas = $key['HeaderKas'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				$save = $modelDetail->save();

				if (!$save) {
					$nError = -0002;
					$sError = "Journal Detail tidak dapat disimpan";
					goto jump;
				}
				$index+=1;
			}
	    }
	    else{
	    	$model = new JournalHeader;
		    $model->Periode = $Year.$Month;
			$model->KodeTransaksi = $Header['KodeTransaksi'];
			$model->NoTransaksi = $NoTransaksi;
			$model->TglTransaksi = $Header['TglTransaksi'];
			$model->NoReff = $Header['NoReff'];
			$model->StatusTransaksi = $Header['StatusTransaksi'];
			$model->RecordOwnerID = Auth::user()->RecordOwnerID;

			$model->save();

			if (count($Detail) == 0) {
				$nError = -0001;
				$sError = "Data Journal Detail tidak ditemukan";
				goto jump;
			}

			$index = 0;
			foreach ($Detail as $key) {
				$modelDetail = new JournalDetail;

				$modelDetail->KodeTransaksi = $key['KodeTransaksi'];
				$modelDetail->NoTransaksi = $NoTransaksi;
				$modelDetail->NoUrut = $index;
				$modelDetail->KodeRekening = $key['KodeRekening'];
				$modelDetail->KodeRekeningBukuBesar = $key['KodeRekeningBukuBesar'];
				$modelDetail->DK = $key['DK'];
				$modelDetail->KodeMataUang = $key['KodeMataUang'];
				$modelDetail->Valas = $key['Valas'];
				$modelDetail->NilaiTukar = $key['NilaiTukar'];
				$modelDetail->Jumlah = $key['Jumlah'];
				$modelDetail->Keterangan = $key['Keterangan'];
				$modelDetail->HeaderKas = $key['HeaderKas'];
				$modelDetail->RecordOwnerID = Auth::user()->RecordOwnerID;

				$save = $modelDetail->save();

				if (!$save) {
					$nError = -0002;
					$sError = "Journal Detail tidak dapat disimpan";
					goto jump;
				}
				$index+=1;
			}
	    }


		jump:

		if ($nError == 0) {
			$sError ="OK";
		}
		
		return $sError;
    }
}
