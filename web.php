<?php

use Illuminate\Support\Facades\Route;

use App\Exports\SampleRepliesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\ReplyImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/export-existing-replies', [ReplyImportController::class, 'exportExistingReplies']);
Route::post('/import-replies', [ReplyImportController::class, 'import']);
Route::get('/download-sample', function () {
    return Excel::download(new SampleRepliesExport(), 'sample_replies.xlsx');
});
Route::get('/import-form', function () {
    return view('import');
});
