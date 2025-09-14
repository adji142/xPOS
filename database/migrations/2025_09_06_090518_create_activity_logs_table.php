<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('table', 128)->index();
            $table->string('model')->index();        // FQCN model
            $table->string('model_id')->index();     // string agar aman utk UUID
            $table->string('action', 32)->index();   // created, updated, deleted, restored, force_deleted

            $table->unsignedBigInteger('user_id')->nullable()->index();

            $table->json('changes')->nullable();     // { field: {from:..., to:...}, ... }
            $table->json('before')->nullable();      // snapshot sebelum (hapus)
            $table->json('after')->nullable();       // snapshot sesudah (create/restore)

            $table->ipAddress('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url', 2048)->nullable();
            $table->string('method', 16)->nullable();

            $table->uuid('batch_id')->nullable()->index(); // grup per-request/job

            $table->timestamps();

            // Optional FK:
            // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
