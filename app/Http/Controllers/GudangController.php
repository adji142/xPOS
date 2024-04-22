<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Gudang;

class GudangController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeGudang','NamaGudang'];
        $keyword = $request->input('keyword');

        $gudang = Gudang::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $gudang = $gudang->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.ItemMasterData.Gudang",[
            'gudang' => $gudang, 
        ]);
    }

    public function Form($KodeGudang = null)
    {
    	$gudang = Gudang::where('KodeGudang','=',$KodeGudang)->get();
        
        return view("master.ItemMasterData.Gudang-Input",[
            'gudang' => $gudang
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeGudang'=>'required',
                'NamaGudang'=>'required'
            ]);

            $model = new Gudang;
            $model->KodeGudang = $request->input('KodeGudang');
            $model->NamaGudang = $request->input('NamaGudang');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Gudang Berhasil disimpan.');
                return redirect('gudang');
                
            }else{
                throw new \Exception('Penambahan Data Gudang Gagal');
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
                'KodeGudang'=>'required',
                'NamaGudang'=>'required'
            ]);

            $model = Gudang::where('KodeGudang','=',$request->input('KodeGudang'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('gudang')
                			->where('KodeGudang','=', $request->input('KodeGudang'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaGudang'=>$request->input('NamaGudang'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Gudang berhasil disimpan.');
                    return redirect('gudang');
                }else{
                    throw new \Exception('Edit Gudang Gagal');
                }
            } else{
                throw new \Exception('Gudang not found.');
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
    	try {
    		$gudang = DB::table('gudang')
	                ->where('KodeGudang','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($gudang) {
	        	alert()->success('Success','Delete Gudang berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Gudang Gagal.');
	        }
	        return redirect('gudang');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
