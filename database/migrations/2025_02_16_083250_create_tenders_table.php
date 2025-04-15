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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string('tender_code')->unique();
            $table->text('description');
            $table->text('link')->unique();
            $table->foreignId('law')->constrained('filters');
            $table->foreignId('purchase_stage')->constrained('filters');
            $table->foreignId('type_of_select')->constrained('filters');
            $table->float('price');
            $table->text('customer');
            $table->date('start_date');
            $table->date('update_date');
            $table->date('end_date')->nullable();
            $table->text('source_link');
            $table->timestamps('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender');
    }
};
