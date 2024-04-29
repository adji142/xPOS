<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemRakitan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemrakitan', function (Blueprint $table) {
            $table->string('KodeItemHasil');
            $table->double('QtyHasil');
            $table->String('KodeItemBahan');
            $table->String('Satuan');
            $table->double('QtyBahan');
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
        Schema::dropIfExists('itemrakitan');
    }
}
