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
        Schema::create('odecas', function (Blueprint $table) {
            $table->id(); // Primarni ključ
            $table->string('naziv'); // Naziv odeće
            $table->string('tip'); // Tip odeće (npr. jakna, pantalone)
            $table->string('boja'); // Boja odeće
            $table->string('sezona'); // Sezona za koju je odeća (npr. leto, zima)
            $table->string('materijal')->nullable(); // Materijal (npr. pamuk, vuna), opciono
            $table->string('slika')->nullable(); // Putanja do slike odeće, opciono
            $table->unsignedBigInteger('garderober_id'); // Strani ključ prema garderoberu
            $table->timestamps(); // Kolone za vremenske oznake (created_at i updated_at)

            // Definisanje stranog ključa za povezivanje sa tabelom `garderobers`
            $table->foreign('garderober_id')->references('id')->on('garderobers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('odecas'); // Brisanje tabele ako se migracija povuče
    }
};
