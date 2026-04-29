<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void {
        Schema::table('dokumen_reviews', function (Blueprint $table) {
            $table->foreignId('dokumen_id')
                  ->nullable()
                  ->constrained('dokumen')
                  ->cascadeOnUpdate()
                  ->nullOnDelete()
                  ->after('id');
            $table->string('status_review', 20)->default('review')->after('dokumen_id'); 
            $table->date('tanggal_penyelesaian')->nullable(); 
            $table->date('tanggal_diterima_dokumen_kontrol')->nullable(); 
            $table->date('tanggal_terbit')->nullable();
            $table->string('no_revisi')->nullable()->after('keterangan');
             }); 
    } 
        public function down(): void {
        Schema::table('dokumen_reviews', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dokumen_id');
            $table->dropColumn(['status_review', 'tanggal_penyelesaian', 'tanggal_diterima_dokumen_kontrol', 'tanggal_terbit','no_revisi']);
            
        });
    }
 };