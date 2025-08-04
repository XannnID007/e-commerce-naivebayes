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
        // Tambah field validated_at di training_data table
        Schema::table('training_data', function (Blueprint $table) {
            if (!Schema::hasColumn('training_data', 'validated_at')) {
                $table->timestamp('validated_at')->nullable()->after('is_validated');
            }
        });

        // Tambah field tokens_analyzed dan text_length di classification_logs table
        Schema::table('classification_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('classification_logs', 'tokens_analyzed')) {
                $table->integer('tokens_analyzed')->default(0)->after('confidence_score');
            }
            if (!Schema::hasColumn('classification_logs', 'text_length')) {
                $table->integer('text_length')->default(0)->after('tokens_analyzed');
            }
        });

        // Tambah index untuk performa yang lebih baik
        Schema::table('classification_logs', function (Blueprint $table) {
            $table->index(['product_id']);
            $table->index(['predicted_category_id']);
            $table->index(['actual_category_id']);
            $table->index(['is_correct']);
            $table->index(['created_at']);
        });

        Schema::table('naive_bayes_models', function (Blueprint $table) {
            $table->index(['category_id']);
            $table->index(['kata']);
            $table->index(['category_id', 'kata']);
        });

        Schema::table('training_data', function (Blueprint $table) {
            $table->index(['category_id']);
            $table->index(['is_validated']);
            $table->index(['category_id', 'is_validated']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_data', function (Blueprint $table) {
            if (Schema::hasColumn('training_data', 'validated_at')) {
                $table->dropColumn('validated_at');
            }
        });

        Schema::table('classification_logs', function (Blueprint $table) {
            if (Schema::hasColumn('classification_logs', 'tokens_analyzed')) {
                $table->dropColumn('tokens_analyzed');
            }
            if (Schema::hasColumn('classification_logs', 'text_length')) {
                $table->dropColumn('text_length');
            }
        });

        // Drop indexes
        Schema::table('classification_logs', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['predicted_category_id']);
            $table->dropIndex(['actual_category_id']);
            $table->dropIndex(['is_correct']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('naive_bayes_models', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['kata']);
            $table->dropIndex(['category_id', 'kata']);
        });

        Schema::table('training_data', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['is_validated']);
            $table->dropIndex(['category_id', 'is_validated']);
        });
    }
};
