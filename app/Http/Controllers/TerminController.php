<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Termin;

class TerminController extends Controller
{
    public function View(Request $request)
    {

        $termin = Termin::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $termin = $termin->paginate(4);

        $title = 'Delete Termin Pembayaran !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Finance.Termin",[
            'termin' => $termin, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = Termin::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$termin = Termin::where('id','=',$id)->get();
        
        return view("master.Finance.Termin-Input",[
            'termin' => $termin
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaTermin'=>'required',
                'JumlahHari' => 'required'
            ]);

            $model = new Termin;
            $model->NamaTermin = $request->input('NamaTermin');
            $model->JumlahHari = $request->input('JumlahHari');
            $model->ExtraDays = $request->input('ExtraDays');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Termin Berhasil disimpan.');
                return redirect('termin');
                
            }else{
                throw new \Exception('Penambahan Data Termin Gagal');
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
                'NamaTermin'=>'required'
            ]);

            $model = Termin::where('id','=',$request->input('id'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('terminpembayaran')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaTermin'=>$request->input('NamaTermin'),
                					'JumlahHari'=>$request->input('JumlahHari'),
                					'ExtraDays'=>$request->input('ExtraDays')
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Termin berhasil disimpan.');
                    return redirect('termin');
                }else{
                    throw new \Exception('Edit Termin Gagal');
                }
            } else{
                throw new \Exception('Termin not found.');
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

            $model = new Termin;
            $model->NamaTermin = $request->input('NamaTermin');
            $model->JumlahHari = $request->input('JumlahHari');
            $model->ExtraDays = $request->input('ExtraDays');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Termin Gagal';
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

            $model = Termin::where('id','=',$request->input('id'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('terminpembayaran')
                            ->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaTermin'=>$request->input('NamaTermin'),
                					'JumlahHari'=>$request->input('JumlahHari'),
                					'ExtraDays'=>$request->input('ExtraDays')
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Termin Gagal';
                }
            } else{
                $data['message'] = 'Metode Termin found.';
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
    		$termin = DB::table('terminpembayaran')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($termin) {
	        	alert()->success('Success','Delete Termin berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Termin Gagal.');
	        }
	        return redirect('termin');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
