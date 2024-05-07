<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\HargaJual;
use App\Models\ItemMaster;
use App\Models\JenisItem;
use App\Models\Merk;
use App\Models\Gudang;
use App\Models\Supplier;
use App\Models\Rekening;
use App\Models\Satuan;
use App\Models\SettingAccount;
use App\Models\ItemRakitan;

class HargaJualController extends Controller
{
    public function View(Request $request)
    {
    	$jenisitem = JenisItem::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();
       	$merk = Merk::where('RecordOwnerID','=',Auth::user()->RecordOwnerID)->get();

        $title = 'Delete Grup Pelanggan !';
        $text = "Are you sure you want to delete ?";
        confirmDelete($title, $text);
        return view("master.ItemMasterData.HargaJual",[
            'jenisitem' => $jenisitem,
            'merk' => $merk
        ]);
    }

    public function store(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'Kembalian' => "");

        $jsonData = $request->json()->all();


        Log::debug($request->all());
        DB::beginTransaction();

        $errorCount = 0;

        try {

            for ($i=0; $i < count($jsonData) ; $i++) { 
                $model = new HargaJual;
                $model->KodeItem = $jsonData[$i]['KodeItem'];
                $model->HargaJual = $jsonData[$i]['HargaJual'];
                $model->TipeMarkUp = -1;
                $model->RecordOwnerID = Auth::user()->RecordOwnerID;
                $save = $model->save();

                if (!$save) {
                    $data['message'] = "Gagal Simpan Data Harga Jual";
                    $errorCount +=1;
                    goto jump;
                }
            }

            jump:
            if ($errorCount > 0) {
                DB::rollback();
                $data['success'] = false;
            }
            else{
                DB::commit();
                $data['success'] = true;
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['success'] = false;
            $data['message'] = "Gagal Simpan Data ". $e->getMessage();
        }

        return response()->json($data);
    }
}
