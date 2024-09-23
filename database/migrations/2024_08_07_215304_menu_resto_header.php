<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MenuRestoHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuheader', function (Blueprint $table) {
            $table->id();
            $table->String('KodeItemHasil');
            $table->double('QtyHasil');
            $table->String('Satuan');
            $table->text('Image');
            $table->double('HargaPokokStandar');
            $table->double('HargaJual');
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
        Schema::dropIfExists('menuheader');
    }
}
