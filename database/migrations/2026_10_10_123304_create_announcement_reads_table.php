
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_reads', function (Blueprint $table) {
            $table->id();

            $table->foreignId('announcement_id')
                ->constrained('announcements')
                ->cascadeOnDelete();

            $table->foreignId('resident_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('read_at')->useCurrent();

            $table->timestamps();

            $table->unique(
                ['announcement_id', 'resident_id'],
                'announcement_reads_unique_resident'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_reads');
    }
};
