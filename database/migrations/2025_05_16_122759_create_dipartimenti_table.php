<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDipartimentiTable extends Migration
{
    public function up()
    {
        Schema::create('dipartimenti', function (Blueprint $table) {
            $table->id('id_dipartimento');
            $table->string('nome', 100);
            $table->string('descrizione', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dipartimenti');
    }
}
