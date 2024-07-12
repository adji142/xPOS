<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\JenisItem;
use App\Models\ItemMaster;
use App\Models\Company;

class KatalogController extends Controller
{
    public function View($RecordOwnerID)
    {
        $jenisitem = JenisItem::where('RecordOwnerID',$RecordOwnerID)
                        ->get(); 
        $company = Company::where("KodePartner", $RecordOwnerID)
                        ->get();
        return view("catalouge.catalouge",[
            'jenisitem' => $jenisitem,
            'RecOID' => $RecordOwnerID,
            'company' => $company
	    ]);
    }

    public function ViewItemMaster(Request $request)
    {
      $data = array('success'=>false, 'message'=>'', 'data'=>array());
      $KodeJenis = $request->input('KodeJenis');
      $Merk = $request->input('Merk');
      $TipeItem = $request->input('TipeItem');
      $Active = $request->input('Active');
      $Scan = $request->input('Scan');
      $TipeItemIN = $request->input('TipeItemIN');
      $RecordOwnerID = $request->input('RecordOwnerID');

      $oItem = new ItemMaster();
      $itemmaster = $oItem->GetItemData($RecordOwnerID,$KodeJenis, $Merk, $TipeItem,$TipeItemIN, $Active, $Scan,1);

      $data['data'] = $itemmaster->get();

      return response()->json($data);
    }
}
