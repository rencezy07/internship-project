<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipsTable extends Migration
{
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->string('internship_name');
            $table->string('city');
            $table->enum('status', ['full-time', 'part-time']);
            $table->decimal('salary', 10, 2);  // Ensure salary is a decimal
            $table->text('about');
            $table->text('requirements');
            $table->foreignId('company_id')  // Foreign key to company table using 'id' from company
                  ->constrained('company')  // Table name is 'company'
                  ->onDelete('cascade');  // If company is deleted, remove related internships
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('internships');
    }
}
