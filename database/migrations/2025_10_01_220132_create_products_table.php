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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->integer('quantity')->default(0);
            $table->boolean('is_available')->default(true)->index();
            $table->string('image')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['is_available', 'quantity']);
            $table->index(['price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
