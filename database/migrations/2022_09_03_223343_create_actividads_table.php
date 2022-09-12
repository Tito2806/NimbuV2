<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //nombre de la tabla y sus variables
        Schema::create('actividads', function (Blueprint $table) {
            $table->bigIncrements('id');//Llave primeria
            $table->string('titulo');
            $table->string('descripcion');
            $table->string('lugar');
            $table->date('fecha')->format('d/m/Y');
            $table->time('hora');
            $table->string('imagen')->nullable();
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
        Schema::dropIfExists('actividads');
    }
}
