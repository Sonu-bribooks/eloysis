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
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('employee_id', 100)->unique();
            $table->string('father_name', 150)->nullable();

            $table->string('mother_name', 150)->nullable();

            $table->string('qualification', 255)->nullable();

            $table->string('specialization', 255)->nullable();

            $table->date('joining_date')->nullable();

            $table->date('dob')->nullable();

            $table->enum('gender', [
                'male',
                'female',
                'other',
            ])->nullable();

            $table->unsignedTinyInteger('experience_years')
                ->nullable();

            $table->string('address', 255)->nullable();

            $table->string('city', 100)->nullable();

            $table->string('state', 100)->nullable();

            $table->string('pincode', 10)->nullable();

            $table->string('emergency_contact_name', 150)
                ->nullable();

            $table->string('emergency_contact_mobile', 20)
                ->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_profiles');
    }
};
