<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'icon',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function trainingData()
    {
        return $this->hasMany(TrainingData::class);
    }

    public function naiveBayesModels()
    {
        return $this->hasMany(NaiveBayesModel::class);
    }

    public function classificationLogs()
    {
        return $this->hasMany(ClassificationLog::class, 'predicted_category_id');
    }

    public function getJumlahProdukAttribute()
    {
        return $this->products()->where('aktif', true)->count();
    }
}
