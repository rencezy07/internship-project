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
        Schema::table('internships', function (Blueprint $table) {
            $table->string('image')->nullable()->after('requirements'); // Add image column
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