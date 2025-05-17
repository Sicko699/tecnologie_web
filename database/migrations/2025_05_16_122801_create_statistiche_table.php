<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticheTable extends Migration
{
    public function up()
    {
        Schema::create('statistiche', function (Blueprint $table) {
            $table->id('id_statistica');
            $table->string('id_amministratore', 16);
            $table->unsignedBigInteger('id_prestazione');
            $table->date('data_inizio');
            $table->date('data_fine')->nullable();
            $table->string('tipo', 50);
            $table->string('risultato', 255)->nullable();
            $table->foreign('id_amministratore')->references('codice_fiscale')->on('amministratori')->onDelete('cascade');
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('statistiche');
    }
}
