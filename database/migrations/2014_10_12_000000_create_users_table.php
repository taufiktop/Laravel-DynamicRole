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
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            $table->uuid('uuid')->primary()->unique();
            $table->string('name');
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->string('role');
            $table->string('source')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expired_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
