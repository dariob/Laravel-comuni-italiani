<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if(Schema::hasTable('regioni')) {
            echo 'Table regioni already exists, skipping...';
            return;
        }

        Schema::create('regioni', function (Blueprint $table) {
            $table->id();
            $table->string('nome_regione');
            $table->string('ripartizione_geografica');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('regioni');
    }
};
