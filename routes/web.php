<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnotationImageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenApprovalController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DokumenFileController;
use App\Http\Controllers\DokumenReviewController;
use App\Http\Controllers\DokumenStatusController;
use App\Http\Controllers\DraftMasterlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisIsoController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LaporanAuditController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PdfAnnotationController;
use App\Http\Controllers\PpkController;
use App\Http\Controllers\RealisasiController;
use App\Http\Controllers\ResikoController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\RiskRegisterController;
use App\Http\Controllers\StatusPpkController;
use App\Http\Controllers\SwotController;
use App\Http\Controllers\UserController;
use App\Models\JenisIso;
use Illuminate\Support\Facades\Route;

//Dashboard PIECHART
Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Home HomeController
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/riskregister/filter', [HomeController::class, 'getFilteredData'])->name('riskregister.filter')->middleware('auth');

// login regist
Route::post('/register-act', [UserController::class, 'register_action'])->name('register.action');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');
Route::get('password', [UserController::class, 'password'])->name('password')->middleware('auth');
Route::post('password', [UserController::class, 'password_action'])->name('password.action')->middleware('auth');
Route::get('logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        // Export to Excel
        // Admin kelola user
        Route::get('/kelolaakun', [AdminController::class, 'index'])->name('admin.kelolaakun');
        Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/divisi', [AdminController::class, 'divisi'])->name('admin.divisi');
        Route::get('/admin/divisi/create', [AdminController::class, 'createDivisi'])->name('admin.divisi.create');
        Route::post('/admin/divisi/store', [AdminController::class, 'storeDivisi'])->name('admin.divisi.store');
        // Route untuk Edit Divisi
        Route::get('/admin/divisi/{id}/edit', [AdminController::class, 'editDivisi'])->name('admin.divisi.edit');
        Route::put('/admin/divisi/{id}', [AdminController::class, 'updateDivisi'])->name('admin.divisi.update');
        // Route untuk Hapus Divisi
        Route::delete('/admin/divisi/{id}', [AdminController::class, 'destroyDivisi'])->name('admin.divisi.destroy');

        // Kriteria
        Route::get('/kriteria', [KriteriaController::class, 'index'])->name('admin.kriteria');
        Route::get('/kriteriacreate', [KriteriaController::class, 'create'])->name('admin.kriteriacreate');
        Route::post('/kriteriacreate', [KriteriaController::class, 'store'])->name('admin.kriteriastore');
        Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('admin.kriteriaedit');
        Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('admin.kriteria.update');
        Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('admin.kriteriadestroy');

        //SWOT
        Route::get('/swotcreate', [SwotController::class, 'index'])->name('admin.swotcreate');
        Route::get('/admin/swot/create', [SwotController::class, 'create'])->name('swot.create');
        Route::post('/admin/swot', [SwotController::class, 'store'])->name('swot.store');
        Route::get('/admin/kriteria-swot/create', [SwotController::class, 'createKriteriaSwot'])->name('kriteriaSwot.create');
        Route::post('/admin/kriteria-swot', [SwotController::class, 'storeKriteriaSwot'])->name('kriteriaSwot.store');
        Route::get('/admin/kriteria-swot', [SwotController::class, 'indexKriteriaSwot'])->name('kriteriaSwot.index');
        //Dokumen
        Route::get('/dokumen',           [DokumenController::class, 'index'])->name('dokumen.index');
        Route::get('/dokumen/create',    [DokumenController::class, 'create'])->name('dokumen.create');
        Route::post('/dokumen',          [DokumenController::class, 'store'])->name('dokumen.store');
        Route::get('/dokumen/{id}/edit', [DokumenController::class, 'edit'])->name('dokumen.edit');
        Route::put('/dokumen/{id}',      [DokumenController::class, 'update'])->name('dokumen.update');
        Route::delete('/dokumen/{id}',   [DokumenController::class, 'destroy'])->name('dokumen.destroy');

        //ISO
        Route::get('/admin/iso', [JenisIsoController::class, 'index'])->name('iso.index');
        Route::get('/admin/iso/create', [JenisIsoController::class, 'create'])->name('iso.create');
        Route::post('/admin/iso', [JenisIsoController::class, 'store'])->name('iso.store');

    });

    // Risk
    Route::middleware(['checkrole:admin,manager,manajemen,supervisor'])->group(function () {
        Route::get('/bigrisk', [RiskController::class, 'biglist'])->name('riskregister.biglist');
        Route::get('/bigrisk-iso37001', [RiskController::class, 'biglistIso37001'])->name('riskregister.biglist.iso');
    });
    Route::middleware(['checkrole:admin,manager,manajemen,supervisor'])->group(function () {
        Route::get('/riskregister/create/{id}', [RiskController::class, 'create'])->name('riskregister.create');
        // create iso37001
        Route::get('/riskregister/create-iso37001/{id}',[RiskController::class, 'createIso37001'])->name('riskregister.create.iso');

        Route::get('/riskregister/{id}/edit', [RiskController::class, 'edit'])->name('riskregister.edit');
        Route::get('/riskregister/edit-iso37001/{id}', [RiskController::class, 'editIso37001'])->name('riskregister.edit.iso');
        
        Route::post('/riskregister/store', [RiskController::class, 'store'])->name('riskregister.store');
        Route::put('/riskregister/update/{id}', [RiskController::class, 'update'])->name('riskregister.update');
        Route::get('/riskregister/preview/{id}', [RiskController::class, 'preview'])->name('riskregister.preview');
        Route::get('/riskregister/printAll/{id}', [RiskController::class, 'printAll'])->name('riskregister.printAll');
        Route::get('/riskregister/export/{id}', [RiskController::class, 'exportExcel'])->name('riskregister.exportExcel');
        Route::get('/riskregister/export-filtered/{id}', [RiskController::class, 'exportFilteredExcel'])->name('riskregister.exportFilteredExcel');
        Route::get('/export-pdf/{id}', [RiskController::class, 'exportFilteredPDF'])->name('riskregister.export-pdf');
        Route::get('/riskregister/export-excel', [RiskController::class, 'exportFilteredExcel'])->name('riskregister.export-excel');
        Route::delete('/riskregister/{id}', [RiskController::class, 'destroy'])->name('riskregister.destroy');
        Route::patch('riskregister/{id}/archive', [RiskController::class, 'archive'])->name('riskregister.archive');
        Route::patch('riskregister/{id}/unarchive', [RiskController::class, 'unarchive'])->name('riskregister.unarchive'); 
    });
    Route::get('/riskregister', [RiskController::class, 'index'])->name('riskregister.index');
    // Pilih ISO
    Route::get('/pilih-iso/{id}', [RiskController::class, 'pilihISO'])->name('riskregister.pilihISO');
    Route::get('/riskregister/{id}', [RiskController::class, 'tablerisk'])->name('riskregister.tablerisk');
    Route::patch('/editresk/inex/{id}', [RiskController::class, 'updateData'])->name('riskregister.updateData');
    Route::patch('/riskregister/update-issue/{id}', [RiskController::class, 'updateIssue'])->name('riskregister.updateissue');
    Route::patch('/riskregister/update-resiko/{id}', [RiskController::class, 'updateResiko'])->name('riskregister.updateresiko');
    Route::patch('/riskregister/update-peluang/{id}', [RiskController::class, 'updatePeluang'])->name('riskregister.updatepeluang');
    Route::patch('/riskregister/update-before/{id}', [RiskController::class, 'updateBefore'])->name('riskregister.updatebefore');
    Route::patch('/riskregister/update-after/{id}', [RiskController::class, 'updateAfter'])->name('riskregister.updateafter');
    Route::patch('/riskregister/update-date/{id}', [RiskController::class, 'updateDate'])->name('riskregister.updatedate');
    Route::patch('/riskregister/update-pihak/{id}', [RiskController::class, 'updatePihak'])->name('riskregister.updatepihak');
    Route::patch('/riskregister/update-inline/{id}', [RiskController::class, 'updateInline'])->name('riskregister.update_inline');
    Route::patch('/riskregister/update-aktifitas/{id}', [RiskController::class, 'updateAktifitas'])->name('riskregister.updateaktifitas');
    Route::get('/riskregister/get-kriteria-swot', [RiskController::class, 'getKriteriaBySwotId'])->name('riskregister.getKriteriaSwot');
    Route::get('/riskregister-iso37001/{id}', [RiskController::class, 'tableriskIso37001'])->name('riskregister.tablerisk.iso37001');
    Route::patch('/riskregister/{id}/review-at', [RiskController::class, 'updateReviewAt'])->name('riskregister.update-review-at');





    // Resiko
    Route::middleware('manager', 'manajemen', 'supervisor', 'admin')->group(function () {
        Route::get('/resiko/{id}', [ResikoController::class, 'index'])->name('resiko.index');
        Route::get('/resiko/create/{id}', [ResikoController::class, 'create'])->name('resiko.create');
        Route::post('/resiko/store', [ResikoController::class, 'store'])->name('resiko.store');
        Route::get('/resiko/{id}/edit', [ResikoController::class, 'edit'])->name('resiko.edit');
        Route::post('/resiko/{id}/update', [ResikoController::class, 'update'])->name('resiko.update');
        Route::get('/resiko/matriks/{id}', [ResikoController::class, 'matriks'])->name('resiko.matriks');
        Route::get('/resiko/matriks2/{id}', [ResikoController::class, 'matriks2'])->name('resiko.matriks2');
        Route::get('/matriks-risiko/{id}', [ResikoController::class, 'show'])->name('matriks-risiko.show');
    });

    // Realisasi
    Route::middleware('auth')->group(function () {
        Route::get('/realisasi/{id}', [RealisasiController::class, 'index'])->name('realisasi.index');
        Route::get('/realisasi/{id}/edit', [RealisasiController::class, 'edit'])->name('realisasi.edit');
        Route::post('/realisasi/store', [RealisasiController::class, 'store'])->name('realisasi.store');
        Route::put('/realisasi/{id}/update', [RealisasiController::class, 'update'])->name('realisasi.update');
        Route::delete('/realisasi/{id}/destroy', [RealisasiController::class, 'destroy'])->name('realisasi.destroy');
        Route::get('/realisasi/{id}/detail', [RealisasiController::class, 'getDetail'])->name('realisasi.detail');
        Route::patch(
            '/realisasi/update-status/{id}',
            [RealisasiController::class, 'updateStatusByTindakan']
        )->name('realisasi.updateStatusByTindakan');
        Route::patch(
            '/realisasi/{riskregisterId}/batch-update',
            [RealisasiController::class, 'updateBatch']
        )->name('realisasi.updateBatch');
    });

    // Route kelompok dengan middleware 'manager' dan 'manajemen'
    // Route::middleware(['manager', 'manajemen'])->group(function () {

    // -- PPK Routes --
    Route::get('/ppk', [PpkController::class, 'dashboardPPK'])->name('ppk.dashboardPPK');
    Route::get('/ppk-IA', [PpkController::class, 'indexppk2'])->name('ppk.indexppk2');
    Route::get('/ppk-MFG', [PpkController::class, 'index'])->name('ppk.index');
    Route::get('/formppk', [PpkController::class, 'create'])->name('ppk.create');
    Route::get('/formppk2', [PpkController::class, 'createIA'])->name('ppk.createIA');
    Route::post('/form/store', [PpkController::class, 'store'])->name('ppk.store');
    Route::post('/form/storeIA', [PpkController::class, 'storeIA'])->name('ppk.storeIA');
    Route::get('/formidentifikasi/{id}', [PpkController::class, 'create2'])->name('ppk.create2');
    Route::post('/ppk/store-2', [PpkController::class, 'store2'])->name('ppk.store2');
    Route::get('/formusulan/{id}', [PpkController::class, 'create3'])->name('ppk.create3');
    Route::post('/ppk/store-3', [PpkController::class, 'store3'])->name('ppk.store3');
    Route::get('/ppk/export/{id}', [PpkController::class, 'exportSingle'])->name('ppk.export');
    Route::get('/kirimemail', [PpkController::class, 'email'])->name('ppk.email');
    Route::post('/ppk/send-email/{ppk}', [PpkController::class, 'kirimEmailVerifikasi'])->name('ppk.kirimEmailVerifikasi');
    Route::get('/ppk/{id}/detail', [PpkController::class, 'detail'])->name('ppk.detail');
    Route::get('/ppk/{id}/edit', [PpkController::class, 'edit'])->name('ppk.edit');
    Route::get('/ppk/{id}/edit2', [PpkController::class, 'edit2'])->name('ppk.edit2');
    Route::get('/ppk/{id}/editUsulan', [PpkController::class, 'editUsulan'])->name('ppk.editUsulan');
    Route::get('/ppk/{id}/edit3', [PpkController::class, 'edit3'])->name('ppk.edit3');
    Route::put('/ppk/{id}/update', [PpkController::class, 'update'])->name('ppk.update');
    Route::put('/ppk/{id}/update2', [PpkController::class, 'update2'])->name('ppk.update2');
    Route::put('/ppk/{id}/update3', [PpkController::class, 'update3'])->name('ppk.update3');
    Route::get('/ppk/{id}/view', [PpkController::class, 'view'])->name('ppk.view');
    Route::get('/ppk/{id}/pdf', [PpkController::class, 'generatePdf'])->name('ppk.pdf');
    Route::get('/ppk/accept/{id}', [PpkController::class, 'accept'])->name('ppk.accept');
    Route::get('/adminppk', [PpkController::class, 'index2'])->name('ppk.index2');
    Route::get('ppk/exportexcelPPK', [PpkController::class, 'export'])->name('ppk.export');
    Route::delete('/admin/ppk/{id}', [PpkController::class, 'destroy'])->name('ppk.destroy');
    Route::patch('/admin/ppk/{id}', [PpkController::class, 'updateStatus'])->name('ppk.updatestatus');
    Route::get('/ppk/createLa', [LaporanAuditController::class, 'createLa'])->name('ppk.createLa');
    Route::get('/laporan', [LaporanAuditController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanAuditController::class, 'show'])->name('laporan.view');
    Route::post('/laporan', [LaporanAuditController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{laporan}', [LaporanAuditController::class, 'show'])->name('laporan.show');
    Route::put('/laporan/{laporan}', [LaporanAuditController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{laporan}', [LaporanAuditController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/evidence/{evidence}', [\App\Http\Controllers\LaporanAuditController::class, 'showEvidence'])->name('evidence.show');
    Route::post('/laporan/{laporanAudit}/signatures', [LaporanAuditController::class, 'storeSignatures'])->name('laporan.signatures');
    Route::get('/storage/signatures/{filename}', [LaporanAuditController::class, 'showSignature'])->name('signature.show');
    // });
    // STATUS PPK
    Route::get('statusppk', [StatusPpkController::class, 'index'])->name('admin.statusppk');
    Route::post('statusppk', [StatusPpkController::class, 'store'])->name('admin.statusppk.store');
    Route::put('statusppk/{id}', [StatusPpkController::class, 'update'])->name('statusppk.update');
    Route::delete('statusppk/{id}', [StatusPpkController::class, 'destroy'])->name('statusppk.destroy');

    // Notification
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

//Master List Dokumen
Route::get('/dokumen/dashboard', [DokumenController::class, 'dashboardDok'])->name('dok.dashboard');
Route::get('/dokumen/masterlist/ckr', [DokumenController::class, 'masterListCKR'])->name('dok.master.ckr');
Route::get('/dokumen/masterlist/sdg', [DokumenController::class, 'masterListSDG'])->name('dok.master.sdg');
Route::get('/dokumen/masterlist/ho', [DokumenController::class, 'masterListHO'])->name('dok.master.ho');
Route::get('/dokumen/masterlist/ckr/divisi/{id}', [DokumenController::class, 'masterListDivisi'])->name('dok.master.ckr.divisi');
Route::get('/dokumen/masterlist/sdg/divisi/{id}', [DokumenController::class, 'masterListDivisi'])->name('dok.master.sdg.divisi');
Route::get('/dokumen/masterlist/ho/divisi/{id}', [DokumenController::class, 'masterListDivisi'])->name('dok.master.ho.divisi');
Route::get('/dokumen/draft-masterlist/divisi/{id}', [DokumenController::class, 'draftmasterListDivisi'])->name('dok.draft.master.divisi');
Route::get('/dokumen-review/masterlist', [DokumenReviewController::class, 'masterListDR'])->name('dokumenReview.masterListDR');
Route::get('/dokumen-review/{dr}/stream-final', [DokumenReviewController::class, 'streamFinal'])->name('dokumenReview.streamFinal'); 
Route::post('/dokumen/draft-masterlist/divisi/{id}', [DraftMasterlistController::class, 'store'])->name('dok.draft.master.divisi.store');
// Pengajuan Dokumen
Route::get('/dokumen/pengajuan/next-nomor', [DokumenReviewController::class, 'getNextNomor'])->name('dokumen.pengajuan.nextNomor');
Route::get('/dokumen/pengajuan/revisi/{dr}', [DokumenReviewController::class, 'pengajuanRevisi'])->name('dokumen.pengajuan.revisi');
Route::get('/dokumen/pengajuan', [DokumenController::class, 'pengajuanDok']) ->name('dokumen.pengajuan');
Route::post('/dokumen/pengajuan', [DokumenReviewController::class, 'store'])->name('dokumen.pengajuan.store');
Route::get('/dokumen-review/{dr}/edit',   [DokumenReviewController::class, 'edit'])->name('dokumenReview.edit');
Route::patch('/dokumen-review/{dr}',      [DokumenReviewController::class, 'update'])->name('dokumenReview.update');
// Dokumen Review
Route::get('/dokumen-review', [DokumenReviewController::class, 'index'])->name('dokumenReview.index');
Route::get('/dokumen-review/{dr}', [DokumenReviewController::class, 'show'])->name('dokumenReview.show');
Route::get('/dokumen-review/{dr}/file', [DokumenReviewController::class, 'streamDraft'])->name('dokumenReview.draft');
Route::get('/dokumen-review/{dr}/review', [DokumenReviewController::class, 'create'])->name('dokumenReview.create');
Route::put('/dokumen-review/{dr}/tanggal', [DokumenReviewController::class, 'updateTanggal'])->name('dokumenReview.updateTanggal');
//Draft Dokumen review yang ingin di masukan ke masterlist dokumen review
Route::get('/dokumen-review/{dr}/draft-detail',[DokumenReviewController::class, 'draftDetail'])->name('dokumenReview.draftDetail');
Route::post('/dokumen-review/{dr}/publish', [DokumenReviewController::class, 'publishDokumen'])->name('dokumenReview.publish');
Route::get('/dokumen-review/{dr}/export-pdf', [DokumenReviewController::class, 'exportPdf'])->name('dokumenReview.exportPdf');
//route dokumen masukan ke masterlist
Route::post('/dokumen-review/{dr}/publishDokumenDivisi',[DokumenReviewController::class, 'publishDokumenDivisi'])->name('dokumenReview.publishDokumenDivisi');
Route::delete('/dokumen-review/{dr}', [DokumenReviewController::class, 'destroy'])->name('dokumenReview.destroy');
//Pdf Annotation
// Halaman viewer + anotasi PDF.js
Route::get('/dokumen-review/{dr}/annotate', [DokumenReviewController::class, 'annotate'])->name('dokumenReview.annotate');
// Endpoint untuk stream PDF (dipakai PDF.js)
Route::get('/dokumen-review/{dr}/pdf', [DokumenReviewController::class, 'pdf'])->name('dokumenReview.pdf');
// API Anotasi (CRUD)
Route::get   ('/dokumen-review/{dr}/annotations', [PdfAnnotationController::class, 'index'])->name('annotations.index');
Route::post  ('/dokumen-review/{dr}/annotations', [PdfAnnotationController::class, 'store'])->name('annotations.store');
Route::put   ('/dokumen-review/{dr}/annotations/{ann}', [PdfAnnotationController::class, 'update'])->name('annotations.update');
Route::delete('/dokumen-review/{dr}/annotations/{ann}', [PdfAnnotationController::class, 'destroy'])->name('annotations.destroy');
// API Gambar Anotasi
Route::get   ('/dokumen-review/{dr}/annotations/{ann}/images',       [AnnotationImageController::class, 'index'])  ->name('annotation.images.index');
Route::post  ('/dokumen-review/{dr}/annotations/{ann}/images',       [AnnotationImageController::class, 'store'])  ->name('annotation.images.store');
Route::delete('/dokumen-review/{dr}/annotations/{ann}/images/{img}', [AnnotationImageController::class, 'destroy'])->name('annotation.images.destroy');
Route::get('/annotation-images/{img}', [AnnotationImageController::class, 'stream'])->name('annotation.images.stream')->middleware('auth');
//Dokumen final user
Route::post('/dokumen-review/{dr}/files', [DokumenFileController::class, 'store'])->name('dokumenFiles.store');
Route::get ('/dokumen-review/{dr}/files', [DokumenFileController::class, 'index'])->name('dokumenFiles.index');
Route::delete('/dokumen-files/{file}', [DokumenFileController::class, 'destroy'])->name('dokumenFiles.destroy');
//Dokumen final admin
Route::post('/dokumen-review/{dr}/file-final',[App\Http\Controllers\DokumenReviewController::class, 'uploadFileFinal'])->name('dokumenReview.uploadFileFinal'); 
// Stream / preview file_final_dr
Route::get('/dokumen-review/{dr}/file-final/stream',[App\Http\Controllers\DokumenReviewController::class, 'streamFileFinal'])->name('dokumenReview.streamFileFinal');
// Hapus file_final_dr (hanya admin)
Route::delete('/dokumen-review/{dr}/file-final',[App\Http\Controllers\DokumenReviewController::class, 'destroyFileFinal'])->name('dokumenReview.destroyFileFinal');
// Preview inline per file (tanpa annotate)
Route::get('/dokumen-files/{file}/preview', [DokumenFileController::class, 'preview'])->name('dokumenFiles.preview');
Route::get('/dokumen-file/view/{file}', [DokumenFileController::class, 'stream'])->name('dokumenFile.stream');
Route::get('/dokumen-review/files/{file}/viewer', [DokumenFileController::class, 'viewer'])->name('dokumenFiles.viewer');
Route::patch('/dokumen-review/{dr}/status',[DokumenStatusController::class, 'update'])->name('dokumenStatus.update');
Route::post('/dokumen-review/{dr}/approvals',[DokumenApprovalController::class, 'store'])->name('approvals.store');
Route::get('/approvals/{approval}/signature',[DokumenApprovalController::class, 'signature'])->name('approvals.signature');
Route::put('/approvals/{approval}', [DokumenApprovalController::class,'update'])->name('approvals.update');
// export excel
Route::get('dokumen/draft-divisi/{id}/export-excel',[DokumenController::class, 'exportExcelDraftDivisi'])->name('dokumen.exportExcelDraftDivisi');

});
