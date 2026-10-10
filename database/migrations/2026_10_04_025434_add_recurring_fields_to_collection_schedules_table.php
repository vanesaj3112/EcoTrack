<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collection_schedules', function (Blueprint $table) {
            $table->string('day_of_week', 20)
                ->nullable()
                ->after('zone');

            $table->foreignId('collector_id')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('started_at')
                ->nullable()
                ->after('status');

            $table->timestamp('completed_at')
                ->nullable()
                ->after('started_at');
        });
    }

    public function down(): void
    {
        Schema::table('collection_schedules', function (Blueprint $table) {
            $table->dropForeign(['collector_id']);

            $table->dropColumn([
                'day_of_week',
                'collector_id',
                'started_at',
                'completed_at',
            ]);
        });
    }
};
