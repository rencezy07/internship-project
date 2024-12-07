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
            $table->string('company')->nullable(); // Company Name
            $table->string('duration')->nullable(); // Duration (e.g., '3 months', '6 months')
            $table->date('start_date')->nullable(); // Start Date
            $table->date('end_date')->nullable();   // End Date
            $table->text('benefits')->nullable();   // Benefits
            $table->date('application_deadline')->nullable(); // Application Deadline
            $table->string('tags')->nullable();     // Tags (comma-separated string)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            //
        });
    }
};
