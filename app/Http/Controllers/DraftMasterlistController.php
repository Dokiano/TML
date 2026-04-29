<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DraftMasterlistDivisi;

class DraftMasterlistController extends Controller
{
    public function store(Request $request, $id)
    {
        
        foreach ($request->rows as $row) {
            if (!empty($row['no_dokumen']) || !empty($row['nama_dokumen'])) {
                DraftMasterlistDivisi::create([
                    'divisi_id'      => $id,
                    'proses'         => $request->proses ?? null,
                    'pemilik_proses' => $request->pemilik_proses ?? null,
                    'nama_jenis'     => $row['nama_jenis'] ?? null,
                    'no_dokumen'     => $row['no_dokumen'] ?? null,
                    'nama_dokumen'   => $row['nama_dokumen'] ?? null,
                    'no_revisi'      => $row['no_revisi'] ?? null,
                    'tanggal'        => $row['tanggal'] ?? null,
                    'status'         => $row['status'] ?? null,
                ]);
            }
        }

        return back()->with('success', 'Data draft masterlist berhasil disimpan!');
    }
}
