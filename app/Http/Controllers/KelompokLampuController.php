<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\KelompokLampu;

class KelompokLampuController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeKelompok','NamaKelompok'];
        $keyword = $request->input('keyword');

        $KelompokLampu = KelompokLampu::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $KelompokLampu = $KelompokLampu->paginate(4);

        $title = 'Delete Kelompok Lampu !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Sewa.KelompokLampu",[
            'kelompoklampu' => $KelompokLampu, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = KelompokLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeKelompok = null)
    {
    	$KelompokLampu = KelompokLampu::where('KodeKelompok','=',$KodeKelompok)->get();

        return view("master.Sewa.KelompokLampu-Input",[
            'kelompoklampu' => $KelompokLampu
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeKelompok'=>'required',
                'NamaKelompok'=>'required'
            ]);

            $model = new KelompokLampu;
            $model->KodeKelompok = $request->input('KodeKelompok');
            $model->NamaKelompok = $request->input('NamaKelompok');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Kelompok Lampu Berhasil disimpan.');
                return redirect('kelompoklampu');
                
            }else{
                throw new \Exception('Penambahan Data Kelompok Lampu Gagal');
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
                'KodeKelompok'=>'required',
                'NamaKelompok'=>'required'
            ]);

            $model = KelompokLampu::where('KodeKelompok','=',$request->input('KodeKelompok'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('tkelompoklampu')
                			->where('KodeKelompok','=', $request->input('KodeKelompok'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaKelompok'=>$request->input('NamaKelompok'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Kelompok Lampu berhasil disimpan.');
                    return redirect('kelompoklampu');
                }else{
                    throw new \Exception('Edit Kelompok Lampu Gagal');
                }
            } else{
                throw new \Exception('Kelompok Lampu not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        try {

            $model = new KelompokLampu;
            $model->KodeKelompok = $request->input('KodeKelompok');
            $model->NamaKelompok = $request->input('NamaKelompok');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Kelompok Lampu Gagal';
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
        try {

            $model = KelompokLampu::where('KodeKelompok','=',$request->input('KodeKelompok'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('tkelompoklampu')
                            ->where('KodeKelompok','=', $request->input('KodeKelompok'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaKelompok'=>$request->input('NamaKelompok'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit KelompokLampu Gagal';
                }
            } else{
                $data['message'] = 'KelompokLampu not found.';
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
    		$KelompokLampu = DB::table('tkelompoklampu')
	                ->where('KodeKelompok','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($KelompokLampu) {
	        	alert()->success('Success','Delete KelompokLampu berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete KelompokLampu Gagal.');
	        }
	        return redirect('kelompoklampu');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
