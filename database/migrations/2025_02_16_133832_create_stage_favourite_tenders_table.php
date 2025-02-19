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
        Schema::create('work_stage_tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('favourite_id')->constrained('favourite_tenders');
            $table->foreignId('stage_id')->constrained('work_stage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_favourite_tenders');
    }
};
