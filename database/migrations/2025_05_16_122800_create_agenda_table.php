<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->unsignedBigInteger('id_prestazione');
            $table->string('giorno_settimana', 20);
            $table->string('slot_orario', 20);
            $table->integer('max_appuntamenti')->default(1);
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('agenda');
    }
}
