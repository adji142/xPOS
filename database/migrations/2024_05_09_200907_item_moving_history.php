<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemMovingHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemmovinghistory', function (Blueprint $table) {
            $table->string('KodeItem');
            $table->string('KodeGudang');
            $table->datetime('TglPencatatan');
            $table->string('BaseReff');
            $table->string('BaseType');
            $table->double('QtyIN');
            $table->double('QtyOut');
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
        Schema::dropIfExists('itemmovinghistory');
    }
}
