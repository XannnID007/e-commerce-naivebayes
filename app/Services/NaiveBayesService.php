<?php

namespace App\Services;

use App\Models\Category;
use App\Models\TrainingData;
use App\Models\NaiveBayesModel;
use App\Models\ClassificationLog;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
          'with'
     ];

     public function trainModel()
     {
          try {
               DB::beginTransaction();

               // Hapus model lama
               NaiveBayesModel::truncate();

               $categories = Category::all();
               $allTrainingData = TrainingData::where('is_validated', true)->get();

               if ($allTrainingData->isEmpty()) {
                    throw new \Exception('Tidak ada data training yang tervalidasi');
               }

               // Hitung prior probability untuk setiap kategori
               $totalData = $allTrainingData->count();
               $categoryPriors = [];

               foreach ($categories as $category) {
                    $categoryData = $allTrainingData->where('category_id', $category->id);
                    $categoryPriors[$category->id] = $categoryData->count() / $totalData;
               }

               // Proses setiap kategori
               foreach ($categories as $category) {
                    $this->trainCategoryModel($category, $allTrainingData);
               }

               DB::commit();
               Log::info('Naive Bayes model berhasil dilatih');
          } catch (\Exception $e) {
               DB::rollback();
               Log::error('Error training Naive Bayes model: ' . $e->getMessage());
               throw $e;
          }
     }

     private function trainCategoryModel($category, $allTrainingData)
     {
          // Ambil data training untuk kategori ini
          $categoryData = $allTrainingData->where('category_id', $category->id);

          if ($categoryData->isEmpty()) {
               return;
          }

          // Kumpulkan semua teks dari kategori ini
          $allTexts = [];
          foreach ($categoryData as $data) {
               $text = $this->preprocessText($data->all_text);
               $tokens = $this->tokenize($text);
               $allTexts = array_merge($allTexts, $tokens);
          }

          // Hitung frekuensi kata
          $wordFrequencies = array_count_values($allTexts);
          $totalWords = array_sum($wordFrequencies);

          // Simpan ke database dengan Laplace smoothing
          foreach ($wordFrequencies as $word => $frequency) {
               // Laplace smoothing: (frequency + 1) / (total_words + vocabulary_size)
               $vocabularySize = count($wordFrequencies);
               $probability = ($frequency + 1) / ($totalWords + $vocabularySize);

               NaiveBayesModel::create([
                    'category_id' => $category->id,
                    'kata' => $word,
                    'frekuensi' => $frequency,
                    'probabilitas' => $probability
               ]);
          }
     }

     public function classify($productData)
     {
          $text = $this->buildTextFromProduct($productData);
          $preprocessedText = $this->preprocessText($text);
          $tokens = $this->tokenize($preprocessedText);

          $categories = Category::all();
          $categoryProbabilities = [];

          foreach ($categories as $category) {
               $probability = $this->calculateCategoryProbability($category, $tokens);
               $categoryProbabilities[$category->id] = [
                    'category' => $category,
                    'probability' => $probability,
                    'log_probability' => log($probability)
               ];
          }

          // Cari kategori dengan probabilitas tertinggi
          $bestCategory = collect($categoryProbabilities)->sortByDesc('probability')->first();

          // Hitung confidence score (konversi ke persentase)
          $totalProbability = collect($categoryProbabilities)->sum('probability');
          $confidenceScore = ($bestCategory['probability'] / $totalProbability) * 100;

          return [
               'category_id' => $bestCategory['category']->id,
               'category_name' => $bestCategory['category']->nama,
               'confidence_score' => round($confidenceScore, 2),
               'probabilities' => $categoryProbabilities
          ];
     }

     private function calculateCategoryProbability($category, $tokens)
     {
          // Prior probability (asumsi uniform untuk semua kategori)
          $priorProbability = 1 / Category::count();

          // Likelihood
          $likelihood = 1.0;

          foreach ($tokens as $token) {
               $wordModel = NaiveBayesModel::where('category_id', $category->id)
                    ->where('kata', $token)
                    ->first();

               if ($wordModel) {
                    $likelihood *= $wordModel->probabilitas;
               } else {
                    // Smoothing untuk kata yang tidak ditemukan
                    $totalWords = NaiveBayesModel::where('category_id', $category->id)->sum('frekuensi');
                    $vocabularySize = NaiveBayesModel::where('category_id', $category->id)->count();

                    if ($totalWords > 0 && $vocabularySize > 0) {
                         $smoothedProbability = 1 / ($totalWords + $vocabularySize);
                         $likelihood *= $smoothedProbability;
                    } else {
                         $likelihood *= 0.001; // Nilai default kecil
                    }
               }
          }

          return $priorProbability * $likelihood;
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

          // Hapus karakter khusus, hanya simpan huruf dan spasi
          $text = preg_replace('/[^a-z\s]/', ' ', $text);

          // Hapus extra spaces
          $text = preg_replace('/\s+/', ' ', $text);

          return trim($text);
     }

     private function tokenize($text)
     {
          $words = explode(' ', $text);

          // Filter stop words dan kata kosong
          $words = array_filter($words, function ($word) {
               return !empty($word) &&
                    strlen($word) > 2 &&
                    !in_array($word, $this->stopWords);
          });

          return array_values($words);
     }

     public function logClassification($product, $classification)
     {
          try {
               ClassificationLog::create([
                    'product_id' => $product->id,
                    'predicted_category_id' => $classification['category_id'],
                    'confidence_score' => $classification['confidence_score'],
                    'probabilities' => $classification['probabilities']
               ]);
          } catch (\Exception $e) {
               Log::error('Error logging classification: ' . $e->getMessage());
          }
     }

     public function evaluateClassification($classificationLog, $actualCategoryId)
     {
          $isCorrect = $classificationLog->predicted_category_id == $actualCategoryId;

          $classificationLog->update([
               'actual_category_id' => $actualCategoryId,
               'is_correct' => $isCorrect
          ]);

          return $isCorrect;
     }

     public function getModelStatistics()
     {
          $stats = [];

          $categories = Category::all();
          foreach ($categories as $category) {
               $wordCount = NaiveBayesModel::where('category_id', $category->id)->count();
               $trainingDataCount = TrainingData::where('category_id', $category->id)
                    ->where('is_validated', true)->count();

               $stats[] = [
                    'category' => $category->nama,
                    'word_count' => $wordCount,
                    'training_data_count' => $trainingDataCount
               ];
          }

          return $stats;
     }

     public function batchClassifyProducts()
     {
          $products = Product::whereNull('category_id')->get();
          $classified = 0;

          foreach ($products as $product) {
               try {
                    $productData = [
                         'deskripsi' => $product->deskripsi,
                         'top_notes' => $product->top_notes,
                         'middle_notes' => $product->middle_notes,
                         'base_notes' => $product->base_notes
                    ];

                    $classification = $this->classify($productData);

                    $product->update([
                         'category_id' => $classification['category_id'],
                         'confidence_score' => $classification['confidence_score']
                    ]);

                    $this->logClassification($product, $classification);
                    $classified++;
               } catch (\Exception $e) {
                    Log::error("Error classifying product {$product->id}: " . $e->getMessage());
               }
          }

          return $classified;
     }

     public function testModel($testSize = 0.2)
     {
          $allData = TrainingData::where('is_validated', true)->get();

          if ($allData->count() < 10) {
               throw new \Exception('Tidak cukup data untuk testing');
          }

          // Split data untuk testing
          $testData = $allData->random(max(1, intval($allData->count() * $testSize)));
          $correct = 0;
          $total = 0;

          foreach ($testData as $data) {
               $productData = [
                    'deskripsi' => $data->deskripsi,
                    'top_notes' => $data->top_notes,
                    'middle_notes' => $data->middle_notes,
                    'base_notes' => $data->base_notes
               ];

               $classification = $this->classify($productData);

               if ($classification['category_id'] == $data->category_id) {
                    $correct++;
               }
               $total++;
          }

          $accuracy = $total > 0 ? ($correct / $total) * 100 : 0;

          return [
               'total_tested' => $total,
               'correct_predictions' => $correct,
               'accuracy' => round($accuracy, 2)
          ];
     }

     public function getTopWordsForCategory($categoryId, $limit = 20)
     {
          return NaiveBayesModel::where('category_id', $categoryId)
               ->orderByDesc('frekuensi')
               ->limit($limit)
               ->get(['kata', 'frekuensi', 'probabilitas']);
     }

     public function exportModel()
     {
          $model = NaiveBayesModel::with('category')->get();

          $exportData = [];
          foreach ($model as $entry) {
               $exportData[] = [
                    'category' => $entry->category->nama,
                    'word' => $entry->kata,
                    'frequency' => $entry->frekuensi,
                    'probability' => $entry->probabilitas
               ];
          }

          return $exportData;
     }

     public function importModel($modelData)
     {
          try {
               DB::beginTransaction();

               NaiveBayesModel::truncate();

               foreach ($modelData as $entry) {
                    $category = Category::where('nama', $entry['category'])->first();

                    if ($category) {
                         NaiveBayesModel::create([
                              'category_id' => $category->id,
                              'kata' => $entry['word'],
                              'frekuensi' => $entry['frequency'],
                              'probabilitas' => $entry['probability']
                         ]);
                    }
               }

               DB::commit();
               return true;
          } catch (\Exception $e) {
               DB::rollback();
               Log::error('Error importing model: ' . $e->getMessage());
               throw $e;
          }
     }
}
