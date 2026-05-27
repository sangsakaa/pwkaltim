<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengamal;
use Illuminate\Http\Request;

class PengamalApiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        abort_unless(
            $user?->hasAnyRole([
                'superAdmin',
                'admin-provinsi',
                'admin-kabupaten',
                'admin-kecamatan',
                'admin-desa',
            ]),
            403,
            'Unauthorized'
        );

        $query = Pengamal::query()
            ->with(Pengamal::relations())
            ->byUserRole($user);

        return response()->json([
            'success' => true,
            'total'   => $query->count(),
            'data'    => $query->get(),
        ]);
    }
}
