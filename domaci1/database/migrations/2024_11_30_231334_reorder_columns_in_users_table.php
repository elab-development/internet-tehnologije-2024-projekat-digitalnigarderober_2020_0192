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
        // Kreiraj privremenu tabelu sa željenim redosledom
        Schema::create('users_temp', function (Blueprint $table) {
            $table->id();
            $table->string('ime')->nullable();
            $table->string('prezime')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->date('datum_rodjenja')->nullable();
            $table->string('telefon')->nullable();
            $table->string('adresa')->nullable();
            $table->text('biografija')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // Prebaci podatke iz originalne tabele u privremenu
        DB::statement('INSERT INTO users_temp (id, ime, prezime, email, email_verified_at, password, avatar, datum_rodjenja, telefon, adresa, biografija, remember_token, created_at, updated_at)
                       SELECT id, ime, prezime, email, email_verified_at, password, avatar, datum_rodjenja, telefon, adresa, biografija, remember_token, created_at, updated_at
                       FROM users');

        // Obriši originalnu tabelu
        Schema::dropIfExists('users');

        // Preimenuj privremenu tabelu u originalno ime
        Schema::rename('users_temp', 'users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kreiraj originalnu tabelu nazad
        Schema::create('users_original', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('ime')->nullable();
            $table->string('prezime')->nullable();
            $table->string('avatar')->nullable();
            $table->date('datum_rodjenja')->nullable();
            $table->string('telefon')->nullable();
            $table->string('adresa')->nullable();
            $table->text('biografija')->nullable();
        });

        // Prebaci podatke nazad u originalnu tabelu
        DB::statement('INSERT INTO users_original (id, email, email_verified_at, password, remember_token, created_at, updated_at, ime, prezime, avatar, datum_rodjenja, telefon, adresa, biografija)
                       SELECT id, email, email_verified_at, password, remember_token, created_at, updated_at, ime, prezime, avatar, datum_rodjenja, telefon, adresa, biografija
                       FROM users');

        // Obriši novu tabelu
        Schema::dropIfExists('users');

        // Preimenuj originalnu tabelu nazad
        Schema::rename('users_original', 'users');
    }
};
