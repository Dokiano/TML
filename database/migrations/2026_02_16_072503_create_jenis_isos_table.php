<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel induk dulu
        Schema::create('jenis_isos', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_iso');
            $table->timestamps();
        });

        // 2. Update tabel riskregister
        Schema::table('riskregister', function (Blueprint $table) {
            // Hapus jika sudah ada (Opsional, tapi aman)
            if (Schema::hasColumn('riskregister', 'jenis_iso_id')) {
                $table->dropForeign(['jenis_iso_id']);
                $table->dropColumn('jenis_iso_id');
            }
        });

        Schema::table('riskregister', function (Blueprint $table) {
            $table->foreignId('jenis_iso_id')
                ->after('id') // Biar rapi posisinya
                ->nullable()
                ->constrained('jenis_isos')
                ->onDelete('set null');
        });

        // 3. Update tabel kriteria
        Schema::table('kriteria', function (Blueprint $table) {
            if (Schema::hasColumn('kriteria', 'jenis_iso_id')) {
                $table->dropForeign(['jenis_iso_id']);
                $table->dropColumn('jenis_iso_id');
            }
        });

        Schema::table('kriteria', function (Blueprint $table) {
            $table->foreignId('jenis_iso_id')
                ->after('id')
                ->nullable()
                ->constrained('jenis_isos')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Hapus foreign key di riskregister
        Schema::table('riskregister', function (Blueprint $table) {
            if (Schema::hasColumn('riskregister', 'jenis_iso_id')) {
                $table->dropForeign(['jenis_iso_id']);
                $table->dropColumn('jenis_iso_id');
            }
        });

        // Hapus foreign key di kriteria (PENTING: Tadi kamu lewatkan ini)
        Schema::table('kriteria', function (Blueprint $table) {
            if (Schema::hasColumn('kriteria', 'jenis_iso_id')) {
                $table->dropForeign(['jenis_iso_id']);
                $table->dropColumn('jenis_iso_id');
            }
        });

        // Terakhir, hapus tabel induk
        Schema::dropIfExists('jenis_isos');
    }
};