<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('riskregister', function (Blueprint $table) {
            $table->text('aktifitas_kunci')->nullable()->after('issue'); 
        });
    }
    public function down(): void {
        Schema::table('riskregister', function (Blueprint $table) {
            $table->dropColumn('aktifitas_kunci');
        });
    }
};
