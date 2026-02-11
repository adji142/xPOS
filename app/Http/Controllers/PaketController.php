<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Paket;
use App\Models\Company;

class PaketController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['NamaPaket'];
        $keyword = $request->input('keyword');
        $JenisPaket = $request->input('JenisPaket');

        $paket = Paket::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
                // ->where('JenisPaket', '=', $JenisPaket)->get();

        // $bank = $bank->paginate(4);

        $title = 'Delete Paket Transaksi !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Sewa.Paket",[
            'paket' => $paket, 
            'oldJenisPaket' => $JenisPaket
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");
        $JenisPaket = $request->input('JenisPaket');

        $paket = Paket::where('RecordOwnerID','=',Auth::user()->RecordOwnerID);
        if ($JenisPaket != "") {
            $paket->where('JenisPaket', $JenisPaket);
        }


        $data['data']= $paket->get();
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$paket = Paket::where('id','=',$id)->get();

        $company = Company::where('KodePartner', Auth::user()->RecordOwnerID)->first();
        $jenisLangganan = [];
        if ($company && $company->JenisLangganan) {
            $jenisLangganan = json_decode($company->JenisLangganan, true);
        }
        
        return view("master.Sewa.Paket-Input",[
            'paket' => $paket,
            'jenisLangganan' => $jenisLangganan
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'NamaPaket'=>'required',
                'HargaNormal'=>'required',
                'JenisPaket' =>'required'
            ]);

            $model = new Paket;
            $model->NamaPaket = $request->input('NamaPaket');
            $model->PerubahanHarga = $request->input('PerubahanHarga');
            $model->AkhirJamNormal = $request->input('AkhirJamNormal');
            $model->AkhirJamPerubahanHarga = $request->input('AkhirJamPerubahanHarga');
            $model->HargaNormal = $request->input('HargaNormal');
            $model->HargaBaru = $request->input('HargaBaru');
            $model->DiskonTable = $request->input('DiskonTable');
            $model->DiskonFnB = $request->input('DiskonFnB');
            $model->JenisPaket = $request->input('JenisPaket');
            $model->DurasiPaket = $request->input('DurasiPaket');
            $model->BisaDipesan = $request->input('BisaDipesan');
            $model->JamCheckin = $request->input('JamCheckin');
            $model->JamCheckout = $request->input('JamCheckout');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Paket Berhasil disimpan.');
                return redirect('paket');
                
            }else{
                throw new \Exception('Penambahan Data Paket Gagal');
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
                'NamaPaket'=>'required',
                'HargaNormal'=>'required',
                'JenisPaket' =>'required'
            ]);

            $model = Paket::where('id','=',$request->input('id'))
                        ->where('RecordOwnerID','=', Auth::user()->RecordOwnerID);

            if ($model) {
                $update = DB::table('pakettransaksi')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                                    'NamaPaket' => $request->input('NamaPaket'),
                                    'PerubahanHarga' => $request->input('PerubahanHarga'),
                                    'AkhirJamNormal' => $request->input('AkhirJamNormal'),
                                    'AkhirJamPerubahanHarga' => $request->input('AkhirJamPerubahanHarga'),
                                    'HargaNormal' => $request->input('HargaNormal'),
                                    'HargaBaru' => $request->input('HargaBaru'),
                                    'DiskonTable' => $request->input('DiskonTable'),
                                    'DiskonFnB' => $request->input('DiskonFnB'),
                                    'JenisPaket' => $request->input('JenisPaket'),
                                    'DurasiPaket' => $request->input('DurasiPaket'),
                                    'BisaDipesan' => $request->input('BisaDipesan'),
                                    'JamCheckin' => $request->input('JamCheckin'),
                                    'JamCheckout' => $request->input('JamCheckout'),
                                    'RecordOwnerID' => Auth::user()->RecordOwnerID
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Paket berhasil disimpan.');
                    return redirect('paket');
                }else{
                    throw new \Exception('Edit Paket Gagal');
                }
            } else{
                throw new \Exception('Paket not found.');
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
    		$bank = DB::table('pakettransaksi')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($bank) {
	        	alert()->success('Success','Delete Paket berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Paket Gagal.');
	        }
	        return redirect('paket');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
