<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\DiskonPeriodik;

class DiskonPeriodikController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['Deskripsi','Keterangan'];
        $keyword = $request->input('keyword');

        $diskonperiodik = DiskonPeriodik::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->get();

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("setting.diskonperiodik",[
            'diskonperiodik' => $diskonperiodik, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = DiskonPeriodik::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$diskonperiodik = DiskonPeriodik::where('id','=',$id)->get();
        
        return view("setting.diskonperiodik-input",[
            'diskonperiodik' => $diskonperiodik
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'TanggalMulai'=>'required',
                'TanggalSelesai'=>'required',
                'Deskripsi'=> 'required'
            ]);

            $model = new DiskonPeriodik;
            $model->TanggalMulai = $request->input('TanggalMulai');
            $model->TanggalSelesai = $request->input('TanggalSelesai');
            $model->Deskripsi = $request->input('Deskripsi');
            $model->Keterangan = $request->input('Keterangan');
            $model->CreatedBy = Auth::user()->name;
            $model->UpdatedBy = '';
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Diskon Periodik Berhasil disimpan.');
                return redirect('diskonperiodik');
                
            }else{
                throw new \Exception('Penambahan Data Diskon Periodik Gagal');
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
                'TanggalMulai'=>'required',
                'TanggalSelesai'=>'required',
                'Deskripsi'=> 'required'
            ]);

            $model = DiskonPeriodik::where('id','=',$request->input('id'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');

                \App\Services\DBLogger::update('diskonperiodik', ['id' => $request->input('id'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'TanggalMulai'=>$request->input('TanggalMulai'),
                    'TanggalSelesai'=>$request->input('TanggalSelesai'),
                    'Deskripsi'=>$request->input('Deskripsi'),
                    'Keterangan'=>$request->input('Keterangan'),
                    'UpdatedBy'=>Auth::user()->name,
                ]);

                alert()->success('Success','Data Diskon Periodik berhasil disimpan.');
                return redirect('diskonperiodik');

            } else{
                throw new \Exception('Diskon Periodik not found.');
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

            $model = new DiskonPeriodik;
            $model->KodeGudang = $request->input('KodeGudang');
            $model->NamaGudang = $request->input('NamaGudang');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data DiskonPeriodik Gagal';
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

            $model = DiskonPeriodik::where('KodeGudang','=',$request->input('KodeGudang'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                \App\Services\DBLogger::update('diskonperiodik', ['id' => $request->input('id'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'TanggalMulai'=>$request->input('TanggalMulai'),
                    'TanggalSelesai'=>$request->input('TanggalSelesai'),
                    'Deskripsi'=>$request->input('Deskripsi'),
                    'Keterangan'=>$request->input('Keterangan'),
                    'UpdatedBy'=>Auth::user()->name,
                ]);

                $data['success'] = true;
            } else{
                $data['message'] = 'DiskonPeriodik not found.';
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
    		$diskonperiodik = DB::table('diskonperiodik')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($diskonperiodik) {
	        	alert()->success('Success','Delete Diskon Periodik berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Diskon Periodik Gagal.');
	        }
	        return redirect('diskonperiodik');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
