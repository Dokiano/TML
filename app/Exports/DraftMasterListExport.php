<?php

namespace App\Exports;

use App\Models\DokumenReview;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class DraftMasterListExport implements WithEvents, WithTitle
{
    protected $divisi;
    protected $activeJenis;

    public function __construct($divisi, $activeJenis = 'ALL')
    {
        $this->divisi      = $divisi;
        $this->activeJenis = $activeJenis;
    }

    public function title(): string
    {
        return substr($this->divisi->nama_divisi, 0, 31); // max 31 char untuk sheet name
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                /// mengambil dokumen dengan nama jenis sama
                $query = DokumenReview::where(function($q) {
                    $q->where('divisi_id', $this->divisi->id)
                      ->orWhereIn('nama_jenis', function($sub) {
                          $sub->select('nama_jenis')
                              ->from('dokumen')
                              ->where('divisi_id', $this->divisi->id);
                      });
                });
                if ($this->activeJenis !== 'ALL') {
                    $query->where('nama_jenis', $this->activeJenis);
                }
                $nomorList = $query->distinct()->pluck('nomor_dokumen')->filter()->sort()->values();

                // ── 2. Untuk setiap nomor, ambil SEMUA revisinya ─────────
                $grouped = [];
                foreach ($nomorList as $nomor) {
                    $revisis = DokumenReview::where('nomor_dokumen', $nomor)
                        ->orderBy('no_revisi')
                        ->get(['nama_dokumen', 'no_revisi', 'tanggal_terbit', 'status_review']);
                    $grouped[$nomor] = $revisis;
                }

                // ── 3. Hitung kolom revisi maksimum (min 10) ─────────────
                $maxRevisi = 9; // index 0–9 = 10 kolom
                foreach ($grouped as $revisis) {
                    foreach ($revisis as $r) {
                        $idx = (int) $r->no_revisi;
                        if ($idx > $maxRevisi) $maxRevisi = $idx;
                    }
                }
                $totalRevisiCols = $maxRevisi + 1; // jumlah kolom revisi

                // ── 4. Definisi kolom ─────────────────────────────────────
                // A=No, B=No.Dokumen, C=Nama Dokumen, D...(D+totalRevisiCols-1)=revisi, last=Status
                $colNo        = 1; // A
                $colNoDok     = 2; // B
                $colNama      = 3; // C
                $colRevStart  = 4; // D
                $colRevEnd    = $colRevStart + $totalRevisiCols - 1;
                $colStatus    = $colRevEnd + 1;

                $lastColLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colStatus);

                // ── 5. Baris 1: Judul ─────────────────────────────────────
                // LOGO
                $sheet->mergeCells('A1:B1');
                $sheet->getStyle('A1:B1')->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Perusahaan');
                $drawing->setPath(public_path('admin/img/logobg-ic.png')); // path kamu
                $drawing->setHeight(60); // atur tinggi biar pas row 50
                $drawing->setCoordinates('B1'); // posisi di B1
                $drawing->setOffsetX(30); // geser dikit biar tengah
                $drawing->setOffsetY(1);
                $drawing->setWorksheet($sheet);

                // JUDUL (C1:J1)
                $sheet->mergeCells('C1:J1');
                $sheet->setCellValue('C1', 'DOKUMEN MASTERLIST');
                $sheet->getStyle('C1:J1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 20, 'name' => 'Arial'],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER
                    ],
                     'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // KODE DOKUMEN (K1:N1)
                $sheet->mergeCells('K1:N1');
                $sheet->setCellValue('K1', 'FM.IM.10'); // bisa dinamis
                $sheet->getStyle('K1:N1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER
                    ],
                     'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Tinggi row tetap
                $sheet->getRowDimension(1)->setRowHeight(50);

                // Kode form kanan atas — taruh di kolom status baris 1
                $sheet->setCellValueByColumnAndRow($colStatus, 1, 'FM.IM.01.00');
                $sheet->getStyleByColumnAndRow($colStatus, 1)->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 11, 'name' => 'Arial'],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                ]);

                // ── 6. Baris 2–3: Proses & Pemilik Proses (kosong) ────────
                $sheet->mergeCells('A2:' . $lastColLetter . '2');
                $sheet->setCellValue('A2', 'Proses : ');
                $sheet->mergeCells('A3:' . $lastColLetter . '3');
                $sheet->setCellValue('A3', 'Pemilik Proses : ');
                foreach ([2, 3] as $r) {
                    $range = 'A' . $r . ':' . $lastColLetter . $r;

                    $sheet->getStyle($range)->applyFromArray([
                        'font' => ['name' => 'Arial', 'size' => 10],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => Border::BORDER_MEDIUM,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);
                    $sheet->getRowDimension($r)->setRowHeight(18);
                }

                // ── 7. Baris 4: Kosong (spacer) ───────────────────────────
                $sheet->getRowDimension(4)->setRowHeight(8);

                // ── 8. Baris 5: Header gabungan "Status Revisi dan Tanggal" ─
    
                $revStartLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colRevStart);
                $revEndLetter   = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colRevEnd);

                // Set Nilai Header
                $sheet->setCellValue('A5', 'No');
                $sheet->setCellValue('B5', "No.\nDokumen"); // Pakai \n agar bisa pindah baris
                $sheet->setCellValue('C5', 'Nama Dokumen');
                $sheet->setCellValue($lastColLetter . '5', 'Status');

                // Definisikan Style Header Utama (Border All + Alignment Center)
                $headerStyle = [
                    'font' => ['bold' => true, 'name' => 'Arial', 'size' => 10],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true, // PENTING: Agar No. Dokumen tidak terpotong
                    ],
                    'borders' => [
                        'allBorders' => [ // PENTING: Pakai allBorders agar garis dalam muncul
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                        'outline' => [ // Tetap pakai outline medium agar bingkai luar tegas
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ];

                // 1. Terapkan style ke kolom statis yang di-merge vertikal
                $sheet->mergeCells('A5:A6'); // No
                $sheet->mergeCells('B5:B6'); // No.Dokumen
                $sheet->mergeCells('C5:C6'); // Nama Dokumen
                $sheet->mergeCells($lastColLetter . '5:' . $lastColLetter . '6'); // Status

                $sheet->getStyle('A5:C6')->applyFromArray($headerStyle);
                $sheet->getStyle($lastColLetter . '5:' . $lastColLetter . '6')->applyFromArray($headerStyle);

                // 2. Buat header gabungan "Status Revisi dan Tanggal"
                $sheet->mergeCells($revStartLetter . '5:' . $revEndLetter . '5');
                $sheet->setCellValueByColumnAndRow($colRevStart, 5, 'Status Revisi dan Tanggal');
                $sheet->getStyle($revStartLetter . '5:' . $revEndLetter . '5')->applyFromArray($headerStyle);

                // Tambahkan warna fill khusus untuk header revisi
                $sheet->getStyle($revStartLetter . '5:' . $revEndLetter . '5')->getFill()->applyFromArray([
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFD9E1F2']
                ]);

                // ── 9. Baris 6: Angka Kolom Revisi (0, 1, 2, dst) ─────────────────────
                for ($i = 0; $i < $totalRevisiCols; $i++) {
                    $col = $colRevStart + $i;
                    $sheet->setCellValueByColumnAndRow($col, 6, (string)$i);
                    // Terapkan style ke setiap angka agar garis vertikalnya muncul
                    $sheet->getStyleByColumnAndRow($col, 6)->applyFromArray($headerStyle);
                }

                // Atur tinggi row agar proporsional
                $sheet->getRowDimension(5)->setRowHeight(25);
                $sheet->getRowDimension(6)->setRowHeight(20);

                // ── 10. Baris data ────────────────────────────────────────
                $dataRow = 7;
                $no      = 1;
                foreach ($grouped as $nomor => $revisis) {
                    $namaDoc = optional($revisis->first())->nama_dokumen ?? '-';

                    // Map no_revisi → tanggal_terbit
                    $tanggalMap = [];
                    foreach ($revisis as $rev) {
                        $idx = (int) $rev->no_revisi;
                        $tanggalMap[$idx] = $rev->tanggal_terbit
                            ? \Carbon\Carbon::parse($rev->tanggal_terbit)->format('d/m/y')
                            : '';
                    }

                    // Warna baris selang-seling
                    $rowBg = ($no % 2 === 0) ? 'FFF2F7FF' : 'FFFFFFFF';

                    $sheet->setCellValueByColumnAndRow($colNo, $dataRow, $no);
                    $sheet->setCellValueByColumnAndRow($colNoDok, $dataRow, $nomor);
                    $sheet->setCellValueByColumnAndRow($colNama, $dataRow, $namaDoc);
                    $sheet->setCellValueByColumnAndRow($colStatus, $dataRow, 'Done');

                    for ($i = 0; $i < $totalRevisiCols; $i++) {
                        $val = $tanggalMap[$i] ?? '';
                        $sheet->setCellValueByColumnAndRow($colRevStart + $i, $dataRow, $val);
                        $sheet->getStyleByColumnAndRow($colRevStart + $i, $dataRow)->applyFromArray([
                            'font'      => ['name' => 'Arial', 'size' => 9],
                            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                            'fill'      => ['fillType' => Fill::FILL_SOLID,
                                            'startColor' => ['argb' => $rowBg]],
                        ]);
                    }

                    // Style kolom tetap
                    foreach ([$colNo, $colNoDok, $colNama, $colStatus] as $col) {
                        $sheet->getStyleByColumnAndRow($col, $dataRow)->applyFromArray([
                            'font'      => ['name' => 'Arial', 'size' => 9],
                            'alignment' => [
                                'horizontal' => $col === $colNama
                                    ? Alignment::HORIZONTAL_LEFT
                                    : Alignment::HORIZONTAL_CENTER,
                                'vertical' => Alignment::VERTICAL_CENTER,
                            ],
                            'fill' => ['fillType' => Fill::FILL_SOLID,
                                       'startColor' => ['argb' => $rowBg]],
                        ]);
                    }

                    $sheet->getRowDimension($dataRow)->setRowHeight(16);
                    $dataRow++;
                    $no++;
                }

                // ── 11. Border seluruh tabel ──────────────────────────────
                $lastDataRow = $dataRow - 1;

                if ($lastDataRow >= 7) { // Mulai dari baris 7 agar tidak menimpa style header (baris 5-6)
                    $sheet->getStyle('A7:' . $lastColLetter . $lastDataRow)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color'       => ['argb' => 'FF000000'], // Gunakan 8 karakter (FF + Hex)
                            ],
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                'color'       => ['argb' => 'FF000000'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                    ]);
                }

                // ── 12. Lebar kolom ───────────────────────────────────────
                $sheet->getColumnDimensionByColumn($colNo)->setWidth(5);
                $sheet->getColumnDimensionByColumn($colNoDok)->setWidth(15);
                $sheet->getColumnDimensionByColumn($colNama)->setWidth(45);
                $sheet->getColumnDimensionByColumn($colStatus)->setWidth(10);
                for ($i = 0; $i < $totalRevisiCols; $i++) {
                    $sheet->getColumnDimensionByColumn($colRevStart + $i)->setWidth(11);
                }

                // ── 13. Freeze pane setelah header ────────────────────────
                
            },
        ];
    }
}