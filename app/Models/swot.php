<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class swot extends Model
{
    use HasFactory;

    protected $table = 'swots';
    protected $fillable = [
        'jenis_swot',
        'sifat_swot_id'
    ];

    public function kriteria()
    {
        
        return $this->hasMany(KriteriaSwot::class, 'swot_id');
    }
    public function riskregister() 
    {
        return $this->hasMany(Riskregister::class, 'swot_id');
    }


}
