<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Rekening;
use App\Models\KelompokRekening;

class RekeningController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeRekening','NamaRekening'];
        $keyword = $request->input('keyword');

        $paramKelompokRekening =  $request->input('KelompokRekening');
        $paramLevel =  $request->input('Level');

        $Sql = "rekeningakutansi.KodeRekening, rekeningakutansi.NamaRekening, kelompokrekening.NamaKelompok, rekeningakutansi.Level, CASE WHEN rekeningakutansi.Jenis = 1 THEN 'Rekening Induk' ELSE 'Buku Besar' END JenisRekening, rekeningakutansi.KodeRekeningInduk, SaldoBase";
        $rekening = Rekening::selectRaw($Sql)
    				->leftJoin('kelompokrekening', function ($value){
        					$value->on('kelompokrekening.id','=','rekeningakutansi.KodeKelompok')
        					->on('kelompokrekening.RecordOwnerID','=','rekeningakutansi.RecordOwnerID');
        				})
        			->where('rekeningakutansi.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        if ($paramKelompokRekening != "") {
        	$rekening->where('rekeningakutansi.KodeKelompok','=', $paramKelompokRekening );
        }

        if ($paramLevel != "") {
        	$rekening->where('rekeningakutansi.Level','=', $paramLevel );
        }

        // KelompokRekening
        $kelompokrekening = KelompokRekening::selectRaw("*")
        					->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        // $rekening = $rekening->paginate(4);

        $title = 'Delete Rekening !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Finance.Rekening",[
            'rekening' => $rekening->get(), 
            'kelompokrekening' => $kelompokrekening,
            'oldKelompokRekening' =>$paramKelompokRekening
        ]);
    }

    public function ViewJson(Request $request)
    {
    	$data = array('success'=>false, 'message'=>'', 'data'=>array());

        $paramKelompokRekening =  $request->input('KelompokRekening');
        $paramLevel =  $request->input('Level');

        $Sql = "rekeningakutansi.KodeRekening, rekeningakutansi.NamaRekening, kelompokrekening.NamaKelompok, rekeningakutansi.Level, CASE WHEN rekeningakutansi.Jenis = 1 THEN 'Rekening Induk' ELSE 'Buku Besar' END JenisRekening, rekeningakutansi.KodeRekeningInduk, SaldoBase";
        $rekening = Rekening::selectRaw($Sql)
    				->leftJoin('kelompokrekening', function ($value){
        					$value->on('kelompokrekening.id','=','rekeningakutansi.KodeKelompok')
        					->on('kelompokrekening.RecordOwnerID','=','rekeningakutansi.RecordOwnerID');
        				})
        			->where('rekeningakutansi.RecordOwnerID','=',Auth::user()->RecordOwnerID);

        if ($paramKelompokRekening != "") {
        	$rekening->where('rekeningakutansi.KodeKelompok','=', $paramKelompokRekening );
        }

        if ($paramLevel != "") {
        	$rekening->where('rekeningakutansi.Level','=', $paramLevel );
        }

        $data['data'] = $rekening->get();

        return response()->json($data);
    }

    public function Form($KodeRekening = null)
    {
    	$rekening = Rekening::where('KodeRekening','=',$KodeRekening)->get();
        // KelompokRekening
        $kelompokrekening = KelompokRekening::selectRaw("*")
        					->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        return view("master.Finance.Rekening-Input",[
            'rekening' => $rekening,
            'kelompokrekening' => $kelompokrekening,
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeRekening'=>'required',
                'NamaRekening'=>'required',
                'KodeKelompok'=>'required',
                'Level'=>'required',
                'Jenis'=>'required',
                'RekeningInduk'=>'required'
            ]);

            $model = new Rekening;
            $model->KodeRekening = $request->input('KodeRekening');
            $model->NamaRekening = $request->input('NamaRekening');
            $model->KodeKelompok = $request->input('KodeKelompok');
            $model->Jenis = $request->input('Jenis');
            $model->Level = $request->input('Level');
            $model->KodeRekeningInduk = $request->input('RekeningInduk');
            $model->SaldoValas = 0;
            $model->SaldoBase = 0;
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Rekening Berhasil disimpan.');
                return redirect('rekening');
                
            }else{
                throw new \Exception('Penambahan Data Rekening Gagal');
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
                'KodeRekening'=>'required',
                'NamaRekening'=>'required'
            ]);

            $model = Rekening::where('KodeRekening','=',$request->input('KodeRekening'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');

                \App\Services\DBLogger::update('rekeningakutansi', ['KodeRekening' => $request->input('KodeRekening'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'NamaRekening' => $request->input('NamaRekening'),
                    'KodeKelompok' => $request->input('KodeKelompok'),
                    'Jenis' => $request->input('Jenis'),
                    'Level' => $request->input('Level'),
                    'KodeRekeningInduk' => $request->input('RekeningInduk'),
                ]);

                alert()->success('Success','Data Rekening berhasil disimpan.');
                return redirect('rekening');
            } else{
                throw new \Exception('Rekening not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
    	try {
    		// $rekening = DB::table('rekeningakutansi')
    		// 			->where('KodeKelompok','=', $request->id)
    		// 			->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

    		// if (count($rekening) > 0) {
	    	// 	alert()->error('Error','Delete Kelompok Rekening Gagal, Kelompok Akses Sudah Dipakai di Rekening Akutansi');
	    	// 	goto jump;
	    	// }

    		$rekening = DB::table('rekeningakutansi')
	                ->where('KodeRekening','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($rekening) {
	        	alert()->success('Success','Delete Rekening berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Rekening Gagal.');
	        }
	        jump:
	        return redirect('rekening');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
