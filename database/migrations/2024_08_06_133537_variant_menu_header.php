<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VariantMenuHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variantheader', function (Blueprint $table) {
            $table->id();
            $table->enum('OpsiPilihan',['Single','Multiple', 'Optional']);
            $table->String('NamaGrup');
            $table->String('RecordOwnerID');
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
        Schema::dropIfExists('variantheader');
    }
}
