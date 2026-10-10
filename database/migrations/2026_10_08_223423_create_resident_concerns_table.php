<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resident_concerns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resident_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('category', 100);

            $table->string('subject', 255);

            $table->text('description');

            $table->string('photo_path')->nullable();

            $table->enum('status', [
                'pending',
                'in_review',
                'resolved',
                'rejected',
            ])->default('pending');

            $table->text('admin_response')->nullable();

            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resident_concerns');
    }
};