<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\ItemMaster;

class ReportController extends Controller
{
    function KartuStock(Request $request){

        $TglAwal = $request->input('TglAwal');
        $TglAkhir = $request->input('TglAkhir');
        $KodeItem = $request->input('KodeItem');
        $RecordOwnerID = Auth::user()->RecordOwnerID;

        $kartustock = DB::select('CALL rsp_laporan_kartu_stock(?, ?, ?, ?)', [$TglAwal, $TglAkhir, $KodeItem, $RecordOwnerID]);
        $itemmaster = ItemMaster::where('RecordOwnerID', Auth::user()->RecordOwnerID)
                        ->where('Active', DB::raw("'Y'"))
                        ->get();

        return view("report.inventory.KartuStock",[
			'kartustock' => $kartustock,
            'itemmaster' => $itemmaster,
            'oldTglAwal' => $TglAwal,
            'oldTglAkhir' => $TglAkhir,
            'oldKodeItem' => $KodeItem,
		]);
    }
}
