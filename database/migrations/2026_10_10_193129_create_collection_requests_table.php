<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('brgy_id')
                ->constrained('barangays')
                ->cascadeOnDelete();

            $table->string('zone', 100);
            $table->date('requested_date');
            $table->time('preferred_start_time');
            $table->time('preferred_end_time');

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
            ])->default('pending');

            $table->foreignId('assigned_collector_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->index(['status', 'requested_date']);
            $table->index(['brgy_id', 'zone', 'requested_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collection_requests');
    }
};
