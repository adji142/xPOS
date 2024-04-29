<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemmaster', function (Blueprint $table) {
            $table->string('KodeItem')->unique();
            $table->string('NamaItem');
            $table->string('KodeJenisItem');
            $table->string('KodeMerk');
            $table->string('TypeItem');
            $table->string('Rak');
            $table->string('KodeGudang');
            $table->string('KodeSupplier');
            $table->string('Satuan');
            $table->string('Barcode');
            $table->text('Gambar');
            $table->double('HargaPokokPenjualan');
            $table->double('HargaJual');
            $table->double('HargaBeliTerakhir');
            $table->double('Stock');
            $table->double('StockMinimum');
            $table->string('isKonsinyasi'); // Y/N
            $table->string('Active'); // Y/N
            $table->string('AcctHPP');
            $table->string('AcctPenjualan');
            $table->string('AcctPenjualanJasa');
            $table->string('AcctPersediaan');
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
        Schema::dropIfExists('itemmaster');
    }
}
