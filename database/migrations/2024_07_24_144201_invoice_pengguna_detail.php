<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InvoicePenggunaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihanpenggunadetail', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->integer('NoUrut');
            $table->double('Harga');
            $table->text('Catatan');
            $table->string('KodePelanggan');
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
        Schema::dropIfExists('tagihanpenggunadetail');
    }
}
