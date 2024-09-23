<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaldoRekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldorekening', function (Blueprint $table) {
            $table->string('Periode')->unique();
            $table->string('KodeRekening')->unique();
            $table->double('SaldoAwal');
            $table->double('MutasiDebet');
            $table->double('MutasiKredit');
            $table->double('SaldoAkhir');
            $table->double('ValasSaldoAwal');
            $table->double('ValasMutasiDebet');
            $table->double('ValasMutasiKredit');
            $table->double('ValasSaldoAkhir');
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
        Schema::dropIfExists('saldorekening');
    }
}
