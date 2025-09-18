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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('date');
            $table->string('location');
            $table->string('poster')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->boolean('payment_confirmed')->default(false);
            $table->timestamps();
        });
        // Add foreign key constraint after managers table exists
        Schema::table('events', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('managers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    // Drop dependent tables first to avoid foreign key constraint errors
    Schema::dropIfExists('packages');
    Schema::dropIfExists('bookings');
    Schema::dropIfExists('events');
    }
};
