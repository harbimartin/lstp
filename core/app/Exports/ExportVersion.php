<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportVersion implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $version_data;
    public function __construct($version_data){
        $this->version_data = $version_data;
    }

    public function collection(){
        return $this->version_data;
    }
    public function map($row): array{
        $fields = [
            $row->budget_period,
            $row->NAME,
            $row->version_type,
            $row->budget_version_code,
            $row->budget_name,
            $row->budget==0 ? '0':$row->budget,
            $row->realisasi_budget==0 ? '0':$row->realisasi_budget,
            $row->sisa_budget==0 ? '0':$row->sisa_budget,
            $row->status ? 'AKTIF' : 'NON-AKTIF'
         ];
        return $fields;
    }
    public function headings():array{
        return [
            'Periode',
            'Divisi',
            'Tipe Budget',
            'Kode',
            'Nama',
            'Amount',
            'Realisasi Budget',
            'Sisa Budget',
            'Status'
        ];
    }
    public function columnFormats(): array{
        return [
            // 'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => '"Rp."#,##0.00',
            'G' => '"Rp."#,##0.00',
            'H' => '"Rp."#,##0.00'
        ];
    }
    public function styles(Worksheet $sheet){
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:I')->getAlignment()->setVertical('top');
        $sheet->getStyle('F1:H1')->getAlignment()->setHorizontal('right');
        // $sheet->getStyle('H1')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
    }
}
