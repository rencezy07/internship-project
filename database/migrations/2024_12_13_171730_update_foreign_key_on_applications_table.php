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
       // Modify the foreign key to cascade delete
       Schema::table('applications', function (Blueprint $table) {
        // Drop the existing foreign key constraint
        $table->dropForeign('applications_internship_id_foreign');

        // Add the new foreign key constraint with cascade delete
        $table->foreign('internship_id')
            ->references('internship_id')
            ->on('internships')
            ->onDelete('cascade');  // Automatically delete applications when internship is deleted
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
