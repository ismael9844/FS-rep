<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_request_donations', function (Blueprint $table) {
            if (!Schema::hasColumn('food_request_donations', 'status')) {
                $table->string('status')->default('pending')->after('available_until');
                // pending, accepted, confirmed, rejected
            }
            
            if (!Schema::hasColumn('food_request_donations', 'confirmation_token')) {
                $table->string('confirmation_token')->nullable()->unique()->after('status');
            }
            
            if (!Schema::hasColumn('food_request_donations', 'scheduled_date')) {
                $table->dateTime('scheduled_date')->nullable()->after('confirmation_token');
            }
            
            if (!Schema::hasColumn('food_request_donations', 'location')) {
                $table->string('location')->nullable()->after('scheduled_date');
            }
            
            if (!Schema::hasColumn('food_request_donations', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('location');
            }
            
            if (!Schema::hasColumn('food_request_donations', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            
            if (!Schema::hasColumn('food_request_donations', 'partner_note')) {
                $table->text('partner_note')->nullable()->after('longitude');
            }
        });

        Schema::table('contributions', function (Blueprint $table) {
            if (!Schema::hasColumn('contributions', 'status')) {
                $table->string('status')->default('pending')->after('amount');
                // pending, confirmed
            }
        });
    }

    public function down(): void
    {
        Schema::table('food_request_donations', function (Blueprint $table) {
            $table->dropColumn([
                'status', 
                'confirmation_token', 
                'scheduled_date', 
                'location',
                'latitude',
                'longitude',
                'partner_note'
            ]);
        });

        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};