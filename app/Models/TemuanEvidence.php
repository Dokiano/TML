<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TemuanEvidence extends Model
{
    protected $fillable = ['temuan_id','file_path','mime_type','desc','order_index'];
    protected $table = 'temuan_evidences';
    public function temuan() { return $this->belongsTo(Temuan::class, 'temuan_id'); }
}
