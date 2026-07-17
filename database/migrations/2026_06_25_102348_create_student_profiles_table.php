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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('admission_no', 100)->unique();
            $table->date('admission_date')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('blood_group', 5)->nullable();

            $table->string('father_name', 150)->nullable();

            $table->string('mother_name', 150)->nullable();

            $table->string('guardian_name', 150)->nullable();

            $table->string('guardian_mobile', 20)->nullable();

            $table->string('guardian_email', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();

            $table->string('state', 100)->nullable();

            $table->string('pincode', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique('user_id');
            $table->index('admission_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
