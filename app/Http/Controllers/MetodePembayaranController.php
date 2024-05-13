<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\MetodePembayaran;
use App\Models\Rekening;

class MetodePembayaranController extends Controller
{
    public function View(Request $request)
    {
        $sql = "metodepembayaran.*, rekeningakutansi.NamaRekening ";
        $metodepembayaran = MetodePembayaran::selectRaw($sql)
                            ->leftJoin('rekeningakutansi', function ($value){
                                $value->on('rekeningakutansi.KodeRekening','=','metodepembayaran.AkunPembayaran')
                                ->on('rekeningakutansi.RecordOwnerID','=','metodepembayaran.RecordOwnerID');
                            })
                            ->where('metodepembayaran.RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $metodepembayaran = $metodepembayaran->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Finance.MetodePembayaran",[
            'metodepembayaran' => $metodepembayaran, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = MetodePembayaran::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$metodepembayaran = MetodePembayaran::where('id','=',$id)->get();
        $rekeningakutansi = Rekening::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->where('Jenis','=',2)->get();
        
        return view("master.Finance.MetodePembayaran-Input",[
            'metodepembayaran' => $metodepembayaran,
            'rekeningakutansi' => $rekeningakutansi
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaMetodePembayaran'=>'required'
            ]);

            $model = new MetodePembayaran;
            $model->NamaMetodePembayaran = $request->input('NamaMetodePembayaran');
            $model->AkunPembayaran = $request->input('AkunPembayaran');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Metode Pembayaran Berhasil disimpan.');
                return redirect('metodepembayaran');
                
            }else{
                throw new \Exception('Penambahan Data Metode Pembayaran Gagal');
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
                'NamaMetodePembayaran'=>'required'
            ]);

            $model = MetodePembayaran::where('id','=',$request->input('id'));

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('metodepembayaran')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaMetodePembayaran'=>$request->input('NamaMetodePembayaran'),
                                    'AkunPembayaran' => $request->input('AkunPembayaran')
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Metode Pembayaran berhasil disimpan.');
                    return redirect('metodepembayaran');
                }else{
                    throw new \Exception('Edit Metode Pembayaran Gagal');
                }
            } else{
                throw new \Exception('Metode Pembayaran not found.');
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

            $model = new MetodePembayaran;
            $model->NamaMetodePembayaran = $request->input('NamaMetodePembayaran');
            $model->AkunPembayaran = $request->input('AkunPembayaran');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Metode Pembayaran Gagal';
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

            $model = MetodePembayaran::where('id','=',$request->input('id'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('metodepembayaran')
                            ->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaMetodePembayaran'=>$request->input('NamaMetodePembayaran'),
                                    'AkunPembayaran' => $request->input('AkunPembayaran')
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Metode Pembayaran Gagal';
                }
            } else{
                $data['message'] = 'Metode Pembayaran not found.';
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
    		$metodepembayaran = DB::table('metodepembayaran')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($metodepembayaran) {
	        	alert()->success('Success','Delete MetodePembayaran berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete MetodePembayaran Gagal.');
	        }
	        return redirect('metodepembayaran');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
