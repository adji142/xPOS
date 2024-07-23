<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KelompokMeja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompokmeja', function (Blueprint $table) {
            $table->string('KodeKelompokMeja')->unique();
            $table->string('NamaKelompokMeja');
            $table->string('RecordOwnerID')->unique();
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
        Schema::dropIfExists('kelompokmeja');
    }
}
