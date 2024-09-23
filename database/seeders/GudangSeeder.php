<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
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
        $jsonArray = '[{"KodeGudang":"UMM","NamaGudang":"UMUM","RecordOwnerID":"'.$RecordOwnerID.'"}]';
        $array = json_decode($jsonArray, true);
        DB::table('gudang')->insert($array);
    }
}
