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
        Schema::create('classification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('predicted_category_id')->constrained('categories');
            $table->foreignId('actual_category_id')->nullable()->constrained('categories');
            $table->decimal('confidence_score', 5, 2);
            $table->json('probabilities'); // Menyimpan probabilitas semua kategori
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_logs');
    }
};
