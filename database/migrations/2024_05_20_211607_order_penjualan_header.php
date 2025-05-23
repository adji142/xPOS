<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderPenjualanHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderpenjualanheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('NoTransaksi');
            $table->datetime('TglTransaksi');
            $table->date('TglJatuhTempo');
            $table->string('NoReff')->nullable();
            $table->string('KodePelanggan');
            $table->string('KodeTermin');
            $table->string('Termin');
            $table->double('TotalTransaksi');
            $table->double('Potongan');
            $table->double('Pajak');
            $table->double('TotalPenjualan');
            $table->double('TotalRetur');
            $table->double('TotalPembayaran');
            $table->string('Status');
            $table->longtext('Keterangan')->nullable();
            $table->longtext('SyaratDanKetentuan')->nullable();
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
        Schema::dropIfExists('orderpenjualanheader');
    }
}
