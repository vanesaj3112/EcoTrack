<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collection_schedules', function (Blueprint $table) {
            $table->date('collection_date')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('collection_schedules', function (Blueprint $table) {
            $table->date('collection_date')
                ->nullable(false)
                ->change();
        });
    }
};
