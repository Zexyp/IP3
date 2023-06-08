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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date')->default(today());;
            $table->float('mass');
            $table->float('worth');
            $table->timestamps();
        });

        DB::table('sales')->insert(
            array(
                'mass' => 123,
                'worth' => 123.45,
            )
        );
        DB::table('sales')->insert(
            array(
                'mass' => 123,
                'worth' => 123.45,
            )
        );
        DB::table('sales')->insert(
            array(
                'mass' => 123,
                'worth' => 123.45,
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
