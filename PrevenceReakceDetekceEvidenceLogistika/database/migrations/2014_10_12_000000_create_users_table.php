<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role');
            $table->rememberToken();
            $table->timestamps();
        });

        // Insert some stuff
        DB::table('users')->insert(
            array(
                'name' => 'admin',
                'email' => 'admin@domain',
                'password' => '$2y$10$gzAgPsHnC80nO5.rU6vi0uj3d36C7ZPDOB/isqAB2xjraAGmDOcFS',
                'role' => Role::ADMIN
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'employee',
                'email' => 'employee@domain',
                'password' => '$2y$10$Qm/kGf6mG5ox9V.IZMZrR.BAvi366JVeR6stb.JDelrVSbeuTM.TG',
                'role' => Role::EMPLOYEE
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'incoming',
                'email' => 'incoming@domain',
                'password' => '$2y$10$Yc5GX6GYCtwWyEZcDei8E.QrDX7dcYcgSQCxpxWPMUnvr3OonNat2',
                'role' => Role::INCOMING
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'outcoming',
                'email' => 'outcoming@domain',
                'password' => '$2y$10$CyOkvORhmqnLV8syowsfYe57bdM2wFI1VUbVAN8K.bw2uPDd2pBcC',
                'role' => Role::OUTCOMING
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'responder',
                'email' => 'responder@domain',
                'password' => '$2y$10$cFnvjjP4JRUrCx1iiWUwKe1HvvOLYY8YgW5tj8SI5ujUuvAByPJs2',
                'role' => ROLE::RESPONDER
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
