<?php

namespace App\Http\Controllers;

use App\Models\Swot;
use App\Models\KriteriaSwot;
use App\Models\Resiko;
use App\Models\Divisi;
use App\Models\SifatSwot;
use Illuminate\Http\Request;

class SwotController extends Controller
{
    public function index(Request $request)
    {
        $sifatSwots = SifatSwot::all();
        return view('admin.swotcreate', compact('sifatSwots'));
    }

    public function create()
    {
        $sifatSwots = SifatSwot::all();
        return view('admin.swot.create', compact('sifatSwots'));
    }
    

    public function store(Request $request)
    {
        
        $request->validate([
            'jenis_swot' => 'required|string|max:255',
            'sifat_swot_id' => 'required|exists:sifat_swots,id'
        ]);
        try {
            Swot::create([
                'jenis_swot' => $request->jenis_swot,
                'sifat_swot_id' => $request->sifat_swot_id,
            ]);
            return redirect()->route('swot.index')->with('success', 'Jenis SWOT berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan Jenis SWOT: ' . $e->getMessage());
        }
    }
    
    public function indexKriteriaSwot()
    {
        
        $kriteriaSwots = KriteriaSwot::with('swot')->get(); 

        // Perubahan: Mengarahkan ke admin.kriteriaSwot (sesuai file Anda)
        return view('admin.kriteriaSwot', compact('kriteriaSwots')); 
    }

    public function storeKriteriaSwot(Request $request)
    {

        $request->validate([
            'swot_id' => 'required|exists:swots,id', 
            'kriteria_swot' => 'required|string',
        ]);

        $swotId = $request->swot_id;
        $masterSwot = Swot::findOrFail($swotId);
        $jenisSwot = $masterSwot->jenis_swot; 

        // Tentukan Prefix Kode (S, W, O, T)
        // Gunakan huruf pertama sebagai prefix
        $prefix = strtoupper(substr($jenisSwot, 0, 1)); 

        $prefixMap = [
        'strength opportunity' => 'SO',       //ganti jadi strength opportunity dengan code SO 1 dst
        'strength threat' => 'ST',          //ganti jadi strength threat dengan code ST 1 dst
        'weakness opportunity' => 'WO',       //ganti jadi weakness threat dengan code WT 1 dst
        'weakness threat' => 'WT',            //ganti jadi weakness opportunity dengan code WO 1 dst
          ];
        $key = strtolower($jenisSwot);
        $prefix = $prefixMap[$key] ?? strtoupper(substr($jenisSwot, 0, 1));    

        $lastKriteriaSwot = KriteriaSwot::where('swot_id', $swotId)
                                    ->orderBy('id', 'desc')
                                    ->first();

      
        $nextNumber = 1;
        if ($lastKriteriaSwot) {
            $parts = explode('-', $lastKriteriaSwot->kode_swot);
            $lastNumber = end($parts);
            if (is_numeric($lastNumber)) {
                $nextNumber = $lastNumber + 1;
            }
        }
        $kodeSwot = $prefix . '-' . $nextNumber;

        KriteriaSwot::create([
            'swot_id' => $swotId, 
            'kriteria_swot' => $request->kriteria_swot,
            'kode_swot' => $kodeSwot,
            
        ]);
        return redirect()->route('kriteriaSwot.index')->with('success', 'Kriteria SWOT ' . $kodeSwot . ' berhasil ditambahkan!');
    }

    public function createKriteriaSwot()
    {
        $swots = Swot::all(); 
        $kriteriaSwots = KriteriaSwot::with('swot')->get();
        return view('admin.kriteriaSwotcreate', compact('swots'));
    }
 }
