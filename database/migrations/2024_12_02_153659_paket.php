<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakettransaksi', function (Blueprint $table) {
            $table->id();
            $table->string('NamaPaket');
            $table->integer('PerubahanHarga')->nullable();
            $table->time('AkhirJamNormal')->nullable();
            $table->time('AkhirJamPerubahanHarga')->nullable();
            $table->double('HargaNormal');
            $table->double('HargaBaru')->nullable();
            $table->double('DiskonTable')->nullable();
            $table->double('DiskonFnB')->nullable();
            $table->String('JenisPaket');// Jam, Menit, Full
            $table->integer('DurasiPaket')->nullable();
            $table->String('RecordOwnerID');
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
        Schema::dropIfExists('pakettransaksi');
    }
}
