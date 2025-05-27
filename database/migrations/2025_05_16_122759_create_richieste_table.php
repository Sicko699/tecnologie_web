<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRichiesteTable extends Migration
{
    public function up()
    {
        Schema::create('richieste', function (Blueprint $table) {
            $table->id('id_richiesta');
            $table->string('id_utente', 16)->nullable(); // permetti NULL
            $table->unsignedBigInteger('id_prestazione')->nullable();
            $table->date('data_richiesta');
            $table->string('giorno_escluso', 100)->nullable();
            $table->string('stato', 30)->default('in attesa');
            $table->foreign('id_utente')->references('codice_fiscale')->on('users')->onDelete('cascade');
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('richieste');
    }
}
