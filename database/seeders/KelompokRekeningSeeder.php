<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokRekeningSeeder extends Seeder
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
        $jsonArray = '[{"NamaKelompok":"ASSETS","Kelompok":"1","Posisi":"1","FooterLaporan":"","NeracaLR":"1","RecordOwnerID":"'.$RecordOwnerID.'"},{"NamaKelompok":"HUTANG","Kelompok":"1","Posisi":"2","FooterLaporan":"","NeracaLR":"1","RecordOwnerID":"'.$RecordOwnerID.'"},{"NamaKelompok":"EKUITAS","Kelompok":"1","Posisi":"2","FooterLaporan":"","NeracaLR":"1","RecordOwnerID":"'.$RecordOwnerID.'"},{"NamaKelompok":"TURNOVER","Kelompok":"2","Posisi":"2","FooterLaporan":"","NeracaLR":"2","RecordOwnerID":"'.$RecordOwnerID.'"},{"NamaKelompok":"COST OF SALES","Kelompok":"2","Posisi":"1","FooterLaporan":"01. LABA KOTOR","NeracaLR":"2","RecordOwnerID":"'.$RecordOwnerID.'"},{"NamaKelompok":"OPERATING COSTS","Kelompok":"2","Posisi":"1","FooterLaporan":"02. LABA USAHA","NeracaLR":"2","RecordOwnerID":"'.$RecordOwnerID.'"},{"NamaKelompok":"NON-OPERATING INCOME AND EXPENDITURE","Kelompok":"2","Posisi":"2","FooterLaporan":"03. LABA SEBELUM PAJAK","NeracaLR":"2","RecordOwnerID":"'.$RecordOwnerID.'"}]';
        $array = json_decode($jsonArray, true);
        DB::table('kelompokrekening')->insert($array);
    }
}
