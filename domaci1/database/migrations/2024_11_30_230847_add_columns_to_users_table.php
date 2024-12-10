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
        Schema::table('users', function (Blueprint $table) {
            $table->string('ime')->nullable();
            $table->string('prezime')->nullable();
            $table->string('avatar')->nullable();
            $table->date('datum_rodjenja')->nullable();
            $table->string('telefon')->nullable();
            $table->string('adresa')->nullable();
            $table->text('biografija')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
