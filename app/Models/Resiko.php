<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resiko extends Model
{
    use HasFactory;

    protected $table = 'resiko'; // Nama tabel yang digunakan

    protected $fillable = [
        'id_riskregister',
        'nama_resiko',
        'kriteria',
        'probability',
        'severity',
        'tingkatan',
        'status',
        'risk',
        'probabilityrisk',
        'severityrisk',
        'before',
        'after',
    ];

    public function calculateTingkatan()
    {
        if ($this->probability && $this->severity) {
            $score = $this->probability * $this->severity;
    
            // Cek apakah ISO 37001
            $isISO37001 = optional($this->riskregister)->jenis_iso_id == 2;
    
            if ($isISO37001) {
                // Skala ISO 37001
                if ($score >= 1 && $score <= 3) {
                    $this->tingkatan = 'LOW';
                } elseif ($score >= 4 && $score <= 12) {
                    $this->tingkatan = 'MEDIUM';
                } elseif ($score >= 13 && $score <= 25) {
                    $this->tingkatan = 'HIGH';
                }
            } elseif (in_array($this->kriteria, ['Reputasi', 'Kinerja', 'Operational', 'Financial'])) {
                $this->tingkatan = $this->calculateNewCategories();
            } else {
                // Skala ISO lainnya (ISO 9001 dll)
                if ($score >= 1 && $score <= 2) {
                    $this->tingkatan = 'LOW';
                } elseif ($score >= 3 && $score <= 4) {
                    $this->tingkatan = 'MEDIUM';
                } elseif ($score >= 5 && $score <= 25) {
                    $this->tingkatan = 'HIGH';
                }
            }
        }
    }
    
    public function calculateRisk()
    {
        if ($this->probabilityrisk && $this->severityrisk) {
            $scorerisk = $this->probabilityrisk * $this->severityrisk;

            // Cek apakah ISO 37001
            $isISO37001 = optional($this->riskregister)->jenis_iso_id == 2;

            if ($isISO37001) {
                if ($scorerisk >= 1 && $scorerisk <= 3) {
                    $this->risk = 'LOW';
                } elseif ($scorerisk >= 4 && $scorerisk <= 12) {
                    $this->risk = 'MEDIUM';
                } elseif ($scorerisk >= 13 && $scorerisk <= 25) {
                    $this->risk = 'HIGH';
                }
            } elseif (in_array($this->kriteria, ['Reputasi', 'Kinerja', 'Operational', 'Financial'])) {
                $this->risk = $this->calculateRiskNew();  // ← jadikan return value
            } else {
                // ISO 9001 & lainnya
                if ($scorerisk >= 1 && $scorerisk <= 3) {
                    $this->risk = 'LOW';
                } elseif ($scorerisk == 4) {
                    $this->risk = 'MEDIUM';
                } elseif ($scorerisk >= 5 && $scorerisk <= 25) {
                    $this->risk = 'HIGH';
                }
            }
        }
    }

    public function calculateNewCategories()
    {
        // Menggunakan severity dan probability untuk menghitung kategori baru
        if ($this->probability && $this->severity) {
            $score = $this->probability * $this->severity;

            if ($score >= 1 && $score <= 2) {
                return 'LOW'; // Kategori Low
            } elseif ($score >= 2 && $score < 5) {
                return 'MEDIUM'; // Kategori Medium
            } elseif ($score > 4 && $score <= 21) {
                return 'HIGH'; // Kategori High
            }
        }

        return null; // Jika tidak ada kategori yang cocok
    }

   public function calculateRiskNew()
    {
        if ($this->probabilityrisk && $this->severityrisk) {
            $scorerisk = $this->probabilityrisk * $this->severityrisk;
    
            if ($scorerisk >= 1 && $scorerisk <= 2) {
                return 'LOW';
            } elseif ($scorerisk >= 2 && $scorerisk < 5) {
                return 'MEDIUM';
            } elseif ($scorerisk > 4 && $scorerisk <= 21) {
                return 'HIGH';
            }
        }
        return null;
    }

    public function riskregister()
    {
        return $this->belongsTo(Riskregister::class, 'id_riskregister', 'id');
    }
    
}
