<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
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
        $jsonArray = '[{"KodeSatuan":"BALL","NamaSatuan":"BALL","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"BOTOL","NamaSatuan":"BOTOL","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"BOX","NamaSatuan":"BOX","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"BUNGKUS","NamaSatuan":"BUNGKUS","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"CANs","NamaSatuan":"CANs","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"GONI","NamaSatuan":"GONI","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"KALENG","NamaSatuan":"KALENG","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"KARDUS","NamaSatuan":"KARDUS","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"KARTON","NamaSatuan":"KARTON","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"LITER","NamaSatuan":"LITER","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"LUSIN","NamaSatuan":"LUSIN","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"PACKs","NamaSatuan":"PACKs","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"PAPAN","NamaSatuan":"PAPAN","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"PCs","NamaSatuan":"PCs","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"SLOF","NamaSatuan":"SLOF","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"STRIP","NamaSatuan":"STRIP","RecordOwnerID":"'.$RecordOwnerID.'"},{"KodeSatuan":"SUPPORT","NamaSatuan":"SUPPORT","RecordOwnerID":"'.$RecordOwnerID.'"}]';
        $array = json_decode($jsonArray, true);
        DB::table('satuan')->insert($array);
    }
}
