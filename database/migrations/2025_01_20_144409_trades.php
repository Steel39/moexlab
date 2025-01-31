<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades',
            function ($table) {
                $table->increments('id');
                $table->string('uid');
                $table->integer('direction');
                $table->float('price');
                $table->integer('quantity');
                $table->datetime('time');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('trades');
    }
};
