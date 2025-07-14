<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'predicted_category_id',
        'actual_category_id',
        'confidence_score',
        'probabilities',
        'is_correct'
    ];

    protected $casts = [
        'confidence_score' => 'decimal:2',
        'probabilities' => 'array',
        'is_correct' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function predictedCategory()
    {
        return $this->belongsTo(Category::class, 'predicted_category_id');
    }

    public function actualCategory()
    {
        return $this->belongsTo(Category::class, 'actual_category_id');
    }

    public function getAccuracyColorAttribute()
    {
        if (is_null($this->is_correct)) {
            return 'text-gray-500';
        }

        return $this->is_correct ? 'text-green-600' : 'text-red-600';
    }

    public function getConfidenceLevelAttribute()
    {
        if ($this->confidence_score >= 80) {
            return ['label' => 'Tinggi', 'color' => 'green'];
        } elseif ($this->confidence_score >= 60) {
            return ['label' => 'Sedang', 'color' => 'yellow'];
        } else {
            return ['label' => 'Rendah', 'color' => 'red'];
        }
    }
}
