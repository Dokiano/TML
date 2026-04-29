<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('pdf_annotations', function (Blueprint $t) {
      $t->id();
      $t->foreignId('dokumen_review_id')->constrained('dokumen_reviews')->cascadeOnDelete();
      $t->foreignId('user_id')->constrained('user')->cascadeOnDelete();
      $t->unsignedInteger('page')->index();                 // halaman (1-based)
      $t->string('type');                          // 'point','highlight','strikeout','area','textbox', dll
      $t->json('rect')->nullable();                // {x,y,width,height} dalam koordinat PDF.js viewport
      $t->json('data')->nullable();                // payload bebas (teks komentar, warna, dsb.)
      $t->timestamps();
      $t->index(['dokumen_review_id','page']);
    });
  }
  public function down(): void {
    Schema::dropIfExists('pdf_annotations');
  }
};
