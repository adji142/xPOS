<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\JenisItem;

class JenisItemController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeJenis','NamaJenis'];
        $keyword = $request->input('keyword');

        $jenisitem = JenisItem::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $jenisitem = $jenisitem->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.ItemMasterData.JenisItem",[
            'jenisitem' => $jenisitem, 
        ]);
    }

    public function Form($KodeJenis = null)
    {
    	$jenisitem = JenisItem::where('KodeJenis','=',$KodeJenis)->get();
        
        return view("master.ItemMasterData.JenisItem-Input",[
            'jenisitem' => $jenisitem
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeJenis'=>'required',
                'NamaJenis'=>'required'
            ]);

            $model = new JenisItem;
            $model->KodeJenis = $request->input('KodeJenis');
            $model->NamaJenis = $request->input('NamaJenis');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Jenis Item Berhasil disimpan.');
                return redirect('jenisitem');
                
            }else{
                throw new \Exception('Penambahan Data Jenis Item Gagal');
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
                'KodeJenis'=>'required',
                'NamaJenis'=>'required'
            ]);

            $model = JenisItem::where('KodeJenis','=',$request->input('KodeJenis'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('jenisitem')
                			->where('KodeJenis','=', $request->input('KodeJenis'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaJenis'=>$request->input('NamaJenis'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Jenis Item berhasil disimpan.');
                    return redirect('jenisitem');
                }else{
                    throw new \Exception('Edit Jenis Item Gagal');
                }
            } else{
                throw new \Exception('Jenis Item not found.');
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
    		$jenisitem = DB::table('jenisitem')
	                ->where('KodeJenis','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($jenisitem) {
	        	alert()->success('Success','Delete Jenis Item berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Jenis Item Gagal.');
	        }
	        return redirect('jenisitem');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
