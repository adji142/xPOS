<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\KelompokMeja;

class KelompokMejaController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeKelompokMeja','NamaKelompokMeja'];
        $keyword = $request->input('keyword');

        $kelompokmeja = KelompokMeja::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $kelompokmeja = $kelompokmeja->paginate(4);

        $title = 'Delete Kelompok Meja !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Resto.KelompokMeja",[
            'kelompokmeja' => $kelompokmeja, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = KelompokMeja::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeKelompokMeja = null)
    {
    	$kelompokmeja = KelompokMeja::where('KodeKelompokMeja','=',$KodeKelompokMeja)->get();
        
        return view("Resto.KelompokMeja-Input",[
            'kelompokmeja' => $kelompokmeja
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeKelompokMeja'=>'required',
                'NamaKelompokMeja'=>'required'
            ]);

            $model = new KelompokMeja;
            $model->KodeKelompokMeja = $request->input('KodeKelompokMeja');
            $model->NamaKelompokMeja = $request->input('NamaKelompokMeja');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Kelompok Meja Berhasil disimpan.');
                return redirect('kelompokmeja');
                
            }else{
                throw new \Exception('Penambahan Data Kelompok Meja Gagal');
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
                'KodeKelompokMeja'=>'required',
                'NamaKelompokMeja'=>'required'
            ]);

            $model = KelompokMeja::where('KodeKelompokMeja','=',$request->input('KodeKelompokMeja'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('kelompokmeja')
                			->where('KodeKelompokMeja','=', $request->input('KodeKelompokMeja'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaKelompokMeja'=>$request->input('NamaKelompokMeja'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Kelompok Meja berhasil disimpan.');
                    return redirect('kelompokmeja');
                }else{
                    throw new \Exception('Edit Kelompok Meja Gagal');
                }
            } else{
                throw new \Exception('Kelompok Meja not found.');
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

            $model = new KelompokMeja;
            $model->KodeKelompokMeja = $request->input('KodeKelompokMeja');
            $model->NamaKelompokMeja = $request->input('NamaKelompokMeja');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Kelompok Meja Gagal';
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

            $model = KelompokMeja::where('KodeKelompokMeja','=',$request->input('KodeKelompokMeja'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('kelompokmeja')
                            ->where('KodeKelompokMeja','=', $request->input('KodeKelompokMeja'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaKelompokMeja'=>$request->input('NamaKelompokMeja'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit KelompokMeja Gagal';
                }
            } else{
                $data['message'] = 'KelompokMeja not found.';
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
    		$kelompokmeja = DB::table('kelompokmeja')
	                ->where('KodeKelompokMeja','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($kelompokmeja) {
	        	alert()->success('Success','Delete KelompokMeja berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete KelompokMeja Gagal.');
	        }
	        return redirect('kelompokmeja');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
