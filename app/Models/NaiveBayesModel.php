<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaiveBayesModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'kata',
        'frekuensi',
        'probabilitas'
    ];

    protected $casts = [
        'probabilitas' => 'decimal:8'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function updateModelForCategory($categoryId)
    {
        // Hitung total kata untuk kategori ini
        $totalWords = self::where('category_id', $categoryId)->sum('frekuensi');

        if ($totalWords > 0) {
            // Update probabilitas untuk semua kata dalam kategori
            self::where('category_id', $categoryId)->chunk(100, function ($models) use ($totalWords) {
                foreach ($models as $model) {
                    $model->update([
                        'probabilitas' => $model->frekuensi / $totalWords
                    ]);
                }
            });
        }
    }
}
