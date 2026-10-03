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
        Schema::create('sms_notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('announcement_id')
            ->constrained('announcements')
            ->cascadeOnDelete();

            $table->foreignId('resident_id')
            ->constrained('users')
            ->cascadeOnDelete();

            $table->string('mobile_number', 20);
            $table->text('message');

            $table->enum('status', [
            'pending',
            'sent',
            'failed'
            ])->default('pending');

            $table->string('provider_message_id', 255)->nullable();
            $table->timestamp('sent_at')->nullable();

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
        Schema::dropIfExists('sms_notifications');
    }
};
