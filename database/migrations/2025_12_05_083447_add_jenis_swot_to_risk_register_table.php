<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('riskregister', function (Blueprint $table) {

            if (Schema::hasColumn('riskregister', 'swots_id')) {
                 $table->dropForeign(['swots_id']);
                 $table->dropColumn('swots_id');
            }

            if (Schema::hasColumn('riskregister', 'kriteria_swot_id')) {
                $table->dropForeign(['kriteria_swot_id']); 
                $table->dropColumn('kriteria_swot_id');
            }
            
            if (Schema::hasColumn('riskregister', 'kriteria_swot')) {
                $table->dropColumn('kriteria_swot');
            }
            $table->foreignId('swot_id')
                ->nullable()
                ->constrained('swots')
                ->onDelete('set null');

            $table->text('kriteria_swot')->nullable();
            $table->string('kategori_swot')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('riskregister', function (Blueprint $table) {
            
            $table->dropForeign(['swot_id']);
            $table->dropColumn('swot_id');
            $table->dropColumn('kriteria_swot'); 
            $table->dropColumn('kategori_swot'); 
            
        });
    }
};