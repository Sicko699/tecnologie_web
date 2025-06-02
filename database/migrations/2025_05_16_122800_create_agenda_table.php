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
            $table->unsignedBigInteger('id_prestazione');
            $table->json('configurazione_orari')->comment('Struttura: {giorno_indice: [orari]} es: {"0": ["09:00-10:00", "10:00-11:00"]}');
            $table->integer('max_appuntamenti')->default(1)->comment('Numero massimo di appuntamenti per slot');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_dipartimento')
                ->references('id_dipartimento')
                ->on('dipartimenti')
                ->onDelete('cascade');

            $table->foreign('id_prestazione')
                ->references('id_prestazione')
                ->on('prestazioni')
                ->onDelete('cascade');

            // Indici per migliorare le performance
            $table->index(['id_dipartimento', 'id_prestazione'], 'idx_dipartimento_prestazione');
            $table->index('id_dipartimento', 'idx_dipartimento');
            $table->index('id_prestazione', 'idx_prestazione');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('agende');
    }
};
