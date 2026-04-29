<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen_statuses', function (Blueprint $t) {
            $t->id();

            
            $t->foreignId('dokumen_review_id')
              ->unique()
              ->constrained('dokumen_reviews')
              ->cascadeOnDelete();

            // status manual (default awal: masih review)
            $t->boolean('is_review')->default(true);
            $t->boolean('is_revisi')->default(false);
            $t->boolean('is_final')->default(false);
            $t->boolean('is_approved')->default(false);

            $t->foreignId('updated_by')
              ->nullable()
              ->constrained('user')
              ->nullOnDelete();

            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_statuses');
    }
};
