<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id('id_habitacion');
            $table->unsignedBigInteger('id_propietario');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('ubicacion');
            $table->decimal('precio', 10, 2);
            $table->enum('tipo_contrato', ['mensual', 'semestral']);
            $table->enum('estado', ['disponible', 'reservada', 'no_disponible'])->default('disponible');
            $table->timestamp('fecha_publicacion')->default(now());
            $table->timestamps();

            $table->foreign('id_propietario')->references('id_usuario')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('habitaciones');
    }
};
