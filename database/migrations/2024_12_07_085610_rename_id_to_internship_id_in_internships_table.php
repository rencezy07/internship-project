<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Start a transaction to ensure atomicity
        DB::beginTransaction();
    
        try {
            // Step 1: Drop the foreign key constraint in 'applications'
            Schema::table('applications', function (Blueprint $table) {
                $table->dropForeign(['internship_id']);  // Drop the foreign key constraint
            });
    
            // Step 2: Modify the 'internships' table
            Schema::table('internships', function (Blueprint $table) {
                // Drop the current primary key
                $table->dropPrimary();
    
                // Rename the 'id' column to 'internship_id'
                $table->renameColumn('id', 'internship_id');
    
                // Set the new 'internship_id' column as the primary key
                $table->primary('internship_id');
            });
    
            // Step 3: Recreate the foreign key constraint on the 'applications' table
            Schema::table('applications', function (Blueprint $table) {
                $table->foreign('internship_id')->references('internship_id')->on('internships');
            });
    
            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If any error occurs, roll back the transaction
            DB::rollBack();
            throw $e;
        }
    }
    
    public function down()
    {
        DB::beginTransaction();
    
        try {
            // Reverse the process if rolling back
            Schema::table('applications', function (Blueprint $table) {
                $table->dropForeign(['internship_id']);
            });
    
            Schema::table('internships', function (Blueprint $table) {
                $table->dropPrimary();
                $table->renameColumn('internship_id', 'id');
                $table->primary('id');
            });
    
            Schema::table('applications', function (Blueprint $table) {
                $table->foreign('internship_id')->references('id')->on('internships');
            });
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
};
