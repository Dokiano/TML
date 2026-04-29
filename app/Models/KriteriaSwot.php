<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KriteriaSwot extends Model
{
    protected $table = 'kriteria_swot';
    
    protected $fillable = [
        'swot_id', 
        'kriteria_swot',
        'kode_swot',
    ];

    public function swot()
    {
        return $this->belongsTo(Swot::class, 'swot_id');
    }
}
