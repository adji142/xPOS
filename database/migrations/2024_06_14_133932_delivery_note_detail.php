<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryNoteDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverynotedetail', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->string('BaseReff');
            $table->integer('BaseLine');
            $table->string('BaseType');
            $table->integer('NoUrut');
            $table->string('KodeItem');
            $table->double('Qty');
            $table->double('QtyKonversi');
            $table->string('Satuan');
            $table->double('Harga');
            $table->double('Discount');
            $table->double('HargaNet');
            $table->string('LineStatus');
            $table->string('KodeGudang');
            $table->string('Keterangan');
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
        Schema::dropIfExists('deliverynotedetail');
    }
}
