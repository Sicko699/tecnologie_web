<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('codice_fiscale', 16)->primary();
            $table->string('nome', 100);
            $table->string('cognome', 100);
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('telefono', 50)->nullable();
            $table->date('data_nascita')->nullable();
            $table->string('foto')->nullable();
            $table->enum('ruolo', ['paziente', 'staff', 'admin']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
