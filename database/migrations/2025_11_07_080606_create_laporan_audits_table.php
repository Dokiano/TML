<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_audits', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->unique(); 
            $table->foreignId('lead_auditor_id')       
                  ->nullable()->constrained('user')->nullOnDelete();
            $table->json('auditor_ids')->nullable();   
            $table->json('auditee_ids')->nullable();    
            $table->foreignId('divisi_id')->constrained('divisi'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_audits');
    }
};
