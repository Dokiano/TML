<?php

namespace App\Http\Controllers;

use App\Models\JenisIso;
use Illuminate\Http\Request;

class JenisIsoController extends Controller
{
    public function index(Request $request)
    {
        $jenisIso = JenisIso::all();
        return view('admin.create', compact('jenisIso'));
    }

    public function create()
    {
        $jenisIso = JenisIso::all();
        return view('admin.isocreate', compact('jenisIso'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'jenis_iso' => 'required|string|max:255',
        ]);
    
        try {
            JenisIso::create([
                'jenis_iso' => $request->jenis_iso,
            ]);
    
            return redirect()->route('iso.create')
                             ->with('success', 'Jenis ISO berhasil ditambahkan!');
    
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menambahkan Jenis ISO: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
