<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\TipeOrderResto;

class TipeOrderRestoController extends Controller
{
    public function View(Request $request)
    {
        $tipeorderresto = TipeOrderResto::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $bank = $bank->paginate(4);

        $title = 'Delete Tipe Order Resto !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Resto.tipeorderresto",[
            'tipeorderresto' => $tipeorderresto, 
        ]);
    }
    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $tipeorderresto = TipeOrderResto::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $tipeorderresto;
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$tipeorderresto = TipeOrderResto::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('id', $id)
                    ->get();
        
        return view("Resto.tipeorderresto-Input",[
            'tipeorderresto' => $tipeorderresto
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $model = new TipeOrderResto;
            $model->NamaJenisOrder = $request->input('NamaJenisOrder');
            $model->Icon = $request->input('image_base64');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Tipe Order Resto Berhasil disimpan.');
                return redirect('tipeorderresto');
                
            }else{
                alert()->error('Error','Penambahan Data Tipe Order Resto Gagal disimpan');
                return redirect()->back();
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
            $model = TipeOrderResto::where('id','=',$request->input('id'))
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('tipeorderresto')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaJenisOrder'=>$request->input('NamaJenisOrder'),
                					'Icon'=>$request->input('image_base64')
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Tipe Order Resto berhasil disimpan.');
                    return redirect('tipeorderresto');
                }else{
                    alert()->error('Error','Edit Tipe Order Resto Gagal');
                    return redirect()->back();
                }
            } else{
                alert()->error('Error','Tipe Order Resto Not Found');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        try {

            $model = new TipeOrderResto;
            $model->NamaJenisOrder = $request->input('NamaJenisOrder');
            $model->Icon = $request->input('Icon');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Tipe Order Resto Gagal';
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

            $model = TipeOrderResto::where('id','=',$request->input('id'))
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID);

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
             $update = DB::table('tipeorderresto')
                ->where('id','=', $request->input('id'))
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->update(
                    [
                        'NamaJenisOrder'=>$request->input('NamaJenisOrder'),
                        'Icon'=>$request->input('Icon')
                    ]
                );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Tipe Order Resto Gagal';
                }
            } else{
                $data['message'] = 'Tipe Order Resto not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
    	try {
    		$tipeorderresto = DB::table('tipeorderresto')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($tipeorderresto) {
	        	alert()->success('Success','Delete Tipe Order Resto berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Tipe Order Resto Gagal.');
	        }
	        return redirect('tipeorderresto');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
