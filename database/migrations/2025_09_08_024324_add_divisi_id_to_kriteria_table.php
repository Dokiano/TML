<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('kriteria', function (Blueprint $t) {
      
      $t->foreignId('divisi_id')->nullable()->after('id')
        ->constrained('divisi')->nullOnDelete();

      $t->index(['divisi_id', 'nama_kriteria']);
    });
  }

  public function down(): void {
    Schema::table('kriteria', function (Blueprint $t) {
      $t->dropIndex(['divisi_id', 'nama_kriteria']);
      $t->dropConstrainedForeignId('divisi_id');
    });
  }
};
