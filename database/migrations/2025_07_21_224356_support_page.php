<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SupportPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informasi_pages', function (Blueprint $table) {
            $table->id();
            $table->string('KodeInformasi')->unique();
            $table->string('Judul');
            $table->enum('Kategori', ['faq', 'tutorial']);
            $table->text('Konten');
            $table->longText('ThumbnailBase64')->nullable();
            $table->boolean('IsPublished')->default(false);
            $table->string('RecordOwnerID')->nullable();
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
        Schema::dropIfExists('informasi_pages');
    }
}
