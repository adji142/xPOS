<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MetodePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodepembayaran', function (Blueprint $table) {
            $table->id();
            $table->string('NamaMetodePembayaran');
            $table->string('AkunPembayaran')->nullable();
            $table->text('Image')->nullable();
            $table->string('Active');
            $table->string('MetodeVerifikasi');
            $table->string('TipePembayaran');
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
        Schema::dropIfExists('metodepembayaran');
    }
}
