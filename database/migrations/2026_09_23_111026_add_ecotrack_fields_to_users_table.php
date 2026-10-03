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
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_number', 20)->nullable();
            $table->enum('role', ['lgu_admin', 'resident'])->default('resident');
            $table->foreignId('brgy_id')
                ->nullable()
                ->constrained('barangays')
                ->nullOnDelete();

            $table->string('zone', 100)->nullable();
            $table->text('address')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'inactive'
            ])->default('pending');

            $table->string('verification_document', 255)->nullable();

            $table->timestamp('verified_at')->nullable();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('rejection_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['brgy_id']);
            $table->dropForeign(['verified_by']);

            $table->dropColumn([
                'mobile_number',
                'role',
                'brgy_id',
                'zone',
                'address',
                'status',
                'verification_document',
                'verified_at',
                'verified_by',
                'rejection_reason',
            ]);
        });
    }
};
