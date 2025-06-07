<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestazioniTable extends Migration
{
    public function up()
    {
        Schema::create('prestazioni', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_prestazione');
            $table->string('nome', 100);
            $table->string('descrizione', 255)->nullable();
            $table->unsignedBigInteger('id_dipartimento');

            // Solo UNA definizione della colonna medico_id
            $table->foreignId('medico_id')->nullable()->constrained('medici')->onDelete('set null');

            // Foreign Keys
            $table->foreign('id_dipartimento')
                ->references('id_dipartimento')
                ->on('dipartimenti')
                ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('prestazioni');
    }
}
