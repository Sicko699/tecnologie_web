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

            // Aggiungi collegamento al dipartimento
            $table->unsignedBigInteger('id_dipartimento');
            $table->foreign('id_dipartimento')->references('id_dipartimento')->on('dipartimenti')->onDelete('cascade');

            $table->unsignedBigInteger('id_prestazione');
            $table->foreign('id_prestazione')->references('id_prestazione')->on('prestazioni')->onDelete('cascade');

            // Sostituisce il vecchio campo giorno_settimana
            $table->json('giorni_settimana')->comment('JSON con i giorni disponibili (es. ["lunedì", "martedì"])');

            // Sostituisce il vecchio campo slot_orario
            $table->json('orari')->comment('Struttura JSON con gli orari disponibili per ogni giorno della settimana');

            // Puoi mantenere altri campi già esistenti, es:
            $table->json('configurazione_orari')->nullable()->comment('Configurazione avanzata degli orari');

            // Altri eventuali campi...
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agende');
    }
};
