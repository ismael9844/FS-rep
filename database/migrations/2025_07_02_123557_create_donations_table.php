<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->string('unit')->default('portion');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamp('available_until')->nullable();
            $table->string('category')->nullable();
            $table->foreignId('food_request_id')->nullable()->constrained()->onDelete('cascade');


        // filtres
            $table->integer('min_quantity')->default(1);
            $table->enum('donor_type', ['individual','organization'])->default('individual');
            $table->time('available_from')->nullable();
            $table->time('available_to')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('donations');
    }
}
