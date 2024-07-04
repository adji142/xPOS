<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockOpnameHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockopnameheader', function (Blueprint $table) {
            $table->string('NoTransaksi')->unique();
            $table->string('Periode');
            $table->datetime('TglTransaksi');
            $table->datetime('TanggalMulai');
            $table->datetime('TanggalSelesai');
            $table->string('KodeKaryawan');
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
        Schema::dropIfExists('stockopnameheader');
    }
}
