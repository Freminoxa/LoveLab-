<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, we need to ensure the events table exists
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                if (!Schema::hasColumn('events', 'status')) {
                    $table->enum('status', ['active', 'completed', 'cancelled'])->default('active')->after('payment_confirmed');
                }
                if (!Schema::hasColumn('events', 'description')) {
                    $table->text('description')->nullable()->after('location');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                if (Schema::hasColumn('events', 'status')) {
                    $table->dropColumn('status');
                }
                if (Schema::hasColumn('events', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }
    }
};