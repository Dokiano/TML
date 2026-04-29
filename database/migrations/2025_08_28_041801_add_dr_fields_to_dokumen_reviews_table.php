<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::table('dokumen_reviews', function (Blueprint $t) {
      
      $t->string('dr_no', 20)->nullable()->unique()->after('id'); // contoh: 01/2025
      $t->unsignedSmallInteger('dr_year')->nullable()->index()->after('dr_no');
      $t->unsignedSmallInteger('dr_seq')->nullable()->index()->after('dr_year'); // urutan per tahun
    });
  }

  public function down(): void {
    Schema::table('dokumen_reviews', function (Blueprint $t) {
      $t->dropUnique(['dr_no']);
      $t->dropColumn(['dr_no', 'dr_year', 'dr_seq']);
    });
  }
};
