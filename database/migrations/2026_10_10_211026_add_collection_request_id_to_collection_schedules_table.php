<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('collection_schedules', function (Blueprint $table) {
        $table->foreignId('collection_request_id')
            ->nullable()
            ->after('id')
            ->constrained('collection_requests')
            ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('collection_schedules', function (Blueprint $table) {
        $table->dropForeign(['collection_request_id']);
        $table->dropColumn('collection_request_id');
    });
}
};
