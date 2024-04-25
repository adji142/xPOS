<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KelompokRekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('KelompokRekening', function (Blueprint $table) {
            $table->id();
            $table->string('NamaKelompok')->unique();
            $table->integer('Kelompok');
            $table->integer('Posisi');
            $table->string('FooterLaporan')->nullable(); // P :Persen, N :Nominal
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
        Schema::dropIfExists('KelompokRekening');
    }
}
