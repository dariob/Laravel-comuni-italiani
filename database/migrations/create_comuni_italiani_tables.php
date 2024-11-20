<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('regioni', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codice_istat', 2)->unique();
            $table->timestamps();
        });

        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codice_istat', 3)->unique();
            $table->string('sigla', 2)->unique();
            $table->foreignId('regione_id')->constrained('regioni')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('comuni', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codice_istat', 6)->unique();
            $table->string('codice_catastale', 4)->unique();
            $table->foreignId('provincia_id')->constrained('province')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comuni');
        Schema::dropIfExists('province');
        Schema::dropIfExists('regioni');
    }
};
