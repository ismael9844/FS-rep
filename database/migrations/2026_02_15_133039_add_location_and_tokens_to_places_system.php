<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add coordinates to places table
        Schema::table('places', function (Blueprint $table) {
            if (!Schema::hasColumn('places', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('address');
            }
            if (!Schema::hasColumn('places', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('places', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('places', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('city');
            }
        });

        // Add confirmation token to place_requests
        Schema::table('place_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('place_requests', 'confirmation_token')) {
                $table->string('confirmation_token')->unique()->nullable()->after('status');
            }
            if (!Schema::hasColumn('place_requests', 'scheduled_date')) {
                $table->dateTime('scheduled_date')->nullable()->after('confirmation_token');
            }
            if (!Schema::hasColumn('place_requests', 'partner_note')) {
                $table->text('partner_note')->nullable()->after('scheduled_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'city', 'postal_code']);
        });

        Schema::table('place_requests', function (Blueprint $table) {
            $table->dropColumn(['confirmation_token', 'scheduled_date', 'partner_note']);
        });
    }
};