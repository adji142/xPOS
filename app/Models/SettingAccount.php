<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAccount extends Model
{
    use HasFactory;
    protected $table = 'settingaccount';

    public function GetSetting($FieldSetting)
    {
    	$DaftarAccount = DB::select(DB::raw("SELECT ".$FieldSetting." AS AccountCode FROM settingaccount WHERE RecordOwnerID = '".Auth::user()->RecordOwnerID."'" ))->first();

    	$AccountCode = "";
    	if ($DaftarAccount) {
    		$AccountCode = $DaftarAccount->AccountCode;
    	}

    	return $AccountCode;
    }
}
