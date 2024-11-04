<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KasKeluarHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaskeluarheader', function (Blueprint $table) {
            $table->String('NoTransaksi')->primary();
            $table->date('TglTransaksi');
            $table->datetime('TglPencatatan');
            $table->String('StatusDocument');
            $table->String('KodeAkun');
            $table->String('Keterangan');
            $table->double('TotalTransaksi');
            $table->String('RecordOwnerID')->unique();
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
        Schema::dropIfExists('kaskeluarheader');
    }
}
