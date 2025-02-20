<?php
namespace App\Imports;

use App\Models\Reply;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class RepliesImport implements ToCollection, WithHeadingRow, WithValidation, WithUpserts, SkipsOnFailure
{
    use SkipsFailures;

    private $failedRows = [];

    public function collection(Collection $rows)
    {
        $user_id = auth()->user()->id;
        foreach ($rows as $row) {
            Reply::updateOrCreate(
                [
                    'user_id'     => $user_id,
                    'device_id'   => $row['device_id'],
                    'keyword'     => $row['keyword'],
                ], // Unique constraint for upsert
                [
                    'template_id' => $row['template_id'],
                    'reply'       => $row['reply'],
                    'match_type'  => $row['match_type'],
                    'reply_type'  => $row['reply_type'],
                    'api_key'     => $row['api_key'],
                ]
            );
        }
    }

    /**
     * ✅ Implemented required method for WithUpserts
     * Defines the unique columns for upsert.
     */
    public function uniqueBy()
    {
        return ['user_id', 'device_id', 'keyword'];
    }


    public function rules(): array
    {
        return [
            'device_id'   => 'required|integer|exists:devices,id',
            'template_id' => 'nullable|integer|exists:templates,id',
            'keyword'     => 'required|max:255',
            'reply'       => 'required|string',
            'match_type'  => 'required|in:like,equal', // ✅ Updated to only accept "like" or "equal"
            'reply_type'  => 'required|in:text,image,video,document',
            'api_key'     => 'nullable|string|max:255',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failedRows = array_merge($this->failedRows, $failures);
    }

    public function getFailedRows()
    {
        return $this->failedRows;
    }
}
