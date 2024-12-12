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
        Schema::table('company', function (Blueprint $table) {
            // Adding the new columns, ensuring they are not nullable and are required
            $table->string('location')->after('is_verified'); // Add location column (required)
            $table->string('company_logo')->after('location'); // Add company_logo column (required)
            $table->string('business_permit')->after('company_logo'); // Add business_permit column (required)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
