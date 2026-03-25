<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->integer('need_volunteers')->default(0)->after('expiration_date');
            $table->text('volunteer_note')->nullable()->after('need_volunteers');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['need_volunteers', 'volunteer_note']);
        });
    }
};
