<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliveryNoteHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverynoteheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('Transaksi');
            $table->string('NoTransaksi')->unique();
            $table->date('TglTransaksi');
            $table->date('TglJatuhTempo');
            $table->string('NoReff')->nullable();
            $table->string('KodePelanggan');
            $table->string('KodeTermin');
            $table->string('Termin');
            $table->double('TotalTransaksi');
            $table->double('Potongan');
            $table->double('Pajak');
            $table->double('TotalPembelian');
            $table->string('Status');
            $table->string('DeliveryStatus');
            $table->string('KeteranganPengiriman');
            $table->string('Keterangan')->nullable();
            $table->string('CreatedBy')->nullable();
            $table->string('UpdatedBy')->nullable();
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
        Schema::dropIfExists('deliverynoteheader');
    }
}
