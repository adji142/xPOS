<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptionheader', function (Blueprint $table) {
            $table->string('NoTransaksi');
            $table->string('Tanggal');
            $table->text('NamaSubscription');
            $table->text('DeskripsiSubscription');
            $table->double('Harga');
            $table->integer('LamaSubsription');
            $table->integer('AllowAccounting');
            $table->integer('AllowPesananMeja');
            $table->integer('AllowPaymentGateway');
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
        Schema::dropIfExists('subscriptionheader');
    }
}
