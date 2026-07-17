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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')
                ->nullable()
                ->constrained('academic_classes')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('subject_name', 150);
            $table->string('subject_code', 50)->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');
            $table->timestamps();

            $table->index('class_id');
            $table->index('status');
            $table->unique(['class_id', 'subject_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
