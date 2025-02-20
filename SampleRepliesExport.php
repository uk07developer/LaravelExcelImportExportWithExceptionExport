<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class SampleRepliesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return collect([
            [
                'device_id'   => '2', // Example Device ID
                'template_id' => '3', // Example Template ID
                'keyword'     => 'Hello',
                'reply'       => 'Hi there!',
                'match_type'  => 'exact', // Options: exact, contains, starts_with, ends_with
                'reply_type'  => 'text', // Options: text, image, video, document
                'api_key'     => 'abc123',
            ]
        ]);
    }

    public function headings(): array
    {
        return ['Device ID', 'Template ID', 'Keyword', 'Reply', 'Match Type', 'Reply Type', 'API Key'];
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
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Apply styles
        $sheet->getStyle('1:1')->getFont()->setBold(true); // Make header row bold
        $sheet->getStyle("A1:$highestColumn$highestRow")->getAlignment()->setWrapText(true); // Enable wrap text for all cells
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
        ];
    }
}
