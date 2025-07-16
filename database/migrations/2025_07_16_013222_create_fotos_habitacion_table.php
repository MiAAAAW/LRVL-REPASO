<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fotos_habitacion', function (Blueprint $table) {
            $table->id('id_foto');
            $table->unsignedBigInteger('id_habitacion');
            $table->string('url_foto');
            $table->string('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('id_habitacion')->references('id_habitacion')->on('habitaciones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fotos_habitacion');
    }
};
