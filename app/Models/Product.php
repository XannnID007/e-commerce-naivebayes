<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'konsentrasi',
        'top_notes',
        'middle_notes',
        'base_notes',
        'gambar',
        'stok',
        'category_id',
        'confidence_score',
        'aktif'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'confidence_score' => 'decimal:2',
        'aktif' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function classificationLogs()
    {
        return $this->hasMany(ClassificationLog::class);
    }

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            // Perbaikan: gunakan asset() dengan storage path yang benar
            return asset('storage/' . $this->gambar);
        }
        return asset('images/default-perfume.jpg');
    }

    public function getKonsentrasiLabelAttribute()
    {
        $labels = [
            'EDC' => 'Eau de Cologne',
            'EDT' => 'Eau de Toilette',
            'EDP' => 'Eau de Parfum'
        ];

        return $labels[$this->konsentrasi] ?? $this->konsentrasi;
    }

    public function getAllNotesAttribute()
    {
        $notes = array_filter([
            $this->top_notes,
            $this->middle_notes,
            $this->base_notes
        ]);

        return implode(', ', $notes);
    }

    public function scopeAktif(Builder $query)
    {
        return $query->where('aktif', true);
    }

    public function scopeByCategory(Builder $query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch(Builder $query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhere('top_notes', 'like', "%{$search}%")
                ->orWhere('middle_notes', 'like', "%{$search}%")
                ->orWhere('base_notes', 'like', "%{$search}%");
        });
    }
}
