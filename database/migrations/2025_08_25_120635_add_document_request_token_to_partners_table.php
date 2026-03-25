<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('document_request_token')->nullable()->after('document_path');
            $table->timestamp('document_request_expires_at')->nullable()->after('document_request_token');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['document_request_token', 'document_request_expires_at']);
        });
    }
};
