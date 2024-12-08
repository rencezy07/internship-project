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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number'); // Add phone number
            $table->enum('gender', ['male', 'female', 'other']); // Add gender
            $table->string('university'); // Add university name
            $table->enum('college_level', ['freshman', 'sophomore', 'junior', 'senior']); // Add college level
            $table->string('profile_picture')->nullable(); // Add profile picture (store file path)
            $table->date('dob'); // Date of birth
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');

    }
};
