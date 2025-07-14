<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingData extends Model
{
    use HasFactory;

    protected $fillable = [
        'deskripsi',
        'top_notes',
        'middle_notes',
        'base_notes',
        'category_id',
        'is_validated'
    ];

    protected $casts = [
        'is_validated' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getAllTextAttribute()
    {
        $texts = array_filter([
            $this->deskripsi,
            $this->top_notes,
            $this->middle_notes,
            $this->base_notes
        ]);

        return implode(' ', $texts);
    }

    public function getTokensAttribute()
    {
        $text = strtolower($this->all_text);
        // Hapus karakter khusus dan split menjadi kata-kata
        $text = preg_replace('/[^a-z\s]/', '', $text);
        return array_filter(explode(' ', $text));
    }
}
