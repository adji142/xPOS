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
    public function run()
    {
        DB::table('settingaccount')->insert([
        	'InvAcctHargaPokokPenjualan' =>'',
			'InvAcctPendapatanJual' =>'',
			'InvAcctPendapatanJasa' =>'',
			'InvAcctPersediaan' =>'',
			'InvAcctPendapatanNonInventory' =>'',
			'InvAcctPendapatanLainLain' =>'',
			'InvAcctPenyesuaiaanStockMasuk' =>'',
			'InvAcctPenyesuaiaanStockKeluar' =>'',
			'PbAcctPajakPembelian' =>'',
			'PbAcctPembayaranTunai' =>'',
			'PbAcctPembayaranNonTunai' =>'',
			'PbAcctHutang' =>'',
			'PbAcctUangMukaPembelian' =>'',
			'PjAcctPajakPenjualan' =>'',
			'PjAcctPenjualanTunai' =>'',
			'PjAcctPenjualanNonTunai' =>'',
			'PjAcctPiutang' =>'',
			'PjAcctUangMukaPenjualan' =>'',
			'KnAcctHutangKonsinyasi' =>'',
			'KnAcctPembayaranHutang' =>'',
			'OthAcctModal' =>'',
			'OthAcctPrive' =>'',
			'OthAcctLabaDitahan' =>'',
			'OthAcctLabaTahunBerjalan' =>'',
			'RecordOwnerID' => 'CL0001'
        ]);
    }
}
