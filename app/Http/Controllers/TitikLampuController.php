<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use App\Models\Company;
use App\Models\TitikLampu;
use App\Models\MasterController;

class TitikLampuController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['NamaTitikLampu'];
        $keyword = $request->input('keyword');
        $ControllerID = $request->input('ControllerID');

        $titiklampu = TitikLampu::selectRaw("titiklampu.*,mastercontroller.NamaController")
                ->join('mastercontroller', function ($value)  {
                    $value->on('titiklampu.ControllerID','=','mastercontroller.id')
                    ->on('titiklampu.RecordOwnerID','=','mastercontroller.RecordOwnerID');
                })
                ->Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('titiklampu.RecordOwnerID','=',Auth::user()->RecordOwnerID);
        
                if ($ControllerID > 0) {
                    $titiklampu->where('titiklampu.ControllerID', $ControllerID);
                }
        $title = 'Delete Titik Lampu !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("controller.titiklampu",[
            'titiklampu' => $titiklampu->get()
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = TitikLampu::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($id = null)
    {
        $controller = MasterController::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
    	$titiklampu = TitikLampu::where('id','=',$id)->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        
        return view("controller.titiklampu-Input",[
            'titiklampu' => $titiklampu,
            'controller' => $controller
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaTitikLampu'=>'required',
                'DigitalInput'=>'required',
                'ControllerID' =>'required',
            ]);

            $model = new TitikLampu;
            $model->NamaTitikLampu = $request->input('NamaTitikLampu');
            $model->DigitalInput = $request->input('DigitalInput');
            $model->ControllerID = $request->input('ControllerID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Titik Lampu Berhasil disimpan.');
                return redirect('titiklampu');
                
            }else{
                throw new \Exception('Penambahan Data Titik Lampu Gagal');
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
                'NamaTitikLampu'=>'required',
                'DigitalInput'=>'required',
                'ControllerID' =>'required',
            ]);

            $model = TitikLampu::where('id','=',$request->input('id'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('titiklampu')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaTitikLampu'=>$request->input('NamaTitikLampu'),
                                    'DigitalInput'=>$request->input('DigitalInput'),
                                    'ControllerID'=>$request->input('ControllerID'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Titik Lampu berhasil disimpan.');
                    return redirect('titiklampu');
                }else{
                    throw new \Exception('Edit Titik Lampu Gagal');
                }
            } else{
                throw new \Exception('Titik Lampu not found.');
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

            $model = new TitikLampu;
            $model->NamaTitikLampu = $request->input('NamaTitikLampu');
            $model->DigitalInput = $request->input('DigitalInput');
            $model->ControllerID = $request->input('ControllerID');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Titik Lampu Gagal';
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

            $model = TitikLampu::where('id','=',$request->input('id'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('titiklampu')
                            ->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaTitikLampu'=>$request->input('NamaTitikLampu'),
                                    'DigitalInput'=>$request->input('DigitalInput'),
                                    'ControllerID'=>$request->input('ControllerID'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Titik Lampu Gagal';
                }
            } else{
                $data['message'] = 'Titik Lampu Not found.';
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
    		$meja = DB::table('titiklampu')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($meja) {
	        	alert()->success('Success','Delete Titik Lampu berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Titik Lampu Gagal.');
	        }
	        return redirect('titiklampu');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }

    public function getMeja()
    {
        $data = TitikLampu::select('id', 'NamaTitikLampu', 'BisaDipesan')->get();
        return response()->json($data);
    }

    public function updateStatusMeja(Request $request)
    {
       
        $update = DB::table('titiklampu')
        ->where('id','=', $request->input('id'))
        ->update(
            [
                'BisaDipesan'=>$request->input('BisaDipesan'),
            ]
        );

        if ($update) {
            return response()->json(['success' => true, 'message' => 'Status meja berhasil diperbarui!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Edit Titik Lampu Gagal'], 400);
        }

    }

}
