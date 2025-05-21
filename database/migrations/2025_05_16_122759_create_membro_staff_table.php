<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembroStaffTable extends Migration
{
    public function up()
    {
        Schema::create('membro_staff', function (Blueprint $table) {
            $table->string('codice_fiscale', 16)->primary();
            $table->unsignedBigInteger('id_dipartimento');
            $table->string('descrizione', 255)->nullable();
            $table->foreign('codice_fiscale')->references('codice_fiscale')->on('users')->onDelete('cascade');
            $table->foreign('id_dipartimento')->references('id_dipartimento')->on('dipartimenti')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('membro_staff');
    }
}
