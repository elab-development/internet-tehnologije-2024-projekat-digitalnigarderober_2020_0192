<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garderobers', function (Blueprint $table) {
            $table->id();
            $table->string('naziv'); // Naziv garderobera (npr. "Zimska odeća")
            $table->text('opis')->nullable(); // Opis garderobera, opciono
            $table->unsignedBigInteger('user_id'); // Strani ključ za korisnika
            $table->timestamps(); // Kolone "created_at" i "updated_at"

            // Definisanje stranog ključa koji povezuje garderober sa korisnikom
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garderobers');
    }
};
