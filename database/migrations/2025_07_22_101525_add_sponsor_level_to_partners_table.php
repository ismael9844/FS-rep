<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('partners', function (Blueprint $table) {
        $table->enum('sponsor_level', ['platinum', 'gold', 'silver', 'bronze'])->nullable()->after('status');
    });
}

public function down()
{
    Schema::table('partners', function (Blueprint $table) {
        $table->dropColumn('sponsor_level');
    });
}

};
