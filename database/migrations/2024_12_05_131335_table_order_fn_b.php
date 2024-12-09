<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableOrderFnB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tableorderfnb', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->integer('LineNumber');
            $table->string('KodeItem');
            $table->double('Qty');
            $table->double('Harga');
            $table->double('Tax');
            $table->double('Discount');
            $table->double('LineTotal');
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
        Schema::dropIfExists('tableorderfnb');
    }
}
