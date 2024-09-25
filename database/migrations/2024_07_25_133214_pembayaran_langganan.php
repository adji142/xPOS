<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PembayaranLangganan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarantagihan', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->date('TglTransaksi');
            $table->string('BaseReff');
            $table->string('MetodePembayaran');
            $table->string('NoReff');
            $table->string('Keterangan');
            $table->double('TotalBayar');
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
        Schema::dropIfExists('pembayarantagihan');
    }
}
