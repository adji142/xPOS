<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PenghapusanBarangHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghapusanbarangheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('NoTransaksi');
            $table->string('TglTransaksi');
            $table->string('NoReff');
            $table->string('Keterangan');
            $table->string('Status');
            $table->double('TotalTransaksi');
            $table->string('CreatedBy');
            $table->string('UpdatedBy');
            $table->integer('Posted');
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
        Schema::dropIfExists('penghapusanbarangheader');
    }
}
