<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\Bank;

class BankController extends Controller
{
    public function View(Request $request)
    {
    	$field = ['KodeBank','NamaBank'];
        $keyword = $request->input('keyword');

        $bank = Bank::Where(function ($query) use($keyword, $field) {
                    for ($i = 0; $i < count($field); $i++){
                        $query->orwhere($field[$i], 'like',  '%' . $keyword .'%');
                    }      
                })->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $bank = $bank->paginate(4);

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.Finance.Bank",[
            'bank' => $bank, 
        ]);
    }

    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jenisitem = Bank::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $jenisitem;
        return response()->json($data);
    }

    public function Form($KodeBank = null)
    {
    	$bank = Bank::where('KodeBank','=',$KodeBank)->get();
        
        return view("master.Finance.Bank-Input",[
            'bank' => $bank
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $this->validate($request, [
                'KodeBank'=>'required',
                'NamaBank'=>'required'
            ]);

            $model = new Bank;
            $model->KodeBank = $request->input('KodeBank');
            $model->NamaBank = $request->input('NamaBank');
            $model->NamaPemilik = $request->input('NamaPemilik');
            $model->NoRekeningBank = $request->input('NoRekeningBank');
            $model->CabangPembukaRekening = $request->input('CabangPembukaRekening');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Bank Berhasil disimpan.');
                return redirect('bank');
                
            }else{
                throw new \Exception('Penambahan Data Bank Gagal');
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
                'KodeBank'=>'required',
                'NamaBank'=>'required'
            ]);

            $model = Bank::where('KodeBank','=',$request->input('KodeBank'))->first();

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                // $update = DB::table('bank')
                // 			->where('KodeBank','=', $request->input('KodeBank'))
                //             ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                // 			->update(
                // 				[
                // 					'NamaBank'=>$request->input('NamaBank'),
                // 					'NamaPemilik'=>$request->input('NamaPemilik'),
                // 					'CabangPembukaRekening'=>$request->input('CabangPembukaRekening'),
                // 					'NoRekeningBank' => $request->input('NoRekeningBank')
                // 				]
                // 			);
                $model->NamaBank = $request->input('NamaBank');
                $model->NamaPemilik = $request->input('NamaPemilik');
                $model->CabangPembukaRekening = $request->input('CabangPembukaRekening');
                $model->NoRekeningBank = $request->input('NoRekeningBank');
                $model->save();
                
                alert()->success('Success','Data Bank berhasil disimpan.');
                return redirect('bank');
            } else{
                throw new \Exception('Bank not found.');
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

            $model = new Bank;
            $model->KodeBank = $request->input('KodeBank');
            $model->NamaBank = $request->input('NamaBank');
            $model->NamaPemilik = $request->input('NamaPemilik');
            $model->CabangPembukaRekening = $request->input('CabangPembukaRekening');
            $model->NoRekeningBank = $request->input('NoRekeningBank');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Bank Gagal';
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

            $model = Bank::where('KodeBank','=',$request->input('KodeBank'));

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('bank')
                            ->where('KodeBank','=', $request->input('KodeBank'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                            ->update(
                                [
                                    'NamaBank'=>$request->input('NamaBank'),
                					'NamaPemilik'=>$request->input('NamaPemilik'),
                					'CabangPembukaRekening'=>$request->input('CabangPembukaRekening'),
                					'NoRekeningBank' => $request->input('NoRekeningBank')
                                ]
                            );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Bank Gagal';
                }
            } else{
                $data['message'] = 'Bank not found.';
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
    		$bank = DB::table('bank')
	                ->where('KodeBank','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($bank) {
	        	alert()->success('Success','Delete Bank berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Bank Gagal.');
	        }
	        return redirect('bank');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
