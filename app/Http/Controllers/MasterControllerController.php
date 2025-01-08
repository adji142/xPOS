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
use App\Models\MasterController;

class MasterControllerController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['NamaController','SN'];
        $keyword = $request->input('keyword');

        $controller = MasterController::selectRaw("mastercontroller.*")
                ->Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $title = 'Delete Controller !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("controller.mastercontroller",[
            'controller' => $controller
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = MasterController::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$controller = MasterController::where('id','=',$id)->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
        
        return view("controller.mastercontroller-Input",[
            'controller' => $controller
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaController'=>'required',
                'SN'=>'required',
                'Port' =>'required',
                'BaudRate' =>'required'
            ]);

            $model = new MasterController;
            $model->NamaController = $request->input('NamaController');
            $model->SN = $request->input('SN');
            $model->Port = $request->input('Port');
            $model->BaudRate = $request->input('BaudRate');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Controller Berhasil disimpan.');
                return redirect('controller');
                
            }else{
                throw new \Exception('Penambahan Data Controller Gagal');
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
                'NamaController'=>'required',
                'SN'=>'required',
                'Port' =>'required',
                'BaudRate' =>'required'
            ]);

            $model = MasterController::where('id','=',$request->input('id'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('mastercontroller')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaController'=>$request->input('NamaController'),
                                    'SN'=>$request->input('SN'),
                                    'Port'=>$request->input('Port'),
                                    'BaudRate'=>$request->input('BaudRate'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Controller berhasil disimpan.');
                    return redirect('controller');
                }else{
                    throw new \Exception('Edit Controller Gagal');
                }
            } else{
                throw new \Exception('Controller not found.');
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

            $model = new MasterController;
            $model->NamaController = $request->input('NamaController');
            $model->SN = $request->input('SN');
            $model->Port = $request->input('Port');
            $model->BaudRate = $request->input('BaudRate');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Controller Gagal';
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

            $model = MasterController::where('KodeMeja','=',$request->input('KodeMeja'))->where('RecordOwnerID','=',Auth::user()->RecordOwnerID);

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('mastercontroller')
                            ->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaController'=>$request->input('NamaController'),
                                    'SN'=>$request->input('SN'),
                                    'Port'=>$request->input('Port'),
                                    'BaudRate'=>$request->input('BaudRate'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Controller Gagal';
                }
            } else{
                $data['message'] = 'Meja Controller found.';
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
    		$meja = DB::table('mastercontroller')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($meja) {
	        	alert()->success('Success','Delete Controller berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Controller Gagal.');
	        }
	        return redirect('controller');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }

    public function DeviceCommand(Request $request) {
        try {
            $model = MasterController::where('SN','=',$request->input('SN'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('mastercontroller')
                			->where('SN','=', $request->input('SN'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'Command'=>$request->input('Command'),
                				]
                			);

                if ($update) {
                    $data['success'] = true;
                    // alert()->success('Success','Data Merk berhasil disimpan.');
                    // return redirect('controller');
                }else{
                    // throw new \Exception('Manipulasi Controller Gagal');
                    $data['success'] = false;
                    $data['message'] = 'Manipulasi Controller Gagal';
                }
            } else{
                // throw new \Exception('Controller found.');
                $data['success'] = false;
                $data['message'] = 'Controller not found.';
            }
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            $data['success'] = false;
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    public function CheckCommand(Request $request) {
        $data = array('success' => false, 'Command'=>0);
        $controller = MasterController::where('SN','=',$request->input('SN'))
                        ->where('RecordOwnerID','=',$request->input('RecordOwnerID'))->get();
        if (count($controller) > 0) {
            $data['success'] = true;
            $data['Command'] = $controller[0]->Command;
        }
        return response()->json($data);
    }

}
