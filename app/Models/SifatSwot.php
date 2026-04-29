<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SifatSwot extends Model
{
    use HasFactory;

    protected $table = 'sifat_swots';

    protected $fillable = [
        'isu_swot'
    ];

    // Relasi ke tabel swots (One to Many)
    public function swots()
    {
        return $this->hasMany(Swot::class, 'sifat_swot_id');
    }

    // Atau relasi ke kriteria_swot kalau langsung
    public function kriteriaSwots()
    {
        return $this->hasMany(KriteriaSwot::class, 'sifat_swot_id');
    }
}