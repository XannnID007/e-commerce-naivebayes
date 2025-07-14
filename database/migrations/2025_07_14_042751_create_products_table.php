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
            $table->string('nama');
            $table->text('deskripsi');
            $table->decimal('harga', 10, 2);
            $table->string('konsentrasi'); // EDC, EDT, EDP
            $table->string('top_notes')->nullable();
            $table->string('middle_notes')->nullable();
            $table->string('base_notes')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('confidence_score', 5, 2)->nullable(); // Skor kepercayaan klasifikasi
            $table->boolean('aktif')->default(true);
            $table->timestamps();
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
