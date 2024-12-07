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
            // Modify columns to be non-nullable
            $table->string('duration')->nullable(false)->change();
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
            $table->text('benefits')->nullable(false)->change();
            $table->date('application_deadline')->nullable(false)->change();
            $table->string('tags')->nullable(false)->change();
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
