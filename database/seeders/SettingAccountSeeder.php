<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingAccountSeeder extends Seeder
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
        $jsonArray = '[{"InvAcctHargaPokokPenjualan":"5110001","InvAcctPendapatanJual":"4110001","InvAcctPendapatanJasa":"","InvAcctPersediaan":"1310001","InvAcctPendapatanNonInventory":"","InvAcctPendapatanLainLain":"","InvAcctPenyesuaiaanStockMasuk":"7111001","InvAcctPenyesuaiaanStockKeluar":"8111001","PbAcctPajakPembelian":"1130001","PbAcctPembayaranTunai":"","PbAcctPembayaranNonTunai":"","PbAcctHutang":"2110001","PbAcctUangMukaPembelian":"","PjAcctPajakPenjualan":"2130001","PjAcctPenjualanTunai":"","PjAcctPenjualanNonTunai":"","PjAcctPiutang":"1140001","PjAcctUangMukaPenjualan":"4120001","PjAcctGoodsInTransit":"1310002","PjAcctReturnPenjualan":"4120001","KnAcctHutangKonsinyasi":"2110001","KnAcctPembayaranHutang":"","KnAcctPenerimaanKonsinyasi":"2110002","OthAcctModal":"","OthAcctPrive":"","OthAcctLabaDitahan":"","OthAcctLabaTahunBerjalan":"","RecordOwnerID":"'.$RecordOwnerID.'"}]';
        $array = json_decode($jsonArray, true);
        DB::table('settingaccount')->insert($array);
    }
}
