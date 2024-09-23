<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BiayaHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biayaheader', function (Blueprint $table) {
            $table->string('NoTransaksi')->unique();
            $table->string('Periode');
            $table->date('TglTransaksi');
            $table->string('NoReff')->nullable();
            $table->string('Keterangan')->nullable();
            $table->double('TotalTransaksi');
            $table->string('KodeRekening');
            $table->string('Status');
            $table->integer('Posted');
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
        Schema::dropIfExists('biayaheader');
    }
}
