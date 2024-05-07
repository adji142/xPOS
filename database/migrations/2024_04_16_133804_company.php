<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->string('KodePartner')->unique();
            $table->string('NamaPartner');
            $table->string('AlamatTagihan');
            $table->string('NoTlp');
            $table->string('NoHP');
            $table->string('NIKPIC');
            $table->string('NamaPIC');
            $table->string('tempStore');
            $table->string('icon');
            $table->date('StartSubs');
            $table->date('EndSubs');
            $table->integer('ExtraDays');
            $table->string('NPWP');
            $table->date('TglPKP');
            $table->double('PPN');
            $table->integer('isHargaJualIncludePPN');
            $table->integer('isPostingAkutansi');
            $table->string('NamaPosPrinter');
            $table->string('FooterNota');
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
        Schema::dropIfExists('company');
    }
}
