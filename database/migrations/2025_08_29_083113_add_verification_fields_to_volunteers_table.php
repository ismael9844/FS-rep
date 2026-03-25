<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationFieldsToVolunteersTable extends Migration
{
    public function up()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->string('document_path')->nullable()->after('availability');
            $table->enum('verification_status', ['pending', 'approved', 'declined', 'suspended'])->default('pending')->after('document_path');
            $table->text('verification_note')->nullable()->after('verification_status');
            $table->timestamp('verification_requested_at')->nullable()->after('verification_note');
        });
    }

    public function down()
    {
        Schema::table('volunteers', function (Blueprint $table) {
            $table->dropColumn(['document_path','verification_status','verification_note','verification_requested_at']);
        });
    }
}
