<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\ItemMaster;

class SettingAccount extends Model
{
    use HasFactory;
    protected $table = 'settingaccount';

    public function GetSetting($FieldSetting)
    {
    	$DaftarAccount = DB::select(DB::raw("SELECT ".$FieldSetting." AS AccountCode FROM settingaccount WHERE RecordOwnerID = '".Auth::user()->RecordOwnerID."'" ));

      // var_dump($DaftarAccount[0]->AccountCode);
    	$AccountCode = "";
    	$AccountCode = $DaftarAccount[0]->AccountCode;

    	return $AccountCode;
    }

    public function GetInventoryAccount($KodeItem)
    {
      $KodeAkun = "";

      $itemmaster = ItemMaster::selectRaw("COALESCE(AcctPersediaan, '') AcctPersediaan"
                      )->where('KodeItem',$KodeItem)
                      ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                      ->first();
      
      $oCompany = SettingAccount::selectRaw("COALESCE(InvAcctPersediaan,'') InvAcctPersediaan")
                  ->where('RecordOwnerID', Auth::user()->RecordOwnerID)->first();

      if ($itemmaster->AcctPersediaan != "") {
        $KodeAkun = $itemmaster->AcctPersediaan;
        goto jump;
      }

      if ($oCompany->InvAcctPersediaan != "") {
        $KodeAkun = $oCompany->InvAcctPersediaan;
        goto jump; 
      }

      jump:

      return $KodeAkun;
    }
}
