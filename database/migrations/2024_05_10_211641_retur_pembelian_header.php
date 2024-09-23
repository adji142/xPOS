<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReturPembelianHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returpembelianheader', function (Blueprint $table) {
            $table->string('Periode');
            $table->string('NoTransaksi');
            $table->date('TglTransaksi');
            $table->string('NoReff');
            $table->string('KodeSupplier');
            $table->double('TotalTransaksi');
            $table->string('Status');
            $table->string('Keterangan');
            $table->integer('Posted');
            $table->string('CreatedBy');
            $table->string('UpdatedBy');
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
        Schema::dropIfExists('returpembelianheader');
    }
}
