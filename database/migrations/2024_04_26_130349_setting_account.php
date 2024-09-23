<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SettingAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settingaccount', function (Blueprint $table) {
            $table->id();
            $table->string('InvAcctHargaPokokPenjualan');
            $table->string('InvAcctPendapatanJual');
            $table->string('InvAcctPendapatanJasa');
            $table->string('InvAcctPersediaan');
            $table->string('InvAcctPendapatanNonInventory');
            $table->string('InvAcctPendapatanLainLain');
            $table->string('InvAcctPenyesuaiaanStockMasuk');
            $table->string('InvAcctPenyesuaiaanStockKeluar');
            $table->string('PbAcctPajakPembelian');
            $table->string('PbAcctPembayaranTunai');
            $table->string('PbAcctPembayaranNonTunai');
            $table->string('PbAcctHutang');
            $table->string('PbAcctUangMukaPembelian');
            $table->string('PjAcctPajakPenjualan');
            $table->string('PjAcctPenjualanTunai');
            $table->string('PjAcctPenjualanNonTunai');
            $table->string('PjAcctPiutang');
            $table->string('PjAcctUangMukaPenjualan');
            $table->string('KnAcctHutangKonsinyasi');
            $table->string('KnAcctPembayaranHutang');
            $table->string('OthAcctModal');
            $table->string('OthAcctPrive');
            $table->string('OthAcctLabaDitahan');
            $table->string('OthAcctLabaTahunBerjalan');
            $table->string('RecordOwnerID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settingaccount');
    }
}
