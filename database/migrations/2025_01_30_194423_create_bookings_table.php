<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('plan_type');
            $table->integer('group_size'); 
            $table->decimal('price', 10, 2);
            $table->string('team_lead_name');
            $table->string('team_lead_email');
            $table->string('team_lead_phone');
            $table->json('members')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('mpesa_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};