<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMedicoIdToPrestazioniTable extends Migration
{
    public function up()
    {
        Schema::table('prestazioni', function (Blueprint $table) {
            $table->foreignId('medico_id')->nullable()->constrained('medici')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('prestazioni', function (Blueprint $table) {
            $table->dropForeign(['medico_id']);
            $table->dropColumn('medico_id');
        });
    }
}
