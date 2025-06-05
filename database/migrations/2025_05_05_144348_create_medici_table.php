<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediciTable extends Migration
{
    public function up(): void
    {
        Schema::create('medici', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Assicura supporto per chiavi esterne
            $table->id(); // equivale a: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('nome');
            $table->string('cognome');
            $table->string('specializzazione')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medici');
    }
}
