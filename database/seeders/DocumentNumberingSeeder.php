<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentNumberingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected static $RecordOwnerID;
    public static function setParameter($RecordOwnerID)
    {
        self::$RecordOwnerID= $RecordOwnerID;
    }
    public function run()
    {
        $RecordOwnerID= self::$RecordOwnerID;
        $jsonArray = '[{"DocumentID":"CONS","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.'"},{"DocumentID":"FPB","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.'"},{"DocumentID":"GI","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"GR","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"JE","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"OUTPAY","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"PBL","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"POS","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"POSDRF","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.' "},{"DocumentID":"RTB","prefix":"","NumberLength":"6","RecordOwnerID":"'.$RecordOwnerID.'"}]';
        $array = json_decode($jsonArray, true);
        DB::table('documentnumbering')->insert($array);
    }
}
