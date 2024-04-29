<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Satuan;

class SatuanController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeSatuan','NamaSatuan'];
        $keyword = $request->input('keyword');

        $satuan = Satuan::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $satuan = $satuan->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.ItemMasterData.Satuan",[
            'satuan' => $satuan, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = Satuan::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeSatuan = null)
    {
    	$satuan = Satuan::where('KodeSatuan','=',$KodeSatuan)->get();
        
        return view("master.ItemMasterData.Satuan-Input",[
            'satuan' => $satuan
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeSatuan'=>'required',
                'NamaSatuan'=>'required'
            ]);

            $model = new Satuan;
            $model->KodeSatuan = $request->input('KodeSatuan');
            $model->NamaSatuan = $request->input('NamaSatuan');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Satuan Berhasil disimpan.');
                return redirect('satuan');
                
            }else{
                throw new \Exception('Penambahan Data Satuan Gagal');
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
                'KodeSatuan'=>'required',
                'NamaSatuan'=>'required'
            ]);

            $model = Satuan::where('KodeSatuan','=',$request->input('KodeSatuan'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('satuan')
                			->where('KodeSatuan','=', $request->input('KodeSatuan'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaSatuan'=>$request->input('NamaSatuan'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Satuan berhasil disimpan.');
                    return redirect('satuan');
                }else{
                    throw new \Exception('Edit Satuan Gagal');
                }
            } else{
                throw new \Exception('Satuan not found.');
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

            $model = new Satuan;
            $model->KodeSatuan = $request->input('KodeSatuan');
            $model->NamaSatuan = $request->input('NamaSatuan');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Satuan Gagal';
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

            $model = Satuan::where('KodeSatuan','=',$request->input('KodeSatuan'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('satuan')
                            ->where('KodeSatuan','=', $request->input('KodeSatuan'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaSatuan'=>$request->input('NamaSatuan'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Satuan Gagal';
                }
            } else{
                $data['message'] = 'Satuan not found.';
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
    		$satuan = DB::table('satuan')
	                ->where('KodeSatuan','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($satuan) {
	        	alert()->success('Success','Delete Satuan berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Satuan Gagal.');
	        }
	        return redirect('satuan');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
