<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\RepliesImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Reply;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\ExistingRepliesExport;
use App\Exports\FailedRepliesExport;


class ReplyImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $import = new RepliesImport();

        try {
            Excel::import($import, $request->file('file'));

            if (!empty($import->getFailedRows())) {
                return $this->downloadFailedRows($import->getFailedRows());
            }

            return response()->json(['message' => 'Import successful'], 200);
        } catch (ValidationException $e) {
            return $this->downloadFailedRows($e->failures());
        }
    }

    public function downloadFailedRows(array $failures)
    {
        $failedData = collect($failures)->map(function ($failure) {
            return array_merge($failure->values(), ['error' => implode(',', $failure->errors())]);
        });

        return Excel::download(new FailedRepliesExport($failedData), 'failed_import.xlsx');
    }

    public function exportExistingReplies()
    {
        return Excel::download(new ExistingRepliesExport(), 'existing_replies.xlsx');
    }
}
