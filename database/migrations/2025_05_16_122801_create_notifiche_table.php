<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificheTable extends Migration
{
    public function up()
    {
        Schema::create('notifiche', function (Blueprint $table) {
            $table->id('id_notifica');
            $table->string('id_utente', 16);
            $table->string('messaggio', 255);
            $table->timestamp('data_creazione')->useCurrent();
            $table->boolean('conferma_lettura')->default(false);
            $table->foreign('id_utente')->references('codice_fiscale')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifiche');
    }
}
