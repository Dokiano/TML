<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('dokumen_files', function (Blueprint $t) {
      $t->id();
      $t->foreignId('dokumen_review_id')->constrained('dokumen_reviews')->cascadeOnDelete();
      $t->enum('type', ['final','revisi_final']);
      $t->string('path');                    // storage path (disk: local)
      $t->string('original_name');           // nama file asli
      $t->string('mime', 100);               // harus application/pdf
      $t->unsignedBigInteger('size');        
      $t->text('note')->nullable();          
      $t->foreignId('uploaded_by')->constrained('user')->cascadeOnDelete();
      $t->timestamps();

      $t->index(['dokumen_review_id','type']);
      $t->index('uploaded_by');
    });
  }

  public function down(): void {
    Schema::dropIfExists('dokumen_files');
  }
};
