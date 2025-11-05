<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateUserReport()
{
    $users = User::select('role', DB::raw('count(*) as count'))
        ->groupBy('role')
        ->get();

    $reportData = [
        'total_users' => User::count(),
        'users_by_role' => $users,
        'generated_at' => now()->format('Y-m-d H:i:s')
    ];

    return response()->json($reportData);
}

public function generateActivityReport()
{
    $activity = [
        'new_users_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
        'new_notes_this_month' => Note::where('created_at', '>=', now()->startOfMonth())->count(),
        'pending_notes' => Note::whereNull('approved_at')->count(),
        'total_downloads' => 0, // You can track this later
    ];

    return response()->json($activity);
}

public function downloadReport(Request $request)
{
    $type = $request->get('type', 'users');

    if ($type === 'users') {
        $data = $this->generateUserReport()->getData();
        $filename = 'user-report-' . now()->format('Y-m-d') . '.json';
    } else {
        $data = $this->generateActivityReport()->getData();
        $filename = 'activity-report-' . now()->format('Y-m-d') . '.json';
    }

    return response()->json($data, 200, [
        'Content-Type' => 'application/json',
        'Content-Disposition' => "attachment; filename={$filename}",
    ]);
}
}
