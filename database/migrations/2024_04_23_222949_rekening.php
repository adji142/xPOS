<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekeningakutansi', function (Blueprint $table) {
            $table->string('KodeRekening')->unique();
            $table->string('NamaRekening');
            $table->integer('KodeKelompok');
            $table->integer('Level');
            $table->integer('Jenis');
            $table->String('KodeRekeningInduk');
            $table->double('SaldoValas');
            $table->double('SaldoBase');
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
        Schema::dropIfExists('rekeningakutansi');
    }
}
