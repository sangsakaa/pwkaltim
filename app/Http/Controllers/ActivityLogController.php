<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
{
        $query = Activity::query();

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->latest()->paginate(5);
        

    return view('administrator.activity-logs.index', [
            'logs' => Activity::latest()->paginate(5),
        ]);
}
}
