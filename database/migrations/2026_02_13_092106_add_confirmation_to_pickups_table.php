<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pickups', 'confirmation_token')) {
            Schema::table('pickups', function (Blueprint $table) {
                $table->string('confirmation_token')->nullable()->unique();
            });
        }
        
        if (!Schema::hasColumn('pickups', 'confirmed_at')) {
            Schema::table('pickups', function (Blueprint $table) {
                $table->timestamp('confirmed_at')->nullable();
            });
        }

        if (!Schema::hasColumn('donations', 'status')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->string('status')->default('available');
            });
        }
    }

    public function down(): void
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropColumn(['confirmation_token', 'confirmed_at']);
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};