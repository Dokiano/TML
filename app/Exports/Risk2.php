<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Risk2 implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $formattedData;
    protected $counter = 1;

    public function __construct($formattedData)
    {
        $this->formattedData = $formattedData;
    }

    public function collection()
    {
        return collect($this->formattedData);
    }

    public function headings(): array
    {
        return [
            [
                'IDENTIFIKASI, PENILAIAN, DAN PENGENDALIAN RISIKO PENYUAPAN',
                '', '', '', '', '', '', '', '', '', '', '', '', '', '',
            ],
            [
                'No', 'Bagian', 'Nama Proses', 'Aktifitas Kunci',
                'Potensi Risk Penyuapan', 'Skema Penyuapan / Modus Operandi',
                '*S', '*P', 'Level',
                'Tindakan Terhadap Risiko', '',
                'Sisa Risiko', '', '',
                'Rencana Tindakan / Mitigasi',
            ],
            [
                '', '', '', '', '', '', '', '', '',
                'Tindakan', 'Acuan',
                '*S', '*P', 'Level', '',
            ],
        ];
    }

    public function map($row): array
    {
        $tindak_lanjut = is_array($row['tindak_lanjut']) ? $row['tindak_lanjut'] : [$row['tindak_lanjut']];
        $acuans        = is_array($row['acuan'] ?? null)  ? $row['acuan']         : [($row['acuan'] ?? null)];

        $mappedRows = [];
        $maxRows    = max(count($tindak_lanjut), count($acuans));

        for ($i = 0; $i < $maxRows; $i++) {
            $mappedRows[] = [
                $i === 0 ? $this->counter++                                      : '',
                $i === 0 ? ($row['bagian'] ?? '')                                : '',
                $i === 0 ? $row['issue']                                         : '',
                $i === 0 ? ($row['aktifitas_kunci'] ?? '')                       : '',
                $i === 0 ? $row['risiko']                                        : '',
                $i === 0 ? $row['before']                                        : '',
                $i === 0 ? $row['severity']                                      : '',
                $i === 0 ? $row['probability']                                   : '',
                $i === 0 ? $row['scores']                                        : '',
                $tindak_lanjut[$i] ?? '',
                $acuans[$i] ?? '',
                $i === 0 ? $row['severityrisk']                                  : '',
                $i === 0 ? $row['probabilityrisk']                               : '',
                $i === 0 ? ($row['severityrisk'] * $row['probabilityrisk'])      : '',
                $i === 0 ? $row['after']                                         : '',
            ];
        }

        return $mappedRows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ===== LOGO DI A1 =====
                $logoPath = public_path('admin/img/tatalogamgroup.png');
                if (file_exists($logoPath)) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath($logoPath);
                    $drawing->setHeight(45);
                    $drawing->setCoordinates('A1');
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(3);
                    $drawing->setWorksheet($sheet);
                }

                // ===== HITUNG RESUME =====
                $resumeBefore = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];
                $resumeAfter  = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];

                foreach ($this->formattedData as $item) {
                    $levelBefore = strtoupper($item['tingkatan'] ?? '');
                    if (isset($resumeBefore[$levelBefore])) {
                        $resumeBefore[$levelBefore]++;
                    }

                    $levelAfter = strtoupper($item['risk'] ?? '');
                    if (!isset($resumeAfter[$levelAfter]) || $levelAfter === '') {
                        $levelAfter = $levelBefore;
                    }
                    if (isset($resumeAfter[$levelAfter])) {
                        $resumeAfter[$levelAfter]++;
                    }
                }

                $totalBefore = array_sum($resumeBefore);
                $totalAfter  = array_sum($resumeAfter);

                // ===== RESUME — mulai 2 baris setelah data, hanya sampai kolom G (setengah tabel) =====
                $lastRow  = $sheet->getHighestRow();
                $startRow = $lastRow + 2;

                // Judul resume
                $sheet->mergeCells("A{$startRow}:E{$startRow}");
                $sheet->setCellValue("A{$startRow}", 'Ringkasan Kriteria Level Risiko');
                $sheet->getStyle("A{$startRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 10],
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_LEFT, 'vertical' => StyleAlignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension($startRow)->setRowHeight(20);

                // Header tabel resume
                $headerRow = $startRow + 1;
                $sheet->setCellValue("A{$headerRow}", 'No');
                $sheet->setCellValue("B{$headerRow}", 'Kriteria Level Risiko');
                $sheet->setCellValue("C{$headerRow}", 'Kriteria Level Risiko'); // dummy untuk merge
                $sheet->mergeCells("B{$headerRow}:C{$headerRow}");
                $sheet->setCellValue("D{$headerRow}", 'Jumlah Risk (Awal)');
                $sheet->setCellValue("E{$headerRow}", 'Setelah Mitigasi');

                $sheet->getStyle("A{$headerRow}:E{$headerRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 9],
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_CENTER, 'vertical' => StyleAlignment::VERTICAL_CENTER, 'wrapText' => true],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'A6F119']],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(20);

                // Data resume
                $resumeRows = [
                    1 => ['label' => 'Risiko Rendah (1 - 3)',     'color' => '92D050', 'fontColor' => '000000', 'key' => 'LOW'],
                    2 => ['label' => 'Risiko Sedang (> 3 - 12)',  'color' => 'FFFF00', 'fontColor' => '000000', 'key' => 'MEDIUM'],
                    3 => ['label' => 'Risiko Tinggi (> 12 - 25)', 'color' => 'FF0000', 'fontColor' => 'FFFFFF', 'key' => 'HIGH'],
                ];

                foreach ($resumeRows as $no => $resumeItem) {
                    $row = $headerRow + $no;

                    $sheet->setCellValue("A{$row}", $no);
                    $sheet->mergeCells("B{$row}:C{$row}");
                    $sheet->setCellValue("B{$row}", $resumeItem['label']);
                    $sheet->setCellValue("D{$row}", $resumeBefore[$resumeItem['key']]);
                    $sheet->setCellValue("E{$row}", $resumeAfter[$resumeItem['key']]);

                    $sheet->getStyle("A{$row}:E{$row}")->applyFromArray([
                        'alignment' => ['vertical' => StyleAlignment::VERTICAL_CENTER],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                        'font'      => ['size' => 9],
                    ]);
                    $sheet->getStyle("B{$row}:C{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $resumeItem['color']]],
                        'font' => ['bold' => true, 'color' => ['rgb' => $resumeItem['fontColor']]],
                        'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_CENTER],
                    ]);
                    $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("D{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("E{$row}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
                    $sheet->getRowDimension($row)->setRowHeight(18);
                }

                // Baris total
                $totalRow = $headerRow + 4;
                $sheet->mergeCells("A{$totalRow}:C{$totalRow}");
                $sheet->setCellValue("A{$totalRow}", 'Total');
                $sheet->setCellValue("D{$totalRow}", $totalBefore);
                $sheet->setCellValue("E{$totalRow}", $totalAfter);

                $sheet->getStyle("A{$totalRow}:E{$totalRow}")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 9],
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_CENTER, 'vertical' => StyleAlignment::VERTICAL_CENTER],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_RIGHT);
                $sheet->getRowDimension($totalRow)->setRowHeight(18);

                // Catatan kaki
                $noteRow = $totalRow + 1;
                $sheet->mergeCells("A{$noteRow}:E{$noteRow}");
                $sheet->setCellValue("A{$noteRow}", '* Risiko yang belum memiliki data Sisa Risiko (After) dihitung berdasarkan nilai awal (Before).');
                $sheet->getStyle("A{$noteRow}")->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 8, 'color' => ['rgb' => '666666']],
                    'alignment' => ['horizontal' => StyleAlignment::HORIZONTAL_LEFT],
                ]);
            },
        ];
    }


    public function styles(Worksheet $sheet)
    {
        // ===== COLUMN WIDTHS =====
        $columnWidths = [
            'A' => 5,   // No
            'B' => 20,  // Bagian
            'C' => 25,  // Nama Proses
            'D' => 25,  // Aktifitas Kunci
            'E' => 25,  // Potensi Risk Penyuapan
            'F' => 35,  // Skema Penyuapan / Modus Operandi
            'G' => 5,   // *S
            'H' => 5,   // *P
            'I' => 7,   // Level
            'J' => 30,  // Tindakan
            'K' => 20,  // Acuan
            'L' => 5,   // *S (sisa)
            'M' => 5,   // *P (sisa)
            'N' => 7,   // Level (sisa)
            'O' => 35,  // Rencana Tindakan / Mitigasi
        ];

        foreach ($columnWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // ===== ROW HEIGHTS =====
        // Baris 1: judul + nomor dokumen
        // Baris 2: header kolom tabel
        // Baris 3: sub-header kolom tabel
        $sheet->getRowDimension(1)->setRowHeight(40);
        $sheet->getRowDimension(2)->setRowHeight(30);
        $sheet->getRowDimension(3)->setRowHeight(25);

        // ===== JUDUL BESAR — A1:O1 (full width) =====
        $sheet->mergeCells('A1:O1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '000000']],
            'alignment' => [
                'horizontal' => StyleAlignment::HORIZONTAL_CENTER,
                'vertical'   => StyleAlignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '56DBC5'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // ===== MERGE HEADER KOLOM No, Bagian, dst (A2:A3, B2:B3, ...) =====
        $mergeColsSingle = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'O'];
        foreach ($mergeColsSingle as $col) {
            $sheet->mergeCells("{$col}2:{$col}3");
        }

        // ===== MERGE HEADER GRUP =====
        $sheet->mergeCells('J2:K2'); // Tindakan Terhadap Risiko
        $sheet->mergeCells('L2:N2'); // Sisa Risiko

        // ===== STYLE HEADER TABEL (baris 2 & 3) =====
        $sheet->getStyle('A2:O3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 9],
            'alignment' => [
                'horizontal' => StyleAlignment::HORIZONTAL_CENTER,
                'vertical'   => StyleAlignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A6F119'],
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // ===== BORDER & WRAP DATA (baris 4 ke bawah) =====
        $highestRow = $sheet->getHighestRow();
        if ($highestRow >= 4) {
            $sheet->getStyle("A4:O{$highestRow}")->applyFromArray([
                'alignment' => [
                    'vertical' => StyleAlignment::VERTICAL_TOP,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
                'font' => ['size' => 9],
            ]);

            // Kolom numerik center
            foreach (['A', 'G', 'H', 'I', 'L', 'M', 'N'] as $col) {
                $sheet->getStyle("{$col}4:{$col}{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
            }
        }

        // ===== FREEZE PANES (header tetap saat scroll) =====
        $sheet->freezePane('A4');
    }
}