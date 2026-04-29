<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis', 100);
            $table->foreignId('divisi_id')
                  ->constrained('divisi')       
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();         
            $table->timestamps();

            
            $table->unique(['nama_jenis', 'divisi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
