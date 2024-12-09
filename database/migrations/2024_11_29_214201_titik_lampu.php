<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TitikLampu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titiklampu', function (Blueprint $table) {
            $table->id();
            $table->string('NamaTitikLampu');
            $table->integer('DigitalInput');
            $table->integer('ControllerID');
            $table->integer('Status'); // 0: Off, 1: On, 2: Warning, -1: Checkout
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
        Schema::dropIfExists('titiklampu');
    }
}
