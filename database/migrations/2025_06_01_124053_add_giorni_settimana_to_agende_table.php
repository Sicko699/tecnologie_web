<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGiorniSettimanaToAgendeTable extends Migration
{
    public function up()
    {
        Schema::table('agende', function (Blueprint $table) {
            $table->json('giorni_settimana')->after('id_prestazione');
            // Se vuoi, puoi rimuovere il vecchio campo giorno_settimana (string/int):
            // $table->dropColumn('giorno_settimana');
        });
    }

    public function down()
    {
        Schema::table('agende', function (Blueprint $table) {
            $table->dropColumn('giorni_settimana');
            // $table->integer('giorno_settimana')->after('id_prestazione'); // O come era prima
        });
    }
}
