<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JournalDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailjurnal', function (Blueprint $table) {
            $table->string('KodeTransaksi');
            $table->string('NoTransaksi');
            $table->integer('NoUrut');
            $table->string('KodeRekening');
            $table->string('KodeRekeningBukuBesar');
            $table->integer('DK');
            $table->string('KodeMataUang');
            $table->double('Valas');
            $table->double('NilaiTukar');
            $table->double('Jumlah');
            $table->double('Keterangan');
            $table->string('HeaderKas');
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
        Schema::dropIfExists('detailjurnal');
    }
}
