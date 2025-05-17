<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestazioniTable extends Migration
{
    public function up()
    {
        Schema::create('prestazioni', function (Blueprint $table) {
            $table->id('id_prestazione');
            $table->string('nome', 100);
            $table->string('descrizione', 255)->nullable();
            $table->unsignedBigInteger('id_dipartimento');
            $table->string('id_membro', 16);
            $table->foreign('id_dipartimento')->references('id_dipartimento')->on('dipartimenti')->onDelete('cascade');
            $table->foreign('id_membro')->references('codice_fiscale')->on('membro_staff')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestazioni');
    }
}
