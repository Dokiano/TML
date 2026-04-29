<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SifatSwotSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now(); // Ambil waktu saat ini

        DB::table('sifat_swots')->insert([
            [
                'isu_swot' => 'Internal',
                'created_at' => $now, 
                'updated_at' => $now, 
            ],
            [
                'isu_swot' => 'Eksternal',
                'created_at' => $now, 
                'updated_at' => $now,
            ]
        ]);
    }

}