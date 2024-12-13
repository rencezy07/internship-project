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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
        $table->morphs('user'); // Creates user_id and user_type columns for polymorphic relation
        $table->string('type'); // Type of notification (e.g., 'application_status', 'new_message')
        $table->text('message'); // The content of the notification
        $table->boolean('read')->default(false); // Whether the notification has been read
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
