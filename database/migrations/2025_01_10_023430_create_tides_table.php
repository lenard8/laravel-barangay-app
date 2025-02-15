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
        Schema::create('tides', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('month');
            $table->integer('day');
            $table->integer('time');
            $table->integer('meter');
            $table->integer('feet');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tides');
    }
};
