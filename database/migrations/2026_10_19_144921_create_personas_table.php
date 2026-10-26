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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('cuil',15)->nullable();
            $table->string('dni',15)->nullable();
            $table->string('apellido',100)->nullable();
            $table->string('nombre',100)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('edad',10)->nullable();
            $table->string('telefono',50)->nullable();
            $table->string('email',100)->nullable();
            $table->string('direccion',100)->nullable();
            $table->string('sexo',10)->nullable();
            $table->unsignedBigInteger('obra_social_id');
            $table->foreign('obra_social_id')->references('id')->on('obra_socials');
            $table->unsignedBigInteger('localidad_id');
            $table->foreign('localidad_id')->references('id')->on('regions');
            $table->unsignedBigInteger('relacion_laboral_id');
            $table->foreign('relacion_laboral_id')->references('id')->on('relacion_laborals');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
