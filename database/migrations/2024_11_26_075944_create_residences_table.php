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
        Schema::create('residences', function (Blueprint $table) {
        $table->id(); 
        $table->string('firstname');
        $table->string('lastname');
        $table->string('middlename')->nullable();
        $table->text('gender')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('civil_status')->nullable();
        $table->string('occupation')->nullable();
        $table->text('home_address')->nullable();
        $table->string('email_address')->nullable();
        $table->string('mobile_number')->nullable();
        $table->boolean('is_senior_citizen_or_pwd')->default(false);
        $table->string('relationship_to_head_of_household')->nullable();
        $table->integer('number_of_household_members')->default(1);
        $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residences');
    }
};
