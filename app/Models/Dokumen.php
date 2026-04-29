<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';          // pakai tabel 'dokumen'
    protected $fillable = ['nama_jenis','divisi_id'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

   public function scopeForUserDivisiNama($q, $user)
    {
        $nama = $user->divisi ?? null;        // kolom string 'divisi' di tabel user
        if ($nama) {
            $q->whereHas('divisi', fn($d) => $d->where('nama_divisi', $nama));
        }
        return $q;
    }

}
