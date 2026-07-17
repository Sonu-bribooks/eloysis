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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);

            $table->string('email',150);

            $table->string('phone',20)->nullable();

            $table->string('subject',200);

            $table->text('message');

            $table->enum('status',['pending','read','replied'])
                ->default('pending');

            $table->ipAddress('ip_address')->nullable();

            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
