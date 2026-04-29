<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('temuans', function (Blueprint $table) {
            $table->id();


            $table->foreignId('laporan_id')->constrained('laporan_audits')->cascadeOnDelete();

            $table->text('deskripsi');           // textarea Uraian Temuan 
            $table->text('referensi')->nullable(); // textarea Referensi
            $table->string('status');            // select status 
            $table->unsignedInteger('order_index')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temuans');
    }
};
