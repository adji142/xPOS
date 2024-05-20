<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Supplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Supplier', function (Blueprint $table) {
            $table->string('KodeSupplier')->unique();
            $table->string('NamaSupplier');
            $table->string('ProvID')->nullable();
            $table->string('KotaID')->nullable();
            $table->string('KelID')->nullable();
            $table->string('KecID')->nullable();
            $table->string('Email')->nullable();
            $table->string('NoTlp1');
            $table->string('NoTlp2')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('Keterangan')->nullable();
            $table->integer('Status')->default(1);
            $table->string('NPWP')->nullable();
            $table->integer('Bank')->nullable();
            $table->integer('NoRekening')->nullable();
            $table->integer('PemilikRekening')->nullable();
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
        Schema::dropIfExists('Supplier');
    }
}
