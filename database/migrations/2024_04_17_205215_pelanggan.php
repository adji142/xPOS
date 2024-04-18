<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->string('KodePelanggan')->unique();
            $table->string('NamaPelanggan');
            $table->string('KodeGrupPelanggan');
            $table->double('LimitPiutang')->nullable();
            $table->string('ProvID')->nullable();
            $table->string('KotaID')->nullable();
            $table->string('KelID')->nullable();
            $table->string('KecID')->nullable();
            $table->string('Email')->nullable();
            $table->string('NoTlp1')->nullable();
            $table->string('NoTlp2')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('Keterangan')->nullable();
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
        Schema::dropIfExists('pelanggan');
    }
}
