<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Supprimer la contrainte CHECK sur availability
        DB::statement('ALTER TABLE places DROP CONSTRAINT IF EXISTS availability');
        
        // Ou alternativement, recréer la colonne sans contrainte
        Schema::table('places', function (Blueprint $table) {
            $table->date('availability')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Optionnel
    }
};