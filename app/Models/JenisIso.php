<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Riskregister;
use App\Models\Kriteria;

class JenisIso extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_iso'];

    public function riskregisters()
    {
        return $this->hasMany(Riskregister::class, 'jenis_iso_id');
    }

     public function kriteria()
    {
        return $this->hasMany(Kriteria::class, 'jenis_iso_id');
    }
}

