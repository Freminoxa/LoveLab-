<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('date');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('poster')->nullable();
            $table->string('till_number')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->boolean('payment_confirmed')->default(false);
            $table->enum('status', ['draft', 'published', 'completed', 'cancelled'])
                  ->default('draft');
            $table->timestamps();
            
            // NO foreign key here!
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};