<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\MenuAddon;

class MenuAddonController extends Controller
{
    public function View(Request $request)
    {
        $menuaddon = MenuAddon::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        // $bank = $bank->paginate(4);

        $title = 'Delete Menu Addon !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("Resto.menuaddon",[
            'menuaddon' => $menuaddon, 
        ]);
    }
    public function ViewJson(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $menuaddon = MenuAddon::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $data['data']= $menuaddon;
        return response()->json($data);
    }

    public function Form($id = null)
    {
    	$menuaddon = MenuAddon::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                    ->where('id', $id)
                    ->get();
        
        return view("Resto.menuaddon-Input",[
            'menuaddon' => $menuaddon
        ]);
    }

    public function store(Request $request)
    {
    	Log::debug($request->all());
        try {
            $model = new MenuAddon;
            $model->NamaAddon = $request->input('NamaAddon');
            $model->HargaAddon = $request->input('HargaAddon');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                alert()->success('Success','Data Menu Addon Berhasil disimpan.');
                return redirect('bank');
                
            }else{
                throw new \Exception('Penambahan Data Menu Addon Gagal disimpan');
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
            $model = MenuAddon::where('id','=',$request->input('id'))
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID);

            if ($model) {
            	// $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
                $update = DB::table('menuaddon')
                			->where('id','=', $request->input('id'))
                            ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                			->update(
                				[
                					'NamaAddon'=>$request->input('NamaAddon'),
                					'HargaAddon'=>$request->input('HargaAddon')
                				]
                			);

                if ($update) {
                    alert()->success('Success','Data Menu Addon berhasil disimpan.');
                    return redirect('menuaddon');
                }else{
                    alert()->error('Error','Edit Menu Addon Gagal');
                    return redirect()->back();
                }
            } else{
                alert()->error('Error','Menu Addon Not Found');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        try {

            $model = new MenuAddon;
            $model->NamaAddon = $request->input('NamaAddon');
            $model->HargaAddon = $request->input('HargaAddon');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            $save = $model->save();

            if ($save) {
                $data['success'] = true;
                
            }else{
                $data['message'] = 'Penambahan Data Menu Addon Gagal';
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

            $model = MenuAddon::where('id','=',$request->input('id'))
                        ->where('RecordOwnerID', Auth::user()->RecordOwnerID);

            if ($model) {
                // $model->Kode = $request->input('Kode');
             //    $model->Nama = $request->input('Nama');
             $update = DB::table('menuaddon')
                ->where('id','=', $request->input('id'))
                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
                ->update(
                    [
                        'NamaAddon'=>$request->input('NamaAddon'),
                        'HargaAddon'=>$request->input('HargaAddon')
                    ]
                );

                if ($update) {
                    $data['success'] = true;
                }else{
                    $data['message'] = 'Edit Menu Addon Gagal';
                }
            } else{
                $data['message'] = 'Menu Addon not found.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
    	try {
    		$menuaddon = DB::table('menuaddon')
	                ->where('id','=', $request->id)
	                ->where('RecordOwnerID','=',Auth::user()->RecordOwnerID)
	                ->delete();

	        if ($menuaddon) {
	        	alert()->success('Success','Delete Menu Addon berhasil.');
	        }
	        else{
	        	alert()->error('Error','Delete Menu Addon Gagal.');
	        }
	        return redirect('menuaddon');
    	} catch (Exception $e) {
    		Log::debug($e->getMessage());

            alert()->error('Error',$e->getMessage());
    	}
    }
}
