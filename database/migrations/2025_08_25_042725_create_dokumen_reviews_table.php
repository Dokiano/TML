<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {    
    public function up(): void
    {
        Schema::create('dokumen_reviews', function (Blueprint $t) {
            $t->id();

            // mirror dari form pengajuan
            $t->foreignId('pembuat_id')->constrained('user')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('pembuat2_id')->nullable()->constrained('user')->cascadeOnUpdate()->restrictOnDelete(); // User yang mengajukan nomor DR
            $t->foreignId('approver_main_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('restrict');
            $t->foreignId('divisi_id')->constrained('divisi')->cascadeOnUpdate()->restrictOnDelete();
            $t->string('jabatan', 30);
            $t->string('nama_jenis', 100);
            $t->string('nama_dokumen', 200);
            $t->string('nomor_dokumen', 100)->nullable();
            $t->string('keterangan', 200)->nullable();
            $t->text('alasan_revisi')->nullable();

            // opsional: siapa yang boleh melihat selain pembuat
            $t->json('reviewer_ids')->nullable();
            $t->json('approver_support_ids')->nullable();
            
            // file
            $t->string('draft_path');
            $t->string('pdf_path', 255)->nullable(); 
            
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_reviews');
    }
};