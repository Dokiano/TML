<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Temuan extends Model
{
    protected $fillable = ['laporan_id','deskripsi','referensi','status','order_index'];
    public function laporan()   { return $this->belongsTo(LaporanAudit::class, 'laporan_id'); }
    public function evidences() { return $this->hasMany(TemuanEvidence::class, 'temuan_id'); }
}
