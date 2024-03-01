<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    public function export(Request $request)
    {
        return Excel::download(new TicketsExport($request), 'data_table.xlsx');
    }
}
