<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAllPPK implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $ppkCollection;

    public function __construct(Collection $ppkCollection)
    {
        $this->ppkCollection = $ppkCollection;
    }

    public function collection()
    {
        return $this->ppkCollection;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Terbit',
            'No. PPK',
            'Nama PPK',
            'Status PPK',
            'Target Verifikasi',
            'Departemen Inisiator',
            'Pembuat / Inisiator',
            'Penerima',
            'Departemen Penerima',
            'Alamat Email Penerima',
            'SISTEM',
            'PROSES',
            'PRODUK',
            'AUDIT',
            'CC Email',
            'Email Pengirim',
        ];
    }

    public function map($ppk): array
    {
        static $no = 1;
        $cekSistem  = strpos($ppk->jenisketidaksesuaian, 'SISTEM') !== false ? '✔' : '';
        $cekProses  = strpos($ppk->jenisketidaksesuaian, 'PROSES') !== false ? '✔' : '';
        $cekProduk  = strpos($ppk->jenisketidaksesuaian, 'PRODUK') !== false ? '✔' : '';
        $cekAudit   = strpos($ppk->jenisketidaksesuaian, 'AUDIT') !== false  ? '✔' : '';

        return [
            $no++,
            \Carbon\Carbon::parse($ppk->created_at)->format('d/m/Y'),
            $ppk->nomor_surat,
            $ppk->judul,
            $ppk->statusppk,
            $ppk->formppk2 && $ppk->formppk2->updated_at
                ? \Carbon\Carbon::parse($ppk->formppk2->updated_at)->addMonth()->format('d/m/Y')
                : '—',
            $ppk->divisipembuat,
            $ppk->pembuatUser->nama_user ?? '-',
            $ppk->penerimaUser->nama_user ?? '-',
            $ppk->divisipenerima,
            $ppk->emailpenerima,
            $cekSistem,
            $cekProses,
            $cekProduk,
            $cekAudit,
            $ppk->cc_email,
            $ppk->emailpembuat,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // 1) Tentukan lebar kolom secara manual
        $sheet->getColumnDimension('A')->setWidth(8);    // No
        $sheet->getColumnDimension('B')->setWidth(15);   // Tanggal Terbit
        $sheet->getColumnDimension('C')->setWidth(41);   // No. PPK
        $sheet->getColumnDimension('D')->setWidth(50);   // Nama PPK
        $sheet->getColumnDimension('E')->setWidth(21);   // Status PPK
        $sheet->getColumnDimension('F')->setWidth(18);   // Target Verifikasi
        $sheet->getColumnDimension('G')->setWidth(25);   // Departemen Inisiator
        $sheet->getColumnDimension('H')->setWidth(20);   // Pembuat / Inisiator
        $sheet->getColumnDimension('I')->setWidth(20);   // Penerima
        $sheet->getColumnDimension('J')->setWidth(25);   // Departemen Penerima
        $sheet->getColumnDimension('K')->setWidth(30);   // Alamat Email Penerima
        $sheet->getColumnDimension('L')->setWidth(10);   // SISTEM
        $sheet->getColumnDimension('M')->setWidth(10);   // PROSES
        $sheet->getColumnDimension('N')->setWidth(10);   // PRODUK
        $sheet->getColumnDimension('O')->setWidth(10);   // AUDIT
        $sheet->getColumnDimension('P')->setWidth(40);   // CC Email
        $sheet->getColumnDimension('Q')->setWidth(30);   // Email Pengirim

        $headerRange = "A1:Q1";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'BFBFBF'],
            ],
        ]);

        // 4) Pasang AutoFilter pada header:
        $sheet->setAutoFilter($headerRange);

        // 2) Wrap‐text untuk kolom D (Nama PPK)
        $sheet
            ->getStyle("D1:D{$highestRow}")
            ->getAlignment()
            ->setWrapText(true)
            // Agar wrap terbaca dari atas sel
            ->setVertical(Alignment::VERTICAL_TOP);

        // 6) Pastikan seluruh isi (A2:Q<akhir>) align ke atas (vertical top):
        if ($highestRow >= 2) {
            $sheet
                ->getStyle("A2:Q{$highestRow}")
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP);
        }

        // 7) Beri border tipis pada seluruh area (A1:Q<akhir>):
        $sheet
            ->getStyle("A1:Q{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
    }
}
