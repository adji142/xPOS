<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('discountvoucher', function (Blueprint $table) {
            $table->id();
            $table->string('VoucherCode', 15)->unique();
            $table->double('DiscountPercent', 16, 2);
            $table->double('MaximalDiscount', 16, 2);
            $table->date('StartDate');
            $table->date('EndDate');
            $table->double('DiscountQuota', 16, 2);
            $table->text('DiscountDescription')->nullable();
            $table->string('RecordOwnerID');
            $table->string('CreatedBy')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('UpdatedBy')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discountvoucher');
    }
};
