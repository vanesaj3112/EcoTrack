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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();

            $table->string('title', 200);
            $table->text('message');

            $table->enum('audience', [
            'all',
            'barangay',
            'zone'
            ]);

            $table->foreignId('brgy_id')
            ->nullable()
            ->constrained('barangays')
            ->nullOnDelete();

            $table->string('zone', 100)->nullable();

            $table->timestamp('published_at')->nullable();

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
        Schema::dropIfExists('announcements');
    }
};
