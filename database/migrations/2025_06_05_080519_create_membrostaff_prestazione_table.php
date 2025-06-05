<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembrostaffPrestazioneTable extends Migration
{
    public function up()
    {
        Schema::create('membrostaff_prestazione', function (Blueprint $table) {
            $table->string('codice_fiscale'); // Chiave membro staff
            $table->unsignedBigInteger('id_prestazione'); // Chiave prestazione

            $table->foreign('codice_fiscale')->references('codice_fiscale')->on('membro_staff')->onDelete('cascade');
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');

            $table->primary(['codice_fiscale', 'id_prestazione']); // chiave composta
        });
    }

    public function down()
    {
        Schema::dropIfExists('membrostaff_prestazione');
    }
}
