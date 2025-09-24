<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard stats API
     */
    public function dashboardStats(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));

        // User status constants (define if not in Model)
        $STATUS_APPROVED   = User::STATUS_APPROVED   ?? 'approved';
        $STATUS_SUSPENDED  = User::STATUS_SUSPENDED  ?? 'suspended';
        $STATUS_REJECTED   = User::STATUS_REJECTED   ?? 'rejected';
        $STATUS_PENDING    = User::STATUS_PENDING    ?? 'pending';

        // Basic stats
        $total     = User::count();
        $approved  = User::where('status', $STATUS_APPROVED)->count();
        $suspended = User::where('status', $STATUS_SUSPENDED)->count();
        $rejected  = User::where('status', $STATUS_REJECTED)->count();
        $pending   = User::where('status', $STATUS_PENDING)->count();

        // Payment related stats (dummy)
        $totalRegistered = $total;
        $paidUsers  = round($totalRegistered * 0.7); // 70% paid assumption
        $unpaidUsers = $totalRegistered - $paidUsers;

        // Year wise registration stats
        $yearlyStats = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total_registrations'),
            DB::raw('SUM(CASE WHEN status = "' . $STATUS_APPROVED . '" THEN 1 ELSE 0 END) as approved_count'),
            DB::raw('COUNT(*) * 100 as estimated_revenue')
        )
        ->groupBy(DB::raw('YEAR(created_at)'))
        ->orderBy('year', 'desc')
        ->get();

        // Department wise stats
        $departmentStats = UserInformation::select([
            DB::raw('SUM(CASE WHEN dept_takmil = 1 THEN 1 ELSE 0 END) as takmil_count'),
            DB::raw('SUM(CASE WHEN dept_ifta = 1 THEN 1 ELSE 0 END) as ifta_count'),
            DB::raw('SUM(CASE WHEN dept_hifz = 1 THEN 1 ELSE 0 END) as hifz_count'),
            DB::raw('SUM(CASE WHEN dept_qirat = 1 THEN 1 ELSE 0 END) as qirat_count')
        ])->first();

        // Recent registrations (last 7 days)
        $recentRegistrations = User::with(['information'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Recent updates (users who updated info in last 7 days)
        $recentUpdates = User::with(['information'])
            ->whereHas('information', function($query) {
                $query->where('updated_at', '>=', Carbon::now()->subDays(7));
            })
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        // Combined recent activities (registrations + updates)
        $recentActivities = collect();

        foreach ($recentRegistrations as $user) {
            $recentActivities->push([
                'id' => $user->id,
                'name' => $user->fullNameBangla,
                'father_name' => $user->fatherName,
                'roll_number' => $user->information->rollNumber ?? 'N/A',
                'workplace' => $user->information->workplace ?? 'N/A',
                'blood_group' => $user->information->bloodGroup ?? 'N/A',
                'status' => $user->status,
                'activity_type' => 'registration',
                'activity_time' => $user->created_at,
                'activity_text' => 'নতুন নিবন্ধন'
            ]);
        }

        foreach ($recentUpdates as $user) {
            $recentActivities->push([
                'id' => $user->id,
                'name' => $user->fullNameBangla,
                'father_name' => $user->fatherName,
                'roll_number' => $user->information->rollNumber ?? 'N/A',
                'workplace' => $user->information->workplace ?? 'N/A',
                'blood_group' => $user->information->bloodGroup ?? 'N/A',
                'status' => $user->status,
                'activity_type' => 'update',
                'activity_time' => $user->information->updated_at,
                'activity_text' => 'তথ্য হালনাগাদ'
            ]);
        }

        $recentActivities = $recentActivities->sortByDesc('activity_time')->take(15)->values();

        // Monthly trend (last 12 months)
        $monthlyTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count();
            $monthlyTrend[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }

        $lastMonth = now()->subMonth();
        $totalLastMonth = User::where('created_at', '<', $lastMonth)->count();
        $approvedLastMonth = User::where('created_at', '<', $lastMonth)->where('status', $STATUS_APPROVED)->count();

        $percent = function($now, $last) {
            if ($last == 0) return '+0%';
            $change = (($now - $last) / $last) * 100;
            $sign = $change >= 0 ? '+' : '';
            return $sign . number_format($change, 1) . '%';
        };

        return response()->json([
            'stats' => [
                [
                    'title' => 'মোট নিবন্ধিত',
                    'value' => number_format($total),
                    'change' => $percent($total, $totalLastMonth),
                    'icon' => 'users',
                    'color' => 'bg-blue-500'
                ],
                [
                    'title' => 'অনুমোদিত',
                    'value' => number_format($approved),
                    'change' => $percent($approved, $approvedLastMonth),
                    'icon' => 'check-circle',
                    'color' => 'bg-green-500'
                ],
                [
                    'title' => 'অপেক্ষমান',
                    'value' => number_format($pending),
                    'change' => $total > 0 ? '+' . number_format(($pending / $total) * 100, 1) . '%' : '+0%',
                    'icon' => 'clock',
                    'color' => 'bg-yellow-500'
                ],
                [
                    'title' => 'পেমেন্ট বাকি',
                    'value' => number_format($unpaidUsers),
                    'change' => $total > 0 ? number_format(($unpaidUsers / $total) * 100, 1) . '%' : '0%',
                    'icon' => 'credit-card',
                    'color' => 'bg-red-500'
                ]
            ],
            'yearlyStats'      => $yearlyStats,
            'departmentStats'  => $departmentStats,
            'recentActivities' => $recentActivities,
            'monthlyTrend'     => $monthlyTrend,
            'paymentStats'     => [
                'total'    => $totalRegistered,
                'paid'     => $paidUsers,
                'unpaid'   => $unpaidUsers,
                'revenue'  => $paidUsers * 100 // Assuming 100 Taka per registration
            ]
        ]);
    }

    /**
     * Return static notices for dashboard
     */
    // public function notices()
    // {
    //     $notices = [
    //         [
    //             'id' => 1,
    //             'title' => 'নতুন রেজিস্ট্রেশন নীতিমালা',
    //             'content' => 'সকল ছাত্রদের জানানো যাচ্ছে যে নতুন রেজিস্ট্রেশন নীতিমালা অনুযায়ী...',
    //             'type' => 'important',
    //             'created_at' => now()->subDays(2)->format('Y-m-d H:i:s')
    //         ],
    //         [
    //             'id' => 2,
    //             'title' => 'পরীক্ষার সময়সূচী',
    //             'content' => 'আগামী মাসের পরীক্ষার সময়সূচী প্রকাশিত হয়েছে...',
    //             'type' => 'info',
    //             'created_at' => now()->subDays(5)->format('Y-m-d H:i:s')
    //         ],
    //         [
    //             'id' => 3,
    //             'title' => 'ছুটির দিন ঘোষণা',
    //             'content' => 'আগামী সপ্তাহে ২ দিন ছুটি থাকবে...',
    //             'type' => 'general',
    //             'created_at' => now()->subWeek()->format('Y-m-d H:i:s')
    //         ]
    //     ];
    //     return response()->json(['notices' => $notices]);
    // }
}