<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PembayaranPenjualanHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaranpenjualanheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('NoTransaksi');
            $table->date('TglTransaksi');
            $table->string('KodePelanggan');
            $table->double('TotalPembelian');
            $table->double('TotalPembayaran');
            $table->string('KodeMetodePembayaran');
            $table->string('NoReff')->nullable();
            $table->string('Keterangan')->nullable();
            $table->string('CreatedBy');
            $table->string('UpdatedBy');
            $table->integer('Posted');
            $table->string('Status');
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
        Schema::dropIfExists('pembayaranpenjualanheader');
    }
}
