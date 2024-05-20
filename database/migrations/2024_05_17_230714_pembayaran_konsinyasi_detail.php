<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PembayaranKonsinyasiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarankonsinyasidetail', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->integer('NoUrut');
            $table->string('BaseReff');
            $table->double('TotalPembayaran');
            $table->string('RecordOwnerID');
            $table->string('KodeMetodePembayaran');
            $table->string('Keterangan');
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
        Schema::dropIfExists('pembayarankonsinyasidetail');
    }
}
