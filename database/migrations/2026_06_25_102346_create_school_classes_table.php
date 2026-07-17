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
        Schema::create('academic_classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name', 150);          // Example: Class 10, BCA Sem 1
            $table->string('class_code', 50)->nullable(); // Example: C10, BCA1
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');
            $table->timestamps();
            $table->softDeletes();
            $table->index('status');
            $table->unique('class_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_classes');
    }
};
