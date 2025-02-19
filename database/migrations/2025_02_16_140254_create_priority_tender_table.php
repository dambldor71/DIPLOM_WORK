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
        Schema::create('priority_tender', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('favourite_tenders');
            $table->foreignId('priority_id')->constrained('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priority_tender');
    }
};
