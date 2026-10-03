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
        Schema::create('collection_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brgy_id')
            ->constrained('barangays')
            ->cascadeOnDelete();

            $table->string('zone', 100);

            $table->date('collection_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->enum('status', [
            'scheduled',
            'completed',
            'cancelled'
            ])->default('scheduled');

            $table->foreignId('created_by')
            ->constrained('users')
            ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_schedules');
    }
};
