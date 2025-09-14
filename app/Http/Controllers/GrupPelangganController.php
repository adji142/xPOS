<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\GrupPelanggan;

class GrupPelangganController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeGrup','NamaGrup'];
        $keyword = $request->input('keyword');

        $gruppelanggan = GrupPelanggan::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

        $gruppelanggan = $gruppelanggan->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.BussinessPartner.GrupPelanggan",[
            'gruppelanggan' => $gruppelanggan, 
        ]);
    }

    public function Form($KodeGrup = null)
    {
    	$gruppelanggan = GrupPelanggan::where('KodeGrup','=',$KodeGrup)->get();
        
        return view("master.BussinessPartner.GrupPelanggan-Input",[
            'gruppelanggan' => $gruppelanggan
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeGrup'=>'required',
                'NamaGrup'=>'required'
            ]);

            $model = new GrupPelanggan;
            $model->KodeGrup = $request->input('KodeGrup');
            $model->NamaGrup = $request->input('NamaGrup');
            $model->LevelHarga = $request->input('LevelHarga');
            $model->DiskonPersen = $request->input('DiskonPersen');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Grup Pelanggan Berhasil disimpan.');
                return redirect('gruppelanggan');
                
            }else{
                throw new \Exception('Penambahan Data Gagal');
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
                'KodeGrup'=>'required',
                'NamaGrup'=>'required'
            ]);

            $model = GrupPelanggan::where('KodeGrup','=',$request->input('KodeGrup'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                \App\Services\DBLogger::update('gruppelanggan', ['KodeGrup' => $request->input('KodeGrup'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'NamaGrup'      => $request->input('NamaGrup'),
                    'LevelHarga'    => $request->input('LevelHarga'),
                    'DiskonPersen'  => $request->input('DiskonPersen')
                ]);

                alert()->success('Success','Data Grup Pelanggan berhasil disimpan.');
                return redirect('gruppelanggan');

            } else{
                throw new \Exception('Grup Pelanggan not found.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function editJson(Request $request)
    {
        $data = array('success' => false, 'message' => '');
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeGrup'=>'required',
                'NamaGrup'=>'required'
            ]);

            $model = GrupPelanggan::where('KodeGrup','=',$request->input('KodeGrup'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                \App\Services\DBLogger::update('gruppelanggan', ['KodeGrup' => $request->input('KodeGrup'), 'RecordOwnerID' => Auth::user()->RecordOwnerID], [
                    'NamaGrup'      => $request->input('NamaGrup'),
                    'LevelHarga'    => $request->input('LevelHarga'),
                    'DiskonPersen'  => $request->input('DiskonPersen')
                ]);

                $data['success'] = true;
            } else{
                $data['message'] = 'Grup Pelanggan not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
        $gruppelanggan = DB::table('gruppelanggan')
                ->where('KodeGrup','=', $request->id)
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->delete();

        if ($gruppelanggan) {
        	alert()->success('Success','Delete Grup Pelanggan berhasil.');
        }
        else{
        	alert()->error('Error','Delete Grup Pelanggan Gagal.');
        }
        return redirect('gruppelanggan');
    }
}
