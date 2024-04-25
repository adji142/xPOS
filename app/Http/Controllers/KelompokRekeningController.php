<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\KelompokRekening;

class KelompokRekeningController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeKelompokRekening','NamaKelompokRekening'];
        $keyword = $request->input('keyword');

        $Sql = "id, NamaKelompok, CASE WHEN Kelompok = 1 THEN 'Neraca' ELSE 'Laba Rugi' END AS Kelompok, CASE WHEN Posisi = 1 THEN 'Debit' ELSE 'Credit' END Posisi, FooterLaporan ";
        $kelompokrekening = KelompokRekening::selectRaw($Sql)
        				->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $kelompokrekening = $kelompokrekening->paginate(4);

        $title = 'Delete Kelompok Rekening !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Finance.KelompokRekening",[
            'kelompokrekening' => $kelompokrekening, 
        ]);
    }

    public function Form($KodeKelompokRekening = null)
    {
    	$kelompokrekening = KelompokRekening::where('id','=',$KodeKelompokRekening)->get();
        
        return view("master.Finance.KelompokRekening-Input",[
            'kelompokrekening' => $kelompokrekening
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaKelompokRekening'=>'required',
                'Kelompok'=>'required',
                'Posisi'=>'required'
            ]);

            $model = new KelompokRekening;
            $model->NamaKelompok = $request->input('NamaKelompokRekening');
            $model->Kelompok = $request->input('Kelompok');
            $model->Posisi = $request->input('Posisi');
            $model->FooterLaporan = $request->input('FooterLaporan');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Kelompok Rekening Berhasil disimpan.');
                return redirect('kelompokrekening');
                
            }else{
                throw new \Exception('Penambahan Data Kelompok Rekening Gagal');
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
                'id'=>'required',
                'NamaKelompokRekening'=>'required',
                'Kelompok'=>'required',
                'Posisi'=>'required'
            ]);

            $model = KelompokRekening::where('id','=',$request->input('id'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('kelompokrekening')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaKelompok'=>$request->input('NamaKelompokRekening'),
                					'Kelompok'=>$request->input('Kelompok'),
                					'Posisi'=>$request->input('Posisi'),
                					'FooterLaporan'=>$request->input('FooterLaporan'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data KelompokRekening berhasil disimpan.');
                    return redirect('kelompokrekening');
                }else{
                    throw new \Exception('Edit KelompokRekening Gagal');
                }
            } else{
                throw new \Exception('KelompokRekening not found.');
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
    		$rekening = DB::table('rekeningakutansi')
    					->where('KodeKelompok','=', $request->id)
    					->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

    		if (count($rekening) > 0) {
	    		alert()->error('Error','Delete Kelompok Rekening Gagal, Kelompok Akses Sudah Dipakai di Rekening Akutansi');
	    		goto jump;
	    	}

    		$kelompokrekening = DB::table('kelompokrekening')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($kelompokrekening) {
	        	alert()->success('Success','Delete KelompokRekening berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete KelompokRekening Gagal.');
	        }
	        jump:
	        return redirect('kelompokrekening');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
