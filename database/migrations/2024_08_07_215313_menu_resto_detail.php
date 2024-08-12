<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MenuRestoDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menudetail', function (Blueprint $table) {
            $table->id();
            $table->String('Father');
            $table->String('KodeItemRM');
            $table->double('QtyBahan');
            $table->double('HargaPokok');
            $table->String('Satuan');
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
        Schema::dropIfExists('menudetail');
    }
}
