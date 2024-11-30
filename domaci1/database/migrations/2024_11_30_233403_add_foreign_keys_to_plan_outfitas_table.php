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
        // Dodavanje nove kolone `user_id` u tabelu `plan_outfitas` za povezivanje sa tabelom `users`
        Schema::table('plan_outfitas', function (Blueprint $table) {
            // 1. Dodaj novu kolonu `user_id` koja će služiti kao strani ključ.
            // Postavlja se odmah nakon primarnog ključa `id` zbog preglednosti strukture.
            $table->unsignedBigInteger('user_id')->after('id'); 

            // 2. Definiši strani ključ koji povezuje `user_id` sa `id` iz tabele `users`.
            // `onDelete('cascade')` osigurava da se plan outfita automatski obriše
            // kada se korisnik iz tabele `users` obriše.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Kreiranje pivot tabele za mnogostruku vezu između `plan_outfitas` i `odecas`.
        // Pivot tabela povezuje plan outfita sa više komada odeće.
        Schema::create('outfit_plan_clothing_item', function (Blueprint $table) {
            // 1. Dodavanje primarnog ključa za pivot tabelu.
            $table->id(); 

            // 2. Kolona `plan_outfit_id` koja se povezuje sa tabelom `plan_outfitas`.
            $table->unsignedBigInteger('plan_outfit_id'); 

            // 3. Kolona `clothing_item_id` koja se povezuje sa tabelom `odecas`.
            $table->unsignedBigInteger('clothing_item_id');

            // 4. Definiši strani ključ za `plan_outfit_id` koji referencira `id` u tabeli `plan_outfitas`.
            // Ako se plan outfita obriše, svi zapisi vezani za taj plan u pivot tabeli se takođe brišu.
            $table->foreign('plan_outfit_id')->references('id')->on('plan_outfitas')->onDelete('cascade');

            // 5. Definiši strani ključ za `clothing_item_id` koji referencira `id` u tabeli `odecas`.
            // Ako se komad odeće obriše, svi zapisi vezani za taj komad u pivot tabeli se takođe brišu.
            $table->foreign('clothing_item_id')->references('id')->on('odecas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Obrnuti proces za brisanje podataka u slučaju povlačenja migracije.

        // 1. Prvo uklanjamo pivot tabelu jer zavisi od tabela `plan_outfitas` i `odecas`.
        Schema::dropIfExists('outfit_plan_clothing_item');

        // 2. Uklanjamo kolonu `user_id` iz tabele `plan_outfitas` zajedno sa njenim stranim ključem.
        Schema::table('plan_outfitas', function (Blueprint $table) {
            // Uklanjanje stranog ključa koji povezuje `user_id` sa tabelom `users`.
            $table->dropForeign(['user_id']);
            // Uklanjanje same kolone `user_id`.
            $table->dropColumn('user_id');
        });
    }
};
