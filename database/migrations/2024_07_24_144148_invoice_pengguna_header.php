<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoicePenggunaHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihanpenggunaheader', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->date('TglTransaksi');
            $table->date('TglJatuhTempo');
            $table->string('KodePaketLangganan');
            $table->text('Catatan');
            $table->string('KodePelanggan');
            $table->double('TotalTagihan');
            $table->double('TotalBayar');
            $table->String('Status');
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
        Schema::dropIfExists('tagihanpenggunaheader');
    }
}
