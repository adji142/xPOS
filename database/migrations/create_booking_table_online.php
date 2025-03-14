<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bookingtableonline', function (Blueprint $table) {
            $table->id();
            $table->string('NoTransaksi', 55)->unique();
            $table->dateTime('TglBooking');
            $table->time('JamMulai');
            $table->Time('JamSelesai');
            $table->unsignedBigInteger('mejaID');
            $table->unsignedBigInteger('paketid');
            $table->string('KodeSales', 55);
            $table->string('KodePelanggan', 55);
            $table->tinyInteger('StatusTransaksi')->default(0);
            $table->string('Keterangan', 254)->nullable();
            $table->string('ExtraRequest', 254)->nullable();
            $table->double('TotalTransaksi', 16, 2);
            $table->double('TotalTax', 16, 2)->default(0);
            $table->double('TotalDiskon', 16, 2)->default(0);
            $table->double('TotalLainLain', 16, 2)->default(0);
            $table->double('NetTotal', 16, 2);
            $table->string('RecordOwnerID',254)->nullable();;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookingtableonline');
    }
};
