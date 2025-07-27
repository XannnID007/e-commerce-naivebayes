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
               Log::info('Memulai training model Naive Bayes...');

               DB::beginTransaction();

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

               // Cek apakah ada data untuk setiap kategori
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

               DB::commit();
               Log::info('Training model berhasil diselesaikan');
          } catch (\Exception $e) {
               DB::rollback();
               Log::error('Error training Naive Bayes model: ' . $e->getMessage());
               Log::error('Stack trace: ' . $e->getTraceAsString());
               throw $e;
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

               // Simpan ke database dengan Laplace smoothing
               foreach ($wordFrequencies as $word => $frequency) {
                    if (strlen($word) > 2) { // Hanya simpan kata yang panjangnya > 2 karakter
                         $probability = ($frequency + 1) / ($totalWords + $vocabularySize);

                         NaiveBayesModel::create([
                              'category_id' => $category->id,
                              'kata' => $word,
                              'frekuensi' => $frequency,
                              'probabilitas' => $probability
                         ]);
                    }
               }

               Log::info("Selesai training kategori: {$category->nama}");
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

               if (!$bestCategory) {
                    throw new \Exception('Tidak dapat menentukan kategori terbaik');
               }

               // Hitung confidence score (konversi ke persentase)
               $totalProbability = collect($categoryProbabilities)->sum('probability');
               $confidenceScore = $totalProbability > 0 ? ($bestCategory['probability'] / $totalProbability) * 100 : 0;

               return [
                    'category_id' => $bestCategory['category']->id,
                    'category_name' => $bestCategory['category']->nama,
                    'confidence_score' => round($confidenceScore, 2),
                    'probabilities' => $categoryProbabilities
               ];
          } catch (\Exception $e) {
               Log::error('Error dalam klasifikasi: ' . $e->getMessage());

               // Return kategori default jika error
               $defaultCategory = Category::first();
               return [
                    'category_id' => $defaultCategory->id,
                    'category_name' => $defaultCategory->nama,
                    'confidence_score' => 0,
                    'probabilities' => []
               ];
          }
     }

     private function calculateCategoryProbability($category, $tokens)
     {
          // Prior probability (uniform untuk semua kategori)
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
}
