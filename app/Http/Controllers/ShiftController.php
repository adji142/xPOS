<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Shift;

class ShiftController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeShift','NamaShift'];
        $keyword = $request->input('keyword');

        $shift = Shift::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $shift = $shift->paginate(4);

        $title = 'Delete Shift !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("setting.Shift",[
            'shift' => $shift, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = Shift::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeShift = null)
    {
    	$shift = Shift::where('KodeShift','=',$KodeShift)->get();
        
        return view("setting.Shift-Input",[
            'shift' => $shift
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeShift'=>'required',
                'NamaShift'=>'required'
            ]);

            $model = new Shift;
            $model->KodeShift = $request->input('KodeShift');
            $model->NamaShift = $request->input('NamaShift');
            $model->JamMulai = $request->input('JamMulai');
            $model->JamSelesai = $request->input('JamSelesai');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Shift Berhasil disimpan.');
                return redirect('shift');
                
            }else{
                throw new \Exception('Penambahan Data Shift Gagal');
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
                'KodeShift'=>'required',
                'NamaShift'=>'required'
            ]);

            $model = Shift::where('KodeShift','=',$request->input('KodeShift'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('shift')
                			->where('KodeShift','=', $request->input('KodeShift'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaShift'=>$request->input('NamaShift'),
                					'JamMulai'=>$request->input('JamMulai'),
                					'JamSelesai'=>$request->input('JamSelesai'),
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Shift berhasil disimpan.');
                    return redirect('shift');
                }else{
                    throw new \Exception('Edit Shift Gagal');
                }
            } else{
                throw new \Exception('Shift not found.');
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

            $model = new Shift;
            $model->KodeShift = $request->input('KodeShift');
            $model->NamaShift = $request->input('NamaShift');
            $model->JamMulai = $request->input('JamMulai');
            $model->JamSelesai = $request->input('JamSelesai');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Shift Gagal';
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

            $model = Shift::where('KodeShift','=',$request->input('KodeShift'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('shift')
                            ->where('KodeShift','=', $request->input('KodeShift'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaShift'=>$request->input('NamaShift'),
                					'JamMulai'=>$request->input('JamMulai'),
                					'JamSelesai'=>$request->input('JamSelesai'),
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Shift Gagal';
                }
            } else{
                $data['message'] = 'Shift not found.';
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
    		$shift = DB::table('shift')
	                ->where('KodeShift','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($shift) {
	        	alert()->success('Success','Delete Shift berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Shift Gagal.');
	        }
	        return redirect('shift');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
