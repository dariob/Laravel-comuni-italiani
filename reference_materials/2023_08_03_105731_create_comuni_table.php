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
        if(Schema::hasTable('comuni')) {
            echo 'Table comuni already exists, skipping...';
            return;
        }
        
        Schema::create('comuni', function (Blueprint $table) {
            $table->id();
            $table->string('nome_comune');
            $table->string('codice_catastale');
            $table->unsignedBigInteger('provincia_id')->unsigned();
            $table->foreign('provincia_id')->references('id')->on('province');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // Schema::dropIfExists('comuni');
    }
};
