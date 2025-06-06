<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KasKeluarDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaskeluardetail', function (Blueprint $table) {
            $table->id();
            $table->String('NoTransaksi');
            $table->integer('LineNumber');
            $table->String('KodeAkun');
            $table->String('Keterangan');
            $table->double('TotalTransaksi');
            $table->String('RecordOwnerID')->unique();
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
        Schema::dropIfExists('kaskeluardetail');
    }
}
