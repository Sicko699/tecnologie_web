<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    public function up()
    {
        Schema::create('agende', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->unsignedBigInteger('id_dipartimento'); // Consigliato se la usi
            $table->unsignedBigInteger('id_prestazione');
            $table->integer('giorno_settimana'); // Preferibile numerico: 0=Lunedì, ... 5=Sabato
            $table->json('orari'); // Un array di slot ["09:00-10:00","10:00-11:00",...]
            $table->integer('max_appuntamenti')->default(1);

            $table->foreign('id_dipartimento')->references('id_dipartimento')->on('dipartimenti')->onDelete('cascade');
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agende');
    }
}
