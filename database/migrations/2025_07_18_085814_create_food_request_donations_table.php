<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('food_request_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('unit')->default('servings');
            $table->timestamp('available_until');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('food_request_donations');
    }
};
