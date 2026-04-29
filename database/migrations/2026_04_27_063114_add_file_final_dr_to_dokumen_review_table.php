<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dokumen_reviews', function (Blueprint $table) {
            // Menambahkan kolom file_final_dr setelah kolom draft_path
            $table->string('file_final_dr')->nullable()->after('draft_path');
        });
    }

    public function down()
    {
        Schema::table('dokumen_reviews', function (Blueprint $table) {
            $table->dropColumn('file_final_dr');
        });
    }
};
