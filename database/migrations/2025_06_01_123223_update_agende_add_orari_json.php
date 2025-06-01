<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAgendeAddOrariJson extends Migration
{
    public function up()
    {
        Schema::table('agende', function (Blueprint $table) {
            // Rimuove il vecchio campo slot_orario
            $table->dropColumn('slot_orario');
            // Aggiunge il nuovo campo orari di tipo JSON dopo giorno_settimana
            $table->json('orari')->after('giorno_settimana');
        });
    }

    public function down()
    {
        Schema::table('agende', function (Blueprint $table) {
            // Permette di annullare la migration (rollback)
            $table->dropColumn('orari');
            $table->string('slot_orario', 20)->after('giorno_settimana');
        });
    }
}

