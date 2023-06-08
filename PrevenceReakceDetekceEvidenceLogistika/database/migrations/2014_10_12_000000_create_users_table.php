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
                'password' => '',
                'role' => Role::ADMIN
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'employee',
                'email' => 'employee@domain',
                'password' => '',
                'role' => Role::EMPLOYEE
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'incomming',
                'email' => 'incomming@domain',
                'password' => '',
                'role' => Role::INCOMMING
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'outcomming',
                'email' => 'outcomming@domain',
                'password' => '',
                'role' => Role::OUTCOMMING
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'responder',
                'email' => 'responder@domain',
                'password' => '',
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
