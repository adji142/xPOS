<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FakturPenjualanHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakturpenjualanheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('Transaksi');
            $table->string('NoTransaksi')->unique();
            $table->datetime('TglTransaksi');
            $table->date('TglJatuhTempo');
            $table->string('NoReff');
            $table->string('KodePelanggan');
            $table->string('KodeTermin');
            $table->string('Termin');
            $table->double('TotalTransaksi');
            $table->double('Potongan');
            $table->double('Pajak');
            $table->double('TotalPembelian');
            $table->double('TotalRetur');
            $table->double('TotalPembayaran');
            $table->string('Status');
            $table->string('Keterangan')->nullable();
            $table->integer('Posted');
            $table->string('MetodeBayar')->nullable();
            $table->string('ReffPembayaran')->nullable();
            $table->string('KodeSales')->nullable();
            $table->string('CreatedBy');
            $table->string('UpdatedBy');
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
        Schema::dropIfExists('fakturpenjualanheader');
    }
}
