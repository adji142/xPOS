<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $blueprint) {
            $blueprint->smallInteger('isPaidMembership')->default(0)->after('Status');
            $blueprint->integer('MaxPlay')->default(0)->after('isPaidMembership');
            $blueprint->double('MemberPrice')->default(0)->after('MaxPlay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['isPaidMembership', 'MaxPlay', 'MemberPrice']);
        });
    }
};
