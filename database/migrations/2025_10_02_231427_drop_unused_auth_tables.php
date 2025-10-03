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
        // Drop unused authentication tables
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('verification_codes');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate password_reset_tokens table if needed
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Recreate verification_codes table if needed
        Schema::create('verification_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();
            $table->string('email');
            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
            
            $table->index(['email', 'used']);
            $table->index('expires_at');
        });
    }
};