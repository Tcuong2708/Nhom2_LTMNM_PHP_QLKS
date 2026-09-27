<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminStatisticalController extends Controller
{
    public function index()
    {
        // Dummy data for statistical view, we'll just render the template
        return view('admin.statistical.index');
    }
}
