<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen_approvals', function (Blueprint $t) {
            $t->id();
            $t->foreignId('dokumen_review_id')
              ->constrained('dokumen_reviews')
              ->cascadeOnDelete();
            $t->foreignId('user_id')
              ->constrained('user')   
              ->cascadeOnDelete();
              
            $t->enum('kind', ['main','support','reviewer']);
            $t->enum('action', ['approved','rejected']);

         
            $t->string('signature_path')->nullable();   // file gambar yang disimpan
            $t->string('signature_source')->nullable(); // 'upload' | 'canvas'
            $t->text('comment')->nullable();
            $t->timestamp('signed_at')->nullable();

            $t->timestamps();
            $t->index(['dokumen_review_id', 'kind']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_approvals');
    }
};
