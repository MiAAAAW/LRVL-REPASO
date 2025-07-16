<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id('id_calificacion');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_habitacion');
            $table->integer('puntaje')->between(1, 5);
            $table->text('comentario');
            $table->timestamp('fecha')->default(now());
            $table->timestamps();

            $table->foreign('id_estudiante')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('id_habitacion')->references('id_habitacion')->on('habitaciones')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('calificaciones');
    }
};
