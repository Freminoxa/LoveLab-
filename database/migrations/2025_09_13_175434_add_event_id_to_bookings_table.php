<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   // In 2025_09_13_175434_add_event_id_to_bookings_table.php
public function up(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->unsignedBigInteger('event_id')->nullable()->after('id');
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropForeign(['event_id']);
        $table->dropColumn('event_id');
    });
}
};
