<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DiskonPeriodik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diskonperiodik', function (Blueprint $table) {
            $table->id();
            $table->date('TanggalMulai');
            $table->date('TanggalSelesai');
            $table->string('Deskripsi');
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
        Schema::dropIfExists('diskonperiodik');
    }
}
