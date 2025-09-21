<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function getStats()
    {
        // Total users
        $totalUsers = User::count();
        // Approved users (approved_by not null)
        $approvedUsers = User::whereNotNull('approved_by')->count();
        // Yearly batch calculation
        $baseYear = 1955; // 1st batch
        $currentYear = Carbon::now()->year;
        $batchNumber = ($currentYear - $baseYear) + 1;

        return response()->json([
            'total_users' => $totalUsers,
            'approved_users' => $approvedUsers,
            'batch_number' => $batchNumber,
        ]);
    }
}
