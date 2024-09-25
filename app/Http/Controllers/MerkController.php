<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Merk;

class MerkController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeMerk','NamaMerk'];
        $keyword = $request->input('keyword');

        $merk = Merk::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $merk = $merk->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.ItemMasterData.Merk",[
            'merk' => $merk, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = Merk::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeMerk = null)
    {
    	$merk = Merk::where('KodeMerk','=',$KodeMerk)->get();
        
        return view("master.ItemMasterData.Merk-Input",[
            'merk' => $merk
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeMerk'=>'required',
                'NamaMerk'=>'required'
            ]);

            $model = new Merk;
            $model->KodeMerk = $request->input('KodeMerk');
            $model->NamaMerk = $request->input('NamaMerk');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Merk Berhasil disimpan.');
                return redirect('merk');
                
            }else{
                throw new \Exception('Penambahan Data Merk Gagal');
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
                'KodeMerk'=>'required',
                'NamaMerk'=>'required'
            ]);

            $model = Merk::where('KodeMerk','=',$request->input('KodeMerk'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('merk')
                			->where('KodeMerk','=', $request->input('KodeMerk'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaMerk'=>$request->input('NamaMerk'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Merk berhasil disimpan.');
                    return redirect('merk');
                }else{
                    throw new \Exception('Edit Merk Gagal');
                }
            } else{
                throw new \Exception('Merk not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        Log::debug($request->all());
        try {

            $model = new Merk;
            $model->KodeMerk = $request->input('KodeMerk');
            $model->NamaMerk = $request->input('NamaMerk');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] =true;
            }else{
                $data['message'] = 'Penambahan Data Merk Gagal';
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

            $model = Merk::where('KodeMerk','=',$request->input('KodeMerk'));

            if ($model) {
                $update = DB::table('merk')
                            ->where('KodeMerk','=', $request->input('KodeMerk'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaMerk'=>$request->input('NamaMerk'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Merk Gagal';
                }
            } else{
                $data['message'] = 'Merk not found.';
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
    		$merk = DB::table('merk')
	                ->where('KodeMerk','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($merk) {
	        	alert()->success('Success','Delete Merk berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Merk Gagal.');
	        }
	        return redirect('merk');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
