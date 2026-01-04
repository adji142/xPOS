<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBiayaLayananToFakturAndPembayaranHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fakturpenjualanheader', function (Blueprint $table) {
            $table->decimal('BiayaLayanan', 18, 2)->default(0)->after('PajakHiburan');
        });

        Schema::table('pembayaranpenjualanheader', function (Blueprint $table) {
             $table->decimal('BiayaLayanan', 18, 2)->default(0)->after('TotalPembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fakturpenjualanheader', function (Blueprint $table) {
             $table->dropColumn('BiayaLayanan');
        });

        Schema::table('pembayaranpenjualanheader', function (Blueprint $table) {
             $table->dropColumn('BiayaLayanan');
        });
    }
}
