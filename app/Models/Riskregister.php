<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\swot;
use App\Models\KriteriaSwot;
use App\Models\JenisIso;

class Riskregister extends Model
{
    use HasFactory;

    protected $table = 'riskregister';
    protected $fillable = [
        'id_divisi',
        'jenis_iso_id',
        'issue',
        'aktifitas_kunci',
        'target_penyelesaian',
        'peluang',
        'pihak',
        'keterangan',
        'inex',
        'updated_at',
        'swot_id',
        'kategori_swot',
        'kriteria_swot',
        'is_archived',

    ];

    protected $casts = [
        'keterangan' => 'array',
        'is_archived' => 'boolean',
    ];

    // Relasi ke model Divisi
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'id'); // Menggunakan 'id_divisi' untuk foreign key
    }

    // Relasi ke model Tindakan
    public function tindakan()
    {
        return $this->hasMany(Tindakan::class, 'id_riskregister', 'id'); // Menggunakan 'id_riskregister' sebagai foreign key
    }

    // Relasi ke model Resiko
    public function resikos() // Mengubah menjadi 'resikos' sesuai penamaan dalam model
    {
        return $this->hasMany(Resiko::class, 'id_riskregister', 'id'); // Menggunakan 'id_riskregister' untuk foreign key
    }
    public function realisasi()
    {
        return $this->hasOne(Realisasi::class);
    }
    public function tindakans()
    {
        return $this->hasMany(Tindakan::class, 'id_riskregister');
    }

    public function swot()
    {   
        return $this->belongsTo(Swot::class, 'swot_id');
    }
     public function KriteriaSwot()
    {   
        return $this->belongsTo(Swot::class, 'kriteria_swot',);
    }
        public function getKodeSwotAttribute()
    {
        return KriteriaSwot::where(
            'kriteria_swot',
            $this->kriteria_swot
        )->value('kode_swot');
    }

    public function getKodeSwotFullAttribute()
    {
        // 1. Ambil kode_swot (gunakan null-safe operator atau check)
        $kriteria = \App\Models\KriteriaSwot::where('kriteria_swot', $this->kriteria_swot)->first();
        $kodeSwot = $kriteria ? $kriteria->kode_swot : 'KODE';
    
        // 2. Mapping 'inex' (Internal/External)
        // Jika null (saat Create), default ke INTERNAL atau string kosong
        $labelIsu = 'INTERNAL'; 
        if ($this->inex === 'E') {
            $labelIsu = 'EKSTERNAL';
        }
    
        // 3. Tahun
        $tahun = $this->created_at ? $this->created_at->format('Y') : date('Y');
    
        return trim("{$kodeSwot}/{$labelIsu}/{$tahun}");
    }

    public function jenisIso()
    {
        return $this->belongsTo(JenisIso::class, 'jenis_iso_id');
    }
    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

}
