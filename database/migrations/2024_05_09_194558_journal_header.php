<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JournalHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('headerjurnal', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('KodeTransaksi');
            $table->string('NoTransaksi');
            $table->date('TglTransaksi');
            $table->date('NoReff');
            $table->date('StatusTransaksi');
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
        Schema::dropIfExists('headerjurnal');
    }
}
