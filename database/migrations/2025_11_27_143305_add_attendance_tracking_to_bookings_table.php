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
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('has_attended')->default(false);
            $table->timestamp('attended_at')->nullable();
            $table->unsignedBigInteger('attended_by')->nullable(); // Manager ID who confirmed attendance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['has_attended', 'attended_at', 'attended_by']);
        });
    }
};
