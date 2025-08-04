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

               // Test koneksi database terlebih dahulu
               $this->testDatabaseConnection();

               // Validasi data training tanpa transaction
               $this->validateTrainingData();

               // Clear old models dengan chunk untuk avoid memory issues
               Log::info('Menghapus model lama...');
               $this->clearOldModels();

               // Get data dengan cara yang lebih aman
               $categories = Category::select('id', 'nama')->get();
               $allTrainingData = TrainingData::select('id', 'deskripsi', 'top_notes', 'middle_notes', 'base_notes', 'category_id')
                    ->where('is_validated', true)
                    ->with('category:id,nama')
                    ->get();

               if ($allTrainingData->isEmpty()) {
                    throw new \Exception('Tidak ada data training yang tervalidasi');
               }

               Log::info('Total data training: ' . $allTrainingData->count());
               Log::info('Total kategori: ' . $categories->count());

               // Proses setiap kategori dengan error handling individual
               $categoriesTrained = 0;
               $errors = [];

               foreach ($categories as $category) {
                    try {
                         $categoryData = $allTrainingData->where('category_id', $category->id);

                         if ($categoryData->isEmpty()) {
                              Log::warning("Tidak ada data training untuk kategori: {$category->nama}");
                              continue;
                         }

                         Log::info("Memproses kategori: {$category->nama} dengan {$categoryData->count()} data");

                         $this->trainCategoryModelSafe($category, $categoryData);
                         $categoriesTrained++;
                    } catch (\Exception $e) {
                         $errorMsg = "Error training kategori {$category->nama}: " . $e->getMessage();
                         Log::error($errorMsg);
                         $errors[] = $errorMsg;
                         continue; // Lanjut ke kategori berikutnya
                    }
               }

               if ($categoriesTrained === 0) {
                    $errorMessage = 'Tidak ada kategori yang berhasil dilatih.';
                    if (!empty($errors)) {
                         $errorMessage .= ' Errors: ' . implode('; ', array_slice($errors, 0, 3));
                    }
                    throw new \Exception($errorMessage);
               }

               // Clear cache setelah berhasil
               $this->clearCache();

               Log::info("Training model berhasil diselesaikan dengan {$categoriesTrained} kategori");

               return [
                    'success' => true,
                    'total_categories' => $categories->count(),
                    'total_training_data' => $allTrainingData->count(),
                    'categories_trained' => $categoriesTrained,
                    'errors' => $errors
               ];
          } catch (\Exception $e) {
               Log::error('Error training Naive Bayes model: ' . $e->getMessage());
               Log::error('Stack trace: ' . $e->getTraceAsString());
               throw $e;
          }
     }

     private function testDatabaseConnection()
     {
          try {
               // Test simple query
               DB::select('SELECT 1 as test');

               // Test koneksi ke tabel yang akan digunakan
               $testCount = TrainingData::count();
               Log::info("Database connection OK. Training data count: {$testCount}");
          } catch (\Exception $e) {
               Log::error('Database connection failed: ' . $e->getMessage());
               throw new \Exception('Koneksi database bermasalah: ' . $e->getMessage());
          }
     }

     private function clearOldModels()
     {
          try {
               // Hapus dalam chunk untuk avoid memory issues
               NaiveBayesModel::chunk(1000, function ($models) {
                    $ids = $models->pluck('id')->toArray();
                    NaiveBayesModel::whereIn('id', $ids)->delete();
               });

               Log::info('Model lama berhasil dihapus');
          } catch (\Exception $e) {
               Log::error('Error clearing old models: ' . $e->getMessage());
               // Coba truncate sebagai fallback
               try {
                    NaiveBayesModel::truncate();
                    Log::info('Fallback truncate berhasil');
               } catch (\Exception $e2) {
                    Log::error('Truncate juga gagal: ' . $e2->getMessage());
                    throw new \Exception('Gagal menghapus model lama: ' . $e->getMessage());
               }
          }
     }

     private function validateTrainingData()
     {
          try {
               $validatedCount = TrainingData::where('is_validated', true)->count();
               if ($validatedCount < 3) { // Turunkan requirement untuk testing
                    throw new \Exception("Minimal 3 data training tervalidasi diperlukan (saat ini: {$validatedCount})");
               }

               $categoriesWithData = TrainingData::where('is_validated', true)
                    ->distinct('category_id')
                    ->count('category_id');

               if ($categoriesWithData < 1) { // Turunkan requirement untuk testing
                    throw new \Exception("Minimal 1 kategori harus memiliki data training tervalidasi");
               }

               Log::info("Validasi berhasil: {$validatedCount} data, {$categoriesWithData} kategori");
          } catch (\Exception $e) {
               Log::error('Validation failed: ' . $e->getMessage());
               throw $e;
          }
     }

     private function trainCategoryModelSafe($category, $categoryData)
     {
          try {
               Log::info("Training kategori: {$category->nama}");

               // Kumpulkan semua teks dari kategori ini dengan validasi
               $allTexts = [];
               $processedData = 0;

               foreach ($categoryData as $data) {
                    try {
                         $textParts = [];

                         if (!empty($data->deskripsi) && is_string($data->deskripsi)) {
                              $textParts[] = trim($data->deskripsi);
                         }
                         if (!empty($data->top_notes) && is_string($data->top_notes)) {
                              $textParts[] = trim($data->top_notes);
                         }
                         if (!empty($data->middle_notes) && is_string($data->middle_notes)) {
                              $textParts[] = trim($data->middle_notes);
                         }
                         if (!empty($data->base_notes) && is_string($data->base_notes)) {
                              $textParts[] = trim($data->base_notes);
                         }

                         if (!empty($textParts)) {
                              $allText = implode(' ', $textParts);
                              $preprocessedText = $this->preprocessText($allText);
                              $tokens = $this->tokenize($preprocessedText);

                              if (!empty($tokens)) {
                                   $allTexts = array_merge($allTexts, $tokens);
                                   $processedData++;
                              }
                         }
                    } catch (\Exception $e) {
                         Log::warning("Error processing data item: " . $e->getMessage());
                         continue;
                    }
               }

               if (empty($allTexts)) {
                    throw new \Exception("Tidak ada token yang dihasilkan untuk kategori: {$category->nama}");
               }

               if ($processedData === 0) {
                    throw new \Exception("Tidak ada data yang berhasil diproses untuk kategori: {$category->nama}");
               }

               // Hitung frekuensi kata
               $wordFrequencies = array_count_values($allTexts);
               $totalWords = array_sum($wordFrequencies);
               $vocabularySize = count($wordFrequencies);

               Log::info("Kategori {$category->nama}: {$totalWords} total kata, {$vocabularySize} unique kata dari {$processedData} data");

               if ($totalWords === 0) {
                    throw new \Exception("Total kata adalah 0 untuk kategori: {$category->nama}");
               }

               // Filter dan simpan kata-kata
               $savedWords = 0;
               $batchData = [];

               foreach ($wordFrequencies as $word => $frequency) {
                    if ($this->isValidWord($word, $frequency, $totalWords)) {
                         $probability = ($frequency + 1) / ($totalWords + $vocabularySize);

                         $batchData[] = [
                              'category_id' => (int) $category->id,
                              'kata' => (string) $word,
                              'frekuensi' => (int) $frequency,
                              'probabilitas' => (float) $probability,
                              'created_at' => now()->format('Y-m-d H:i:s'),
                              'updated_at' => now()->format('Y-m-d H:i:s')
                         ];

                         // Insert in smaller batches
                         if (count($batchData) >= 50) {
                              $this->insertBatch($batchData);
                              $savedWords += count($batchData);
                              $batchData = [];
                         }
                    }
               }

               // Insert remaining data
               if (!empty($batchData)) {
                    $this->insertBatch($batchData);
                    $savedWords += count($batchData);
               }

               if ($savedWords === 0) {
                    throw new \Exception("Tidak ada kata yang valid untuk disimpan pada kategori: {$category->nama}");
               }

               Log::info("Selesai training kategori: {$category->nama} dengan {$savedWords} kata");
          } catch (\Exception $e) {
               Log::error("Error training kategori {$category->nama}: " . $e->getMessage());
               throw $e;
          }
     }

     private function isValidWord($word, $frequency, $totalWords)
     {
          return !empty($word) &&
               is_string($word) &&
               strlen($word) >= $this->minWordLength &&
               strlen($word) <= $this->maxWordLength &&
               !in_array(strtolower($word), $this->stopWords) &&
               !is_numeric($word) &&
               $frequency >= 1;
     }

     private function insertBatch($batchData)
     {
          try {
               DB::table('naive_bayes_models')->insert($batchData);
          } catch (\Exception $e) {
               Log::error('Error inserting batch: ' . $e->getMessage());
               // Coba insert satu per satu jika batch gagal
               foreach ($batchData as $data) {
                    try {
                         DB::table('naive_bayes_models')->insert($data);
                    } catch (\Exception $e2) {
                         Log::warning('Skipping invalid data: ' . json_encode($data));
                         continue;
                    }
               }
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

               // Hitung confidence score
               $totalProbability = collect($categoryProbabilities)->sum('probability');
               $confidenceScore = 5; // minimum

               if ($totalProbability > 0) {
                    $confidenceScore = ($bestCategory['probability'] / $totalProbability) * 100;
                    $confidenceScore = min(100, max(5, $confidenceScore));
               }

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
                    'confidence_score' => 5.00,
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
               // Prior probability
               $categoryTrainingCount = TrainingData::where('category_id', $category->id)
                    ->where('is_validated', true)
                    ->count();

               $totalTrainingCount = TrainingData::where('is_validated', true)->count();
               $priorProbability = $totalTrainingCount > 0 ? $categoryTrainingCount / $totalTrainingCount : 0.5;

               // Likelihood
               $categoryWords = NaiveBayesModel::where('category_id', $category->id)
                    ->pluck('probabilitas', 'kata')
                    ->toArray();

               if (empty($categoryWords)) {
                    return $priorProbability * 0.001;
               }

               $likelihood = 1.0;
               $smoothingFactor = 0.001;

               foreach ($tokens as $token) {
                    if (isset($categoryWords[$token])) {
                         $likelihood *= $categoryWords[$token];
                    } else {
                         $likelihood *= $smoothingFactor;
                    }
               }

               return max(0.0001, $priorProbability * $likelihood);
          } catch (\Exception $e) {
               Log::error("Error calculating probability for category {$category->nama}: " . $e->getMessage());
               return 0.0001;
          }
     }

     private function buildTextFromProduct($productData)
     {
          $textParts = [];

          if (isset($productData['deskripsi']) && !empty($productData['deskripsi'])) {
               $textParts[] = (string) $productData['deskripsi'];
          }
          if (isset($productData['top_notes']) && !empty($productData['top_notes'])) {
               $textParts[] = (string) $productData['top_notes'];
          }
          if (isset($productData['middle_notes']) && !empty($productData['middle_notes'])) {
               $textParts[] = (string) $productData['middle_notes'];
          }
          if (isset($productData['base_notes']) && !empty($productData['base_notes'])) {
               $textParts[] = (string) $productData['base_notes'];
          }

          return implode(' ', $textParts);
     }

     private function preprocessText($text)
     {
          $text = (string) $text;
          $text = strtolower($text);
          $text = preg_replace('/\s+/', ' ', $text);
          $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
          $text = preg_replace('/\b\d+\b/', ' ', $text);
          $text = trim(preg_replace('/\s+/', ' ', $text));
          return $text;
     }

     private function tokenize($text)
     {
          $words = explode(' ', $text);
          $words = array_filter($words, function ($word) {
               return !empty($word) &&
                    strlen($word) >= $this->minWordLength &&
                    strlen($word) <= $this->maxWordLength &&
                    !in_array($word, $this->stopWords) &&
                    !is_numeric($word);
          });
          return array_values(array_unique($words));
     }

     public function logClassification($product, $classification)
     {
          try {
               $existingLog = ClassificationLog::where('product_id', $product->id)->first();

               $probabilities = $classification['probabilities'];
               if (is_array($probabilities)) {
                    $probabilities = json_encode($probabilities);
               }

               $logData = [
                    'product_id' => $product->id,
                    'predicted_category_id' => $classification['category_id'],
                    'actual_category_id' => $product->category_id,
                    'confidence_score' => (float) $classification['confidence_score'],
                    'probabilities' => $probabilities,
                    'is_correct' => $classification['category_id'] == $product->category_id,
                    'tokens_analyzed' => $classification['tokens_analyzed'] ?? 0,
                    'text_length' => $classification['text_length'] ?? 0
               ];

               if ($existingLog) {
                    $existingLog->update($logData);
               } else {
                    ClassificationLog::create($logData);
               }
          } catch (\Exception $e) {
               Log::error('Error logging classification: ' . $e->getMessage());
          }
     }

     public function getModelStats()
     {
          try {
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
          } catch (\Exception $e) {
               Log::error('Error getting model stats: ' . $e->getMessage());
               return [
                    'total_words' => 0,
                    'total_categories' => 0,
                    'avg_words_per_category' => 0,
                    'category_stats' => [],
                    'last_trained' => null
               ];
          }
     }

     public function clearCache()
     {
          Cache::forget('naive_bayes_model_stats');
          Cache::forget('naive_bayes_categories');

          $categories = Category::all();
          foreach ($categories as $category) {
               Cache::forget("nb_category_{$category->id}_words");
          }
     }
}
