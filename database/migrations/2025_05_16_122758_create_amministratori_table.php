<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmministratoriTable extends Migration
{
    public function up()
    {
        Schema::create('amministratori', function (Blueprint $table) {
            $table->string('codice_fiscale', 16)->primary();
            $table->foreign('codice_fiscale')->references('codice_fiscale')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('amministratori');
    }
}
