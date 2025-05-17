<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePazientiTable extends Migration
{
    public function up()
    {
        Schema::create('pazienti', function (Blueprint $table) {
            $table->string('codice_fiscale', 16)->primary();
            $table->foreign('codice_fiscale')->references('codice_fiscale')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pazienti');
    }
}
