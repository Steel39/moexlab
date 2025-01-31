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
        Schema::create('shares', function ($table) {
            $table->increments('id');
            $table->string('uid');
            $table->string('company_name');
            $table->string('ticker');
            $table->integer('lot');
            $table->boolean('short_enabled_flag');
            $table->unsignedBigInteger('issue_size');
            $table->string('sector');
            $table->boolean('div_yield_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('shares');
    }
};
