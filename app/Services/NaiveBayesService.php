<?php

namespace App\Services;

use App\Models\Category;
use App\Models\TrainingData;
use App\Models\NaiveBayesModel;
use App\Models\ClassificationLog;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class NaiveBayesService
{
     private $stopWords = [
          'dan',
          'atau',
          'dengan',
          'untuk',
          'dari',
          'pada',
          'di',
          'ke',
          'yang',
          'adalah',
          'akan',
          'dapat',
          'sudah',
          'telah',
          'sangat',
          'lebih',
          'paling',
          'juga',
          'serta',
          'the',
          'a',
          'an',
          'and',
          'or',
          'but',
          'in',
          'on',
          'at',
          'to',
          'for',
          'of',
          'with',
          'this',
          'that',
          'these',
          'those',
          'it',
          'its',
          'is',
          'are',
          'was',
          'were',
          'be',
          'have',
          'has',
          'had',
          'do',
          'does',
          'did',
          'will',
          'would',
          'could',
          'should',
          'may',
          'might',
          'must',
          'can',
          'all',
          'any',
          'some',
          'no',
          'not',
          'only',
          'own',
          'same',
          'so',
          'than',
          'too',
          'very',
          'just',
          'now'
     ];

     private $minWordLength = 3;
     private $maxWordLength = 50;

     public function trainModel()
     {
          try {
               Log::info('Memulai training model Naive Bayes...');

               DB::beginTransaction();

               // Validasi data training
               $this->validateTrainingData();

               // Hapus model lama
               Log::info('Menghapus model lama...');
               NaiveBayesModel::truncate();

               $categories = Category::all();
               $allTrainingData = TrainingData::where('is_validated', true)->with('category')->get();

               if ($allTrainingData->isEmpty()) {
                    throw new \Exception('Tidak ada data training yang tervalidasi');
               }

               Log::info('Total data training: ' . $allTrainingData->count());
               Log::info('Total kategori: ' . $categories->count());

               // Cek distribusi data per kategori
               $dataPerCategory = $allTrainingData->groupBy('category_id');
               Log::info('Data per kategori: ' . $dataPerCategory->map->count()->toArray());

               // Proses setiap kategori
               foreach ($categories as $category) {
                    $categoryData = $allTrainingData->where('category_id', $category->id);

                    if ($categoryData->isEmpty()) {
                         Log::warning("Tidak ada data training untuk kategori: {$category->nama}");
                         continue;
                    }

                    Log::info("Memproses kategori: {$category->nama} dengan {$categoryData->count()} data");
                    $this->trainCategoryModel($category, $categoryData);
               }

               // Clear cache untuk model
               Cache::forget('naive_bayes_model_stats');
               Cache::forget('naive_bayes_categories');

               DB::commit();
               Log::info('Training model berhasil diselesaikan');

               return [
                    'success' => true,
                    'total_categories' => $categories->count(),
                    'total_training_data' => $allTrainingData->count(),
                    'categories_trained' => $dataPerCategory->count()
               ];
          } catch (\Exception $e) {
               DB::rollback();
               Log::error('Error training Naive Bayes model: ' . $e->getMessage());
               Log::error('Stack trace: ' . $e->getTraceAsString());
               throw $e;
          }
     }

     private function validateTrainingData()
     {
          $validatedCount = TrainingData::where('is_validated', true)->count();
          if ($validatedCount < 10) {
               throw new \Exception("Minimal 10 data training tervalidasi diperlukan (saat ini: {$validatedCount})");
          }

          $categoriesWithData = TrainingData::where('is_validated', true)
               ->distinct('category_id')
               ->count('category_id');

          if ($categoriesWithData < 2) {
               throw new \Exception("Minimal 2 kategori harus memiliki data training tervalidasi");
          }

          // Cek minimal data per kategori
          $categoryStats = TrainingData::where('is_validated', true)
               ->select('category_id')
               ->selectRaw('count(*) as count')
               ->groupBy('category_id')
               ->with('category:id,nama')
               ->get();

          $problemCategories = [];
          foreach ($categoryStats as $stat) {
               if ($stat->count < 2) {
                    $problemCategories[] = $stat->category->nama;
               }
          }

          if (!empty($problemCategories)) {
               throw new \Exception('Setiap kategori harus memiliki minimal 2 data training. Kategori bermasalah: ' . implode(', ', $problemCategories));
          }
     }

     private function trainCategoryModel($category, $categoryData)
     {
          try {
               Log::info("Training kategori: {$category->nama}");

               // Kumpulkan semua teks dari kategori ini
               $allTexts = [];
               foreach ($categoryData as $data) {
                    $text = $this->preprocessText($data->all_text);
                    $tokens = $this->tokenize($text);
                    $allTexts = array_merge($allTexts, $tokens);
               }

               if (empty($allTexts)) {
                    Log::warning("Tidak ada token yang dihasilkan untuk kategori: {$category->nama}");
                    return;
               }

               // Hitung frekuensi kata
               $wordFrequencies = array_count_values($allTexts);
               $totalWords = array_sum($wordFrequencies);
               $vocabularySize = count($wordFrequencies);

               Log::info("Kategori {$category->nama}: {$totalWords} total kata, {$vocabularySize} unique kata");

               // Filter kata berdasarkan frekuensi minimum
               $minFrequency = max(1, intval($totalWords * 0.001)); // Minimal 0.1% dari total kata
               $filteredWords = array_filter($wordFrequencies, function ($freq) use ($minFrequency) {
                    return $freq >= $minFrequency;
               });

               // Simpan ke database dengan Laplace smoothing
               $batchData = [];
               foreach ($filteredWords as $word => $frequency) {
                    if (strlen($word) >= $this->minWordLength && strlen($word) <= $this->maxWordLength) {
                         $probability = ($frequency + 1) / ($totalWords + $vocabularySize);

                         $batchData[] = [
                              'category_id' => $category->id,
                              'kata' => $word,
                              'frekuensi' => $frequency,
                              'probabilitas' => $probability,
                              'created_at' => now(),
                              'updated_at' => now()
                         ];

                         // Insert in batches untuk performance
                         if (count($batchData) >= 100) {
                              NaiveBayesModel::insert($batchData);
                              $batchData = [];
                         }
                    }
               }

               // Insert remaining data
               if (!empty($batchData)) {
                    NaiveBayesModel::insert($batchData);
               }

               Log::info("Selesai training kategori: {$category->nama} dengan " . count($filteredWords) . " kata");
          } catch (\Exception $e) {
               Log::error("Error training kategori {$category->nama}: " . $e->getMessage());
               throw $e;
          }
     }

     public function classify($productData)
     {
          try {
               $text = $this->buildTextFromProduct($productData);
               $preprocessedText = $this->preprocessText($text);
               $tokens = $this->tokenize($preprocessedText);

               if (empty($tokens)) {
                    throw new \Exception('Tidak ada token yang dapat dianalisis dari produk');
               }

               $categories = Category::all();
               if ($categories->isEmpty()) {
                    throw new \Exception('Tidak ada kategori yang tersedia');
               }

               $categoryProbabilities = [];
               $totalCategories = $categories->count();

               foreach ($categories as $category) {
                    $probability = $this->calculateCategoryProbability($category, $tokens);
                    $categoryProbabilities[$category->id] = [
                         'category' => $category,
                         'probability' => $probability,
                         'log_probability' => $probability > 0 ? log($probability) : -INF
                    ];
               }

               // Cari kategori dengan probabilitas tertinggi
               $bestCategory = collect($categoryProbabilities)->sortByDesc('probability')->first();

               if (!$bestCategory) {
                    throw new \Exception('Tidak dapat menentukan kategori terbaik');
               }

               // Hitung confidence score dengan normalisasi
               $totalProbability = collect($categoryProbabilities)->sum('probability');
               $confidenceScore = 0;

               if ($totalProbability > 0) {
                    $confidenceScore = ($bestCategory['probability'] / $totalProbability) * 100;

                    // Adjust confidence based on token count (more tokens = more confident)
                    $tokenBonus = min(10, count($tokens) * 0.5); // Max 10% bonus
                    $confidenceScore = min(100, $confidenceScore + $tokenBonus);
               }

               // Apply minimum confidence threshold
               $confidenceScore = max(5, $confidenceScore); // Minimum 5% confidence

               return [
                    'category_id' => $bestCategory['category']->id,
                    'category_name' => $bestCategory['category']->nama,
                    'confidence_score' => round($confidenceScore, 2),
                    'probabilities' => $categoryProbabilities,
                    'tokens_analyzed' => count($tokens),
                    'text_length' => strlen($text)
               ];
          } catch (\Exception $e) {
               Log::error('Error dalam klasifikasi: ' . $e->getMessage());

               // Return kategori default jika error
               $defaultCategory = Category::first();
               if (!$defaultCategory) {
                    throw new \Exception('Tidak ada kategori yang tersedia dalam sistem');
               }

               return [
                    'category_id' => $defaultCategory->id,
                    'category_name' => $defaultCategory->nama,
                    'confidence_score' => 5.00, // Very low confidence for errors
                    'probabilities' => [],
                    'tokens_analyzed' => 0,
                    'text_length' => 0,
                    'error' => $e->getMessage()
               ];
          }
     }

     private function calculateCategoryProbability($category, $tokens)
     {
          try {
               // Prior probability (berdasarkan jumlah data training)
               $categoryTrainingCount = TrainingData::where('category_id', $category->id)
                    ->where('is_validated', true)
                    ->count();

               $totalTrainingCount = TrainingData::where('is_validated', true)->count();
               $priorProbability = $totalTrainingCount > 0 ? $categoryTrainingCount / $totalTrainingCount : 1 / Category::count();

               // Likelihood dengan caching
               $cacheKey = "nb_category_{$category->id}_words";
               $categoryWords = Cache::remember($cacheKey, 3600, function () use ($category) {
                    return NaiveBayesModel::where('category_id', $category->id)
                         ->pluck('probabilitas', 'kata')
                         ->toArray();
               });

               if (empty($categoryWords)) {
                    Log::warning("Tidak ada model kata untuk kategori: {$category->nama}");
                    return $priorProbability * 0.001; // Very small probability
               }

               $likelihood = 1.0;
               $smoothingFactor = 0.001; // Laplace smoothing
               $processedTokens = 0;

               foreach ($tokens as $token) {
                    if (isset($categoryWords[$token])) {
                         $likelihood *= $categoryWords[$token];
                         $processedTokens++;
                    } else {
                         // Smoothing untuk kata yang tidak ditemukan
                         $likelihood *= $smoothingFactor;
                    }
               }

               // Adjust likelihood berdasarkan jumlah token yang diproses
               if ($processedTokens > 0) {
                    $coverageBonus = min(2.0, 1 + ($processedTokens / count($tokens))); // Max 2x bonus
                    $likelihood *= $coverageBonus;
               }

               return max(0.0001, $priorProbability * $likelihood); // Minimum probability

          } catch (\Exception $e) {
               Log::error("Error calculating probability for category {$category->nama}: " . $e->getMessage());
               return 0.0001; // Very small probability for errors
          }
     }

     private function buildTextFromProduct($productData)
     {
          $textParts = array_filter([
               $productData['deskripsi'] ?? '',
               $productData['top_notes'] ?? '',
               $productData['middle_notes'] ?? '',
               $productData['base_notes'] ?? ''
          ]);

          return implode(' ', $textParts);
     }

     private function preprocessText($text)
     {
          // Konversi ke lowercase
          $text = strtolower($text);

          // Remove extra whitespace dan newlines
          $text = preg_replace('/\s+/', ' ', $text);

          // Hapus karakter khusus, tapi pertahankan huruf dan angka
          $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);

          // Hapus angka standalone (tapi biarkan dalam kata)
          $text = preg_replace('/\b\d+\b/', ' ', $text);

          // Trim dan hapus extra spaces
          $text = trim(preg_replace('/\s+/', ' ', $text));

          return $text;
     }

     private function tokenize($text)
     {
          $words = explode(' ', $text);

          // Filter kata-kata
          $words = array_filter($words, function ($word) {
               return !empty($word) &&
                    strlen($word) >= $this->minWordLength &&
                    strlen($word) <= $this->maxWordLength &&
                    !in_array($word, $this->stopWords) &&
                    !is_numeric($word);
          });

          // Remove duplicates dan return
          return array_values(array_unique($words));
     }

     public function logClassification($product, $classification)
     {
          try {
               // Cek apakah sudah ada log untuk produk ini
               $existingLog = ClassificationLog::where('product_id', $product->id)->first();

               $logData = [
                    'product_id' => $product->id,
                    'predicted_category_id' => $classification['category_id'],
                    'actual_category_id' => $product->category_id,
                    'confidence_score' => $classification['confidence_score'],
                    'probabilities' => $classification['probabilities'],
                    'is_correct' => $classification['category_id'] == $product->category_id,
                    'tokens_analyzed' => $classification['tokens_analyzed'] ?? 0,
                    'text_length' => $classification['text_length'] ?? 0
               ];

               if ($existingLog) {
                    $existingLog->update($logData);
                    Log::info("Updated classification log for product {$product->id}");
               } else {
                    ClassificationLog::create($logData);
                    Log::info("Created new classification log for product {$product->id}");
               }
          } catch (\Exception $e) {
               Log::error('Error logging classification: ' . $e->getMessage());
               // Don't throw exception here to avoid breaking the main classification flow
          }
     }

     /**
      * Get model statistics
      */
     public function getModelStats()
     {
          return Cache::remember('naive_bayes_model_stats', 3600, function () {
               $totalWords = NaiveBayesModel::count();
               $totalCategories = NaiveBayesModel::distinct('category_id')->count();
               $avgWordsPerCategory = $totalCategories > 0 ? $totalWords / $totalCategories : 0;

               $categoryStats = NaiveBayesModel::select('category_id')
                    ->selectRaw('COUNT(*) as word_count, AVG(probabilitas) as avg_probability')
                    ->groupBy('category_id')
                    ->with('category:id,nama')
                    ->get();

               return [
                    'total_words' => $totalWords,
                    'total_categories' => $totalCategories,
                    'avg_words_per_category' => round($avgWordsPerCategory, 2),
                    'category_stats' => $categoryStats,
                    'last_trained' => NaiveBayesModel::max('updated_at')
               ];
          });
     }

     /**
      * Clear model cache
      */
     public function clearCache()
     {
          Cache::forget('naive_bayes_model_stats');
          Cache::forget('naive_bayes_categories');

          // Clear all category-specific caches
          $categories = Category::all();
          foreach ($categories as $category) {
               Cache::forget("nb_category_{$category->id}_words");
          }
     }
}
