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
        if(Schema::hasTable('province')) {
            echo 'Table province already exists, skipping...';
            return;
        }
        Schema::create('province', function (Blueprint $table) {
            $table->id();
            $table->string('nome_provincia');
            $table->string('sigla');
            $table->unsignedBigInteger('regione_id')->unsigned();
            $table->foreign('regione_id')->references('id')->on('regioni');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('province');
    }
};
