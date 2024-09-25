<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengakuanBarangDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengakuanbarangdetail', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->integer('NoUrut');
            $table->string('KodeItem');
            $table->double('Qty');
            $table->string('Satuan');
            $table->double('Harga');
            $table->double('TotalTransaksi');
            $table->string('KodeGudang');
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
        Schema::dropIfExists('pengakuanbarangdetail');
    }
}
