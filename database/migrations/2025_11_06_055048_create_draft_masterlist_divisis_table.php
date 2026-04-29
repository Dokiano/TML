<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('draft_masterlist_divisis', function (Blueprint $t) {
            $t->id();

            $t->unsignedBigInteger('divisi_id');                    
            $t->string('proses')->nullable();
            $t->string('pemilik_proses')->nullable();
            $t->string('nama_jenis', 100);
            $t->string('no_dokumen', 150)->nullable();
            $t->string('nama_dokumen')->nullable();
            $t->unsignedInteger('no_revisi')->nullable(); 
            $t->date('tanggal')->nullable();
            $t->string('status', 50)->nullable();
            $t->timestamps();
            // Index yang sering dipakai
            $t->index(['divisi_id']);
            $t->index(['no_dokumen']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('draft_masterlist_divisis');
    }
};
