<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderPenjualanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderpenjualandetail', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->integer('NoUrut');
            $table->string('KodeItem');
            $table->double('Qty');
            $table->string('Satuan');
            $table->double('Harga');
            $table->double('Discount');
            $table->double('HargaNet');
            $table->string('LineStatus');
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
        Schema::dropIfExists('orderpenjualandetail');
    }
}
