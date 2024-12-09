<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableOrderHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tableorderheader', function (Blueprint $table) {
            $table->string('NoTransaksi')->primary();
            $table->date('TglTransaksi');
            $table->datetime('TglPencatatan');
            $table->string('JenisPaket'); // Jam, Menit, Full
            $table->integer('paketid');
            $table->integer('tableid');
            $table->string('KodeSales');
            $table->integer('DurasiPaket');
            $table->integer('Status'); // 0: Kosong, 1: Aktif, -1 : Checkout
            $table->string('KodePelanggan');
            $table->double('TaxTotal');
            $table->double('GrossTotal');
            $table->double('DiscTotal');
            $table->double('NetTotal');
            $table->datetime('JamMulai');
            $table->datetime('JamSelesai');
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
        Schema::dropIfExists('tableorderheader');
    }
}
