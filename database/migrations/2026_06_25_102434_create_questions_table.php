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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('question_type', ['mcq', 'true_false', 'descriptive'])->default('mcq');

            $table->longText('question_text');
            $table->text('option_a');
            $table->text('option_b');
            $table->text('option_c')->nullable();
            $table->text('option_d')->nullable();

            $table->enum('correct_option', ['a', 'b', 'c', 'd']);

            $table->decimal('marks', 5, 2)->default(1);
            $table->decimal('negative_marks', 5, 2)->nullable();

            $table->longText('explanation')->nullable();
            $table->string('image_path')->nullable();

            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();

            $table->index('subject_id');
            $table->index('question_type');
            $table->index('status');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
