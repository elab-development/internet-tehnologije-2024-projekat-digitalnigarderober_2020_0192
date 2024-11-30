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
        Schema::create('plan_outfitas', function (Blueprint $table) {
            $table->id(); // Primarni ključ
            $table->string('naziv'); // Naziv plana outfita
            $table->date('datum'); // Datum za koji je planiran outfit
            $table->string('lokacija')->nullable(); // Lokacija događaja
            $table->string('vremenska_prognoza')->nullable(); // Vremenska prognoza za taj dan
            $table->string('dogadjaj')->nullable(); // Tip događaja (npr. venčanje, posao)
            $table->timestamps(); // Kolone "created_at" i "updated_at"
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_outfitas');
    }
};
