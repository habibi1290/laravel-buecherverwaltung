<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;

//ddev composer require maatwebsite/excel
class ExportController extends Controller
{
    public function exportBooks()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }
}
