<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClosingPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postingperiod', function (Blueprint $table) {
            $table->id();
            $table->string('Periode');
            $table->date('TanggalProses');
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
        Schema::dropIfExists('postingperiod');
    }
}
