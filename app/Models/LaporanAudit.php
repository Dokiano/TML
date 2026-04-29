<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LaporanAudit extends Model
{
    protected $fillable = [
        'nomor_dokumen', 'lead_auditor_id', 'auditor_ids', 'auditee_ids', 'divisi_id','tgl_ttd_lead','tgl_ttd_auditee',
        'lembar_ke','ttd_lead_path','ttd_auditee_path',
    ];
    protected $table = 'laporan_audits';
    protected $casts = [
        'auditor_ids' => 'array',
        'auditee_ids' => 'array',
    ];
    
    public function leadAuditor() { return $this->belongsTo(\App\Models\User::class, 'lead_auditor_id', 'id');}
    public function divisi(){return $this->belongsTo(\App\Models\Divisi::class, 'divisi_id', 'id');}
    public function temuan(){return $this->hasMany(\App\Models\Temuan::class, 'laporan_id', 'id');} 
}
