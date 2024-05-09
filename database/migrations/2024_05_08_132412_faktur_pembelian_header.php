<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FakturPembelianHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fakturpembelianheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('NoTransaksi');
            $table->date('TglTransaksi');
            $table->date('TglJatuhTempo');
            $table->string('NoReff');
            $table->string('KodeSupplier');
            $table->string('KodeTermin');
            $table->string('Termin');
            $table->double('TotalTransaksi');
            $table->double('Potongan');
            $table->double('Pajak');
            $table->double('TotalPembelian');
            $table->double('TotalRetur');
            $table->double('TotalPembayaran');
            $table->string('Status');
            $table->string('Keterangan');
            $table->integer('Posted');
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
        Schema::dropIfExists('fakturpembelianheader');
    }
}
