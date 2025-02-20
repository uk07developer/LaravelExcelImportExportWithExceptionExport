<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class FailedRepliesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Device ID', 'Template ID', 'Keyword', 'Reply', 'Match Type', 'Reply Type', 'API Key', 'Error'];
    }

    public function map($row): array
    {
        return [
            $row['device_id'] ?? '',
            $row['template_id'] ?? '',
            $row['keyword'] ?? '',
            $row['reply'] ?? '',
            $row['match_type'] ?? '',
            $row['reply_type'] ?? '',
            $row['api_key'] ?? '',
            $row['error'] ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Apply styles
        $sheet->getStyle('1:1')->getFont()->setBold(true); // Make header row bold
        $sheet->getStyle("A1:$highestColumn$highestRow")->getAlignment()->setWrapText(true); // Enable wrap text for all cells

        // Apply red text for error column
        $sheet->getStyle('H:H')->getFont()->getColor()->setARGB('FFFF0000'); // Red text for error column
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,  // Device ID
            'B' => 20,  // Template ID
            'C' => 15,  // Keyword
            'D' => 30,  // Reply
            'E' => 15,  // Match Type
            'F' => 15,  // Reply Type
            'G' => 10,  // API Key
            'H' => 40,  // Error
        ];
    }
}
