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

class ExportOverview implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $budget_data;
    public function __construct($budget_data){
        $this->budget_data = $budget_data;
    }

    public function collection(){
        return $this->budget_data;
    }
    public function map($row): array{
        $fields = [
            Date::stringToExcel($row->budget_date),
            $row->budget_code,
            $row->banfn,
            $row->doc_types->doc_type_desc,
            $row->budget_versions->budget_version_code,
            $row->note_header,
            $row->total_proposed==0 ? '0':$row->total_proposed,
            $row->total_verified==0 ? '0':$row->total_verified,
            $row->budget_status,
         ];
        return $fields;
    }
    public function headings():array{
        return [
            'Budget Date',
            'No. MRA',
            'No. PR',
            'Document Type',
            'Budget Version',
            'Text Header',
            'Total Proposed',
            'Total Verified',
            'Status',
        ];
    }
    public function columnFormats(): array{
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'G' => '"Rp."#,##0.00',
            'H' => '"Rp."#,##0.00'
        ];
    }
    public function styles(Worksheet $sheet){
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A:D')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A:I')->getAlignment()->setVertical('top');
        $sheet->getStyle('G1:H1')->getAlignment()->setHorizontal('right');
        // $sheet->getStyle('H1')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('I')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
    }
}
