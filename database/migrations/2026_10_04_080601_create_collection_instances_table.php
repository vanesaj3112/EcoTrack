<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_instances', function (Blueprint $table) {
            $table->id();

            // Weekly schedule na pinanggalingan
            $table->foreignId('collection_schedule_id')
                ->constrained('collection_schedules')
                ->cascadeOnDelete();

            // Actual date ng collection
            $table->date('collection_date');

            // Actual collector assigned to this occurrence
            $table->foreignId('collector_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Actual collection status
            $table->enum('status', [
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
            ])->default('scheduled');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Isang occurrence lang bawat schedule/date
            $table->unique(
    ['collection_schedule_id', 'collection_date'],
    'schedule_date_unique'
);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_instances');
    }
};
