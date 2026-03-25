<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donation_volunteer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('volunteer_id')
                  ->constrained('volunteers')
                  ->onDelete('cascade');
            $table->timestamp('volunteered_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_volunteer');
    }
};
