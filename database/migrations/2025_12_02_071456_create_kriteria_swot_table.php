<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria_swot', function (Blueprint $table) {
            $table->id();
            
            // Kolom Foreign Key yang merujuk ke tabel swots
            $table->foreignId('swot_id')
                  ->constrained('swots') 
                  ->onDelete('cascade'); 
            $table->text('kriteria_swot');   
           
            $table->string('kode_swot')->unique(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriteria_swot');
    }
};