<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //redosled kolona u users tabeli je bio los, pa smo napravili migraciju koja samo preuredjuje redosled kolona da bude smisleniji

        // 1. Kreiraj privremenu tabelu sa željenim redosledom kolona
        // Ova tabela će imati iste kolone kao originalna tabela "users",
        // ali u redosledu koji želimo. Laravel ne podržava direktnu promenu
        // redosleda kolona, pa ovo radimo kao rešenje.
        Schema::create('users_temp', function (Blueprint $table) {
            $table->id(); // Primarni ključ
            $table->string('ime')->nullable(); // Ime korisnika
            $table->string('prezime')->nullable(); // Prezime korisnika
            $table->string('email')->unique(); // Email (mora biti jedinstven)
            $table->timestamp('email_verified_at')->nullable(); // Datum verifikacije email-a
            $table->string('password'); // Lozinka korisnika
            $table->string('avatar')->nullable(); // Putanja do slike avatara
            $table->date('datum_rodjenja')->nullable(); // Datum rođenja korisnika
            $table->string('telefon')->nullable(); // Broj telefona korisnika
            $table->string('adresa')->nullable(); // Fizička adresa korisnika
            $table->text('biografija')->nullable(); // Kratka biografija korisnika
            $table->rememberToken(); // Token za "zapamti me" opciju prilikom logovanja
            $table->timestamps(); // Kolone "created_at" i "updated_at"
        });

        // 2. Prebaci podatke iz originalne tabele "users" u novu privremenu tabelu "users_temp"
        // Ova naredba koristi SQL upit da kopira sve postojeće podatke u novu tabelu,
        // vodeći računa da kolone odgovaraju tačno po redosledu i imenima.
        DB::statement('INSERT INTO users_temp (id, ime, prezime, email, email_verified_at, password, avatar, datum_rodjenja, telefon, adresa, biografija, remember_token, created_at, updated_at)
                       SELECT id, ime, prezime, email, email_verified_at, password, avatar, datum_rodjenja, telefon, adresa, biografija, remember_token, created_at, updated_at
                       FROM users');

        // 3. Obriši originalnu tabelu "users"
        // Nakon što su svi podaci prebačeni u privremenu tabelu, brišemo originalnu
        // kako bismo oslobodili ime za novu tabelu.
        Schema::dropIfExists('users');

        // 4. Preimenuj privremenu tabelu "users_temp" u "users"
        // Sada kada je originalna tabela obrisana, privremenu tabelu preimenujemo
        // nazad u "users" kako bi aplikacija nastavila da radi sa njom.
        Schema::rename('users_temp', 'users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1. Kreiraj originalnu tabelu "users_original" nazad sa starim redosledom kolona
        Schema::create('users_original', function (Blueprint $table) {
            $table->id(); // Primarni ključ
            $table->string('email')->unique(); // Email (mora biti jedinstven)
            $table->timestamp('email_verified_at')->nullable(); // Datum verifikacije email-a
            $table->string('password'); // Lozinka korisnika
            $table->rememberToken(); // Token za "zapamti me" opciju prilikom logovanja
            $table->timestamps(); // Kolone "created_at" i "updated_at"
            $table->string('ime')->nullable(); // Ime korisnika
            $table->string('prezime')->nullable(); // Prezime korisnika
            $table->string('avatar')->nullable(); // Putanja do slike avatara
            $table->date('datum_rodjenja')->nullable(); // Datum rođenja korisnika
            $table->string('telefon')->nullable(); // Broj telefona korisnika
            $table->string('adresa')->nullable(); // Fizička adresa korisnika
            $table->text('biografija')->nullable(); // Kratka biografija korisnika
        });

        // 2. Prebaci podatke nazad iz nove tabele "users" u originalnu tabelu "users_original"
        // Ovo osigurava da se podaci sačuvaju prilikom vraćanja migracije.
        DB::statement('INSERT INTO users_original (id, email, email_verified_at, password, remember_token, created_at, updated_at, ime, prezime, avatar, datum_rodjenja, telefon, adresa, biografija)
                       SELECT id, email, email_verified_at, password, remember_token, created_at, updated_at, ime, prezime, avatar, datum_rodjenja, telefon, adresa, biografija
                       FROM users');

        // 3. Obriši novu tabelu "users"
        Schema::dropIfExists('users');

        // 4. Preimenuj originalnu tabelu "users_original" nazad u "users"
        Schema::rename('users_original', 'users');
    }
};
