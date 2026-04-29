<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporan_audits', function (Blueprint $table) {
            $table->date('tgl_ttd_lead')->nullable();
            $table->date('tgl_ttd_auditee')->nullable();
            $table->unsignedInteger('lembar_ke')->nullable();
            $table->string('ttd_lead_path')->nullable();
            $table->string('ttd_auditee_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('laporan_audits', function (Blueprint $table) {
            $table->dropColumn([
                'tgl_ttd_lead',
                'tgl_ttd_auditee',
                'lembar_ke',
                'ttd_lead_path',
                'ttd_auditee_path',
            ]);
        });
    }
};
