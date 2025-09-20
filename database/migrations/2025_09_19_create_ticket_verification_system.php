<?php
// database/migrations/2025_09_19_create_ticket_verification_system.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('ticket_number')->unique()->nullable()->after('id');
            $table->text('qr_code')->nullable()->after('mpesa_code');
            $table->boolean('is_verified')->default(false)->after('confirmed_by_manager');
            $table->timestamp('verified_at')->nullable()->after('is_verified');
            $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            $table->integer('verification_count')->default(0)->after('verified_by');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'ticket_number', 
                'qr_code', 
                'is_verified', 
                'verified_at', 
                'verified_by',
                'verification_count'
            ]);
        });
    }
};