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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_id')
                ->nullable()
                ->constrained('academic_classes')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('title', 200);
            $table->string('exam_code', 100)->nullable()->unique();
            $table->text('description')->nullable();
            $table->longText('instructions')->nullable();

            $table->integer('duration_minutes'); // exam duration in minutes
            $table->decimal('total_marks', 8, 2)->default(0);
            $table->decimal('passing_marks', 8, 2)->nullable();
            $table->integer('total_questions')->default(0);

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();

            $table->integer('max_attempts')->default(1);

            $table->boolean('negative_marking')->default(0);
            $table->decimal('negative_marks_per_wrong', 5, 2)->nullable();

            $table->boolean('shuffle_questions')->default(0);
            $table->boolean('shuffle_options')->default(0);

            $table->boolean('show_result_immediately')->default(1);

            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();

            $table->index('class_id');
            $table->index('subject_id');
            $table->index('status');
            $table->index('start_at');
            $table->index('end_at');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
