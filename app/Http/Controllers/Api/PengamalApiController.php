<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengamal;
use Illuminate\Http\Request;

class PengamalApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengamal::query()->with([
            'province',
            'regency',
            'district',
            'village'
        ]);

        return response()->json([
            'success' => true,
            'total' => $query->count(),
            'data' => $query->get(),
        ]);
    }
}
