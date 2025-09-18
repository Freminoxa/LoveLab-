<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'event_id')) {
                $table->foreignId('event_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('bookings', 'package_id')) {
                $table->foreignId('package_id')->nullable()->after('event_id')->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('bookings', 'confirmed_by_manager')) {
                $table->boolean('confirmed_by_manager')->default(false)->after('mpesa_code');
            }
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'event_id')) {
                $table->dropForeign(['event_id']);
                $table->dropColumn('event_id');
            }
            if (Schema::hasColumn('bookings', 'package_id')) {
                $table->dropForeign(['package_id']);
                $table->dropColumn('package_id');
            }
            if (Schema::hasColumn('bookings', 'confirmed_by_manager')) {
                $table->dropColumn('confirmed_by_manager');
            }
        });
    }
};