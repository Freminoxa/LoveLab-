<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('packages')) {
            Schema::table('packages', function (Blueprint $table) {
                if (!Schema::hasColumn('packages', 'group_size')) {
                    $table->integer('group_size')->default(1)->after('price');
                }
                if (!Schema::hasColumn('packages', 'description')) {
                    $table->text('description')->nullable()->after('group_size');
                }
                if (!Schema::hasColumn('packages', 'available_tickets')) {
                    $table->integer('available_tickets')->nullable()->after('description');
                }
                if (!Schema::hasColumn('packages', 'icon')) {
                    $table->string('icon', 10)->default('🎫')->after('available_tickets');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('packages')) {
            Schema::table('packages', function (Blueprint $table) {
                if (Schema::hasColumn('packages', 'group_size')) {
                    $table->dropColumn('group_size');
                }
                if (Schema::hasColumn('packages', 'description')) {
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('packages', 'available_tickets')) {
                    $table->dropColumn('available_tickets');
                }
                if (Schema::hasColumn('packages', 'icon')) {
                    $table->dropColumn('icon');
                }
            });
        }
    }
};