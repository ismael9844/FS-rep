<?php

// 1. Migration pour ajouter la colonne status
// Créez ce fichier: database/migrations/2025_07_19_172826_add_status_to_donations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToDonationsTable extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->enum('status', ['available', 'reserved', 'completed', 'cancelled'])
                  ->default('available')
                  ->after('available_until');
            
            // Ajoutons aussi quelques colonnes utiles si elles n'existent pas
            if (!Schema::hasColumn('donations', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            
            if (!Schema::hasColumn('donations', 'quantity')) {
                $table->string('quantity')->nullable()->after('image');
            }
            
            if (!Schema::hasColumn('donations', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('donations', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['status', 'image', 'quantity', 'latitude', 'longitude']);
        });
    }
}