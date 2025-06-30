<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $dataPengamal = \App\Models\Pengamal::count();
        return view('administrator/dashboard/dashboard',compact('dataPengamal'));
    }
    
}
