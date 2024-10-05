<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\DocumentType;

class DocumentNumbering extends Model
{
    use HasFactory;
    protected $table = "documentnumbering";

    public function GetNewDoc($DocType, $TableName, $ColomnName)
    {
    	$currentDate = Carbon::now();
		$Year = $currentDate->format('y');
		$Month = $currentDate->format('m');

		$prefix = $Year.$Month;

		$Numbering = $this->where('DocumentID',$DocType)
						->where('RecordOwnerID', Auth::user()->RecordOwnerID)
						->first();

		$CharLength = 0;

		// var_dump($Numbering->prefix);

		if ($Numbering) {
			$prefix = $Numbering->prefix.$prefix;
			$CharLength = $Numbering->NumberLength;
		}
		else{
			$CharLength = 10;
		}

		$lastNoTRX = DB::select(DB::raw("SELECT * FROM ".$TableName." WHERE LEFT(".$ColomnName.", ".strlen($prefix).") = '".$prefix."' AND RecordOwnerID = '".Auth::user()->RecordOwnerID."'" ));
		// var_dump($lastNoTRX);
		$NoTransaksi = $prefix.str_pad(count($lastNoTRX) + 1, $CharLength, '0', STR_PAD_LEFT);

		return $NoTransaksi;
    }

	public function GetNewDocMobile($DocType, $TableName, $ColomnName, $RecordOwnerID)
    {
    	$currentDate = Carbon::now();
		$Year = $currentDate->format('y');
		$Month = $currentDate->format('m');

		$prefix = $Year.$Month;

		$Numbering = $this->where('DocumentID',$DocType)
						->where('RecordOwnerID', $RecordOwnerID)
						->first();

		$CharLength = 0;

		// var_dump($Numbering->prefix);

		if ($Numbering) {
			$prefix = $Numbering->prefix.$prefix;
			$CharLength = $Numbering->NumberLength;
		}
		else{
			$CharLength = 10;
		}

		$lastNoTRX = DB::select(DB::raw("SELECT * FROM ".$TableName." WHERE LEFT(".$ColomnName.", ".strlen($prefix).") = '".$prefix."' AND RecordOwnerID = '".$RecordOwnerID."'" ));
		// var_dump($lastNoTRX);
		$NoTransaksi = $prefix.str_pad(count($lastNoTRX) + 1, $CharLength, '0', STR_PAD_LEFT);

		return $NoTransaksi;
    }
}
