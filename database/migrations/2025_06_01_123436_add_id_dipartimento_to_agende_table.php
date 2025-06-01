<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdDipartimentoToAgendeTable extends Migration
{
    public function up()
    {
        Schema::table('agende', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dipartimento')->after('id_agenda');
            $table->foreign('id_dipartimento')->references('id_dipartimento')->on('dipartimenti')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('agende', function (Blueprint $table) {
            $table->dropForeign(['id_dipartimento']);
            $table->dropColumn('id_dipartimento');
        });
    }
}
