<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;

class ExportController extends Controller
{
    public function twos()
    {
        return new ItemsExport('twos.xlsx', 2);
    }

    public function sevens()
    {
        return new ItemsExport('sevens.xlsx', 7);
    }

    public function others()
    {
        return new ItemsExport('others.xlsx');
    }
}
