<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppuntamentiTable extends Migration
{
    public function up()
    {
        Schema::create('appuntamenti', function (Blueprint $table) {
            $table->id('id_appuntamento');
            $table->unsignedBigInteger('id_richiesta');
            $table->date('data');
            $table->string('ora', 10);
            $table->string('stato', 30)->default('prenotato');
            $table->foreign('id_richiesta')->references('id_richiesta')->on('richieste')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appuntamenti');
    }
}
