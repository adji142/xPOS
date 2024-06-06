<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Printer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('printer', function (Blueprint $table) {
            $table->id();
            $table->string('NamaPrinter');
            $table->string('PrinterInterface');
            $table->string('DeviceName');
            $table->string('DeviceAddress');
            $table->string('PrinterToken');
            $table->integer('Used');
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
        Schema::dropIfExists('printer');
    }
}
