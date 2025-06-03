<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agende', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->unsignedBigInteger('id_dipartimento');
            $table->foreign('id_dipartimento')->references('id_dipartimento')->on('dipartimenti')->onDelete('cascade');

            $table->unsignedBigInteger('id_prestazione');
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');

            $table->json('giorni_settimana')->comment('JSON con i giorni disponibili (es. ["lunedì", "martedì"])');
            $table->json('configurazione_orari')->nullable()->comment('Configurazione avanzata degli orari');
            $table->integer('max_appuntamenti')->default(1); // <--- AGGIUNGI QUESTA RIGA

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agende');
    }
};
